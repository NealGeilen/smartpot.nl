<?php

namespace App\Controller;

use App\Entity\Pot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(UserPasswordEncoderInterface $userPassword): Response
    {
        $pot = new Pot();
        dd($userPassword->encodePassword($pot, "TEST"), $pot);
        return $this->render('inc/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
