<?php

namespace App\Controller\Api;

use App\Entity\Pot;
use App\Entity\PotLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/pot")
 */
class PotApiController extends AbstractController
{
    /**
     * @Route("/addData", name="api_addData")
     */
    public function addData(Request $request,  EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        if ($request->headers->has("X-AUTH-ID")){
            $id = $request->headers->get("X-AUTH-ID");

            $Pot = $entityManager->getRepository(Pot::class)->findOneBy(["uuid" => $id]);

            if ($Pot instanceof Pot){
                $PotLog = new PotLog();
                $string = file_get_contents('php://input');
                $aResponse = json_decode($string, true);
                if (
                    isset($aResponse["Luchtvochtigheid"]) &&
                    isset($aResponse["Temperatuur"]) &&
                    isset($aResponse["Waterniveau"]) &&
                    isset($aResponse["Lichtsterkte1"]) &&
                    isset($aResponse["Lichtsterkte2"]) &&
                    isset($aResponse["Lichtsterkte3"]) &&
                    isset($aResponse["Grondvochtigheid"])
                ){
                    $PotLog
                        ->setHumidity((int)$aResponse["Luchtvochtigheid"])
                        ->setLuminosity1((int)$aResponse["Lichtsterkte1"])
                        ->setLuminosity2((int)$aResponse["Lichtsterkte1"])
                        ->setLuminosity3((int)$aResponse["Lichtsterkte1"])
                        ->setPH(random_int(50,100))
                        ->setResevoir((int)$aResponse["Waterniveau"])
                        ->setSoilMoistureBottom(random_int(50,100))
                        ->setSoilMoistureMiddel((int)$aResponse["Grondvochtigheid"])
                        ->setSoilMoistureTop(random_int(50,100))
                        ->setTemperature((int)$aResponse["Temperatuur"])
                        ->setAddedDate(new \DateTime());


                    $Pot->addPotLog($PotLog);


                    $entityManager->persist($PotLog);
                    $entityManager->flush();
                    return new JsonResponse(["Log" => $serializer->serialize($PotLog, "json")],200);
                } else {
                    return new JsonResponse("Missing values", 400);
                }
            }
        }
        return new JsonResponse("Pot not found", 404);
    }
}
