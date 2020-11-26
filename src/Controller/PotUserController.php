<?php

namespace App\Controller;

use App\Entity\Pot;
use App\Entity\PotLog;
use App\Entity\User;
use App\Form\PotType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class PotUserController extends AbstractController
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
        return $this->render('potUser/index.html.twig', [
            "Pots" => $user->getPot(),
            'controller_name' => 'PotController',
        ]);
    }

    /**
     * @Route("/pots/add", name="pots_add")
     */
    public function add(Request $request, Security $security, SerializerInterface $serializer): Response
    {
        if ($request->isXmlHttpRequest()){
            $GivenId = $request->request->get("id", 00);
            $Pot = $this->getDoctrine()->getManager()->getRepository(Pot::class)->findOneBy(["uuid" => $GivenId]);
            if ($Pot instanceof Pot){
                $Pot->setOwner($security->getUser());
                $this->getDoctrine()->getManager()->flush();
                return new JsonResponse($serializer->serialize($Pot, "json"), 202);
            } else {
                return new JsonResponse("",404);
            }
        }
        return $this->render('potUser/add.html.twig', [
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

                return $this->render('potUser/settings.html.twig', [
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
        return $this->render('potUser/analytics.html.twig', [
            "Pot" => $pot,
            "sJsonTimeLineData" => json_encode($this->getDoctrine()->getRepository(PotLog::class)->getTimeLineData($pot)),
            "Log" => $this->getDoctrine()->getRepository(PotLog::class)->getLatestLog($pot),
            'controller_name' => 'PotController',
        ]);
    }
}
