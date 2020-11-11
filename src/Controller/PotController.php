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
     * @Route("/", name="home")
     */
    public function Home(Security $security): Response
    {
        if ($security->isGranted("IS_AUTHENTICATED_FULLY")){
            return $this->redirectToRoute('pots');
        } else {
            return $this->redirectToRoute('app_login');
        }
    }



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
    public function potEdit($id,Request $request, Security $security): Response
    {
        $pot = $this->getDoctrine()->getRepository(Pot::class)->find($id);
        if ($pot instanceof Pot){
            if ($pot->getOwner()->getId() === $security->getUser()->getId()){
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
            throw new \Exception("Not owner", 401);
        } else {
            throw new \Exception("Pot not found", 404);
        }
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
