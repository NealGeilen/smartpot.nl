<?php

namespace App\Controller;

use App\Entity\Pot;
use App\Entity\User;
use App\Helpers\QRHelper;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Uid\Uuid;
use App\Form\PotAdminType;
use App\Repository\PotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/pot")
 */
class PotAdminController extends AbstractController
{
    /**
     * @Route("/", name="pot_index", methods={"GET"})
     */
    public function index(PotRepository $potRepository): Response
    {
        return $this->render('pot/index.html.twig', [
            'pots' => $potRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pot_new", methods={"GET"})
     */
    public function new(UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $Password = sha1(random_bytes(12));
        $Pot = new Pot();
        $Pot
            ->setUuid(Uuid::v1())
            ->setPassword($passwordEncoder->encodePassword($Pot, $Password))
            ->setName("");

        $this->getDoctrine()->getManager()->persist($Pot);
        $this->getDoctrine()->getManager()->flush();
        return $this->render('pot/new.html.twig', [
            "Pot" => $Pot,
            "PotPassword" => $Password,
        ]);
    }

    /**
     * @Route("/{id}", name="pot_show", methods={"GET"})
     */
    public function show(Pot $pot): Response
    {
        return $this->render('pot/show.html.twig', [
            'pot' => $pot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pot_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pot $pot, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PotAdminType::class, $pot, ["Selected_Owner"=>$pot->getOwner(), "Users" => $entityManager->getRepository(User::class)->findAll()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $User = $this->getDoctrine()->getRepository(User::class)->find($request->request->get('pot_admin')["Owner"]);
            $pot->setOwner($User);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pot_index');
        }

        return $this->render('pot/edit.html.twig', [
            'pot' => $pot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pot_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Pot $pot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pot_index');
    }
}
