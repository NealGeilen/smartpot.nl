<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index(): Response
    {
        return new JsonResponse(["Hi"]);
    }

    /**
     * @Route("/api/{id}/addData", name="api_addData")
     */
    public function addData($id): Response
    {
        return new JsonResponse(["Hi--- Adding data" , $id]);
    }
}
