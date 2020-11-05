<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PotController extends AbstractController
{
    /**
     * @Route("/pots", name="pots")
     */
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        return $this->render('pot/index.html.twig', [
            "Pots" => $user->getPot(),
            'controller_name' => 'PotController',
        ]);
    }
}
