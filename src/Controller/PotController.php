<?php

namespace App\Controller;

use App\Entity\Pot;
use App\Entity\PotLog;
use App\Entity\User;
use App\Form\PotType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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



    /**
     * @Route("/pot/{id}/settings", name="potSettings")
     */
    public function potEdit($id,Request $request): Response
    {
        $pot = $this->getDoctrine()->getRepository(Pot::class)->find($id);
        $form = $this->createForm(PotType::class, $pot);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pot);
            $entityManager->flush();
        }

        return $this->render('pot/settings.html.twig', [
            "Pot" => $pot,
            'controller_name' => 'PotController',
            "form" => $form->createView()
        ]);
    }


    /**
     * @Route("/pot/{id}/analytics", name="potAnalytics")
     */
    public function potAnalytics($id,Request $request): Response
    {
        $pot = $this->getDoctrine()->getRepository(Pot::class)->find($id);
        return $this->render('pot/analytics.html.twig', [
            "Pot" => $pot,
            "sJsonTimeLineData" => json_encode($this->getDoctrine()->getRepository(PotLog::class)->getTimeLineData($pot)),
            "Log" => $this->getDoctrine()->getRepository(PotLog::class)->getLatestLog($pot),
            'controller_name' => 'PotController',
        ]);
    }
}
