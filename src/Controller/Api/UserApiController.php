<?php

namespace App\Controller\Api;

use App\Entity\Device;
use App\Entity\Pot;
use App\Entity\PotLog;
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

}
