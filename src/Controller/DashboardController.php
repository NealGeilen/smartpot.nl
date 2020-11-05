<?php

namespace App\Controller;

use App\Entity\Pot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseIsRedirected;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Security $security): Response
    {
        if ($security->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute('pots');
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
