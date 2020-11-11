<?php

namespace App\Controller;

use App\Entity\Pot;
use App\Entity\PotLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aData = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR ."data.json"), true);
        $string = file_get_contents('php://input');
        $aResponse = json_decode($string, true);
        if (json_last_error() !== JSON_ERROR_NONE){
            return new JsonResponse("JSON NOT VALID", 400);
        }
        $aData[] = $aResponse;
        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR ."data.json", json_encode($aData));





        return new JsonResponse($aResponse);
    }

    /**
     * @Route("/api/addData", name="api_addData")
     */
    public function addData(Request $request,  EntityManagerInterface $entityManager): Response
    {
        if ($request->headers->has("X-AUTH-ID")){
            $id = $request->headers->get("X-AUTH-ID");

            $Pot = $entityManager->getRepository(Pot::class)->findOneBy(["uuid" => $id]);

            if ($Pot instanceof Pot){
                $PotLog = new PotLog();

                $PotLog
                    ->setHumidity($request->request->get("Luchtvochtigheid"))
                    ->setLuminosity($request->request->get("Lichtsterkte"))
                    ->setPH("")
                    ->setResevoir("")
                    ->setSoilMoistureBottom("")
                    ->setSoilMoistureMiddel("")
                    ->setSoilMoistureTop("")
                    ->setTemperature($request->request->get("Temperatuur"));


                $Pot->addPotLog($PotLog);


                $entityManager->persist($PotLog);
                $entityManager->flush();

                return new JsonResponse(["Log" => $PotLog],200);

            }
        }
        return new JsonResponse("Pot not found", 404);

    }
}
