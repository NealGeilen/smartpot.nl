<?php

namespace App\Controller\Api;

use App\Entity\Device;
use App\Entity\Pot;
use App\Entity\PotLog;
use App\Repository\RoomPointsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\UuidV1;

/**
 * @Route("/api/user")
 */
class UserApiController extends AbstractController
{
    /**
     * @Route("/authenticate", name="user_authenticate")
     */
    public function authenticate(Security $security, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $Device = new Device();
        $Device->setUser($security->getUser());
        $Device->setToken(base64_encode(random_bytes(25)));
        $Device->setLastAction(new \DateTimeImmutable());

        $entityManager->persist($Device);
        $entityManager->flush();

        return new JsonResponse(["Token" => $Device->getToken()]);
    }


    /**
     * @Route("/room", name="user_room")
     */
    public function room(Security $security, Request $request, SerializerInterface $serializer): Response
    {
        return new JsonResponse($serializer->serialize($security->getUser()->getRooms(), "json"));
    }


    /**
     * @Route("/pot", name="user_pot")
     */
    public function pot(Security $security, Request $request, SerializerInterface $serializer): Response
    {
        return new JsonResponse($serializer->serialize($security->getUser()->getPot(), "json"));
    }


    /**
     * @Route("/room/{id}/points", name="room_points")
     */
    public function points($id,SerializerInterface $serializer, RoomPointsRepository $roomPointsRepository): Response
    {
        return new JsonResponse($serializer->serialize($roomPointsRepository->findBy(["Room" => $id]), "json"));
    }

    /**
     * @Route("/location", name="location")
     */
    public function location(SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $pdo =  new \PDO('mysql:host=' . $_ENV["DATABASE_HOST"] . ';dbname=' .$_ENV["DATABASE_NAME"], $_ENV["DATABASE_USER"], $_ENV["DATABASE_PASSWORD"]);
        $smtp = $pdo->prepare("SELECT * FROM room_points");
        if ($smtp->execute()){
            dd($smtp->fetchAll());
        } else {
            throw new \Error();
        }
        /**
         * SELECT * FROM ( SELECT *, ((( acos( sin(( 10 * pi()/180)) * sin((`latitude`* pi()/180)) + cos(( 10 * pi()/180)) * cos((`latitude`* pi()/180)) * cos((( 20 -`longitude`) * pi()/180)) )) *180/pi()) * 60 * 1.1515 * 1.609344) AS distance FROM `room_points`) markers WHERE distance <= 0.05
         */
        /**
         * SELECT *
        FROM (
        SELECT *,
        ((( acos(
        sin(( LATTITUDE * pi()/180)) * sin((`lat`* pi()/180)) +
        cos(( LATTITUDE * pi()/180)) * cos((`lat`* pi()/180)) *
        cos((( LONGITUDE -`lng`) * pi()/180))
        ))
         *180/pi()) * 60 * 1.1515 * 1.609344)
        AS distance FROM `room_points`) markers WHERE distance <= 0.05
         */
//        $query = $entityManager->createQuery("
//    SELECT p, (SELECT (p.Longitude * 10) FROM FROM App\Entity\RoomPoints p) AS test FROM App\Entity\RoomPoints p
//
//        ");
//        $query->setParameter("LONG", 00);
//        $query->setParameter("LAT", 00);
//        dd($query->getResult());
        return new JsonResponse($serializer->serialize([],"json"));
    }






}
