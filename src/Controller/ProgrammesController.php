<?php

namespace App\Controller;

use App\Entity\Programmes;
use App\Form\ProgrammesType;
use App\Repository\ProgrammesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/programmes")
 */
class ProgrammesController extends AbstractController
{
    /**
     * @Route("/", name="programmes_index", methods={"GET"})
     */
    public function index(ProgrammesRepository $programmesRepository): Response
    {
        return $this->render('programmes/index.html.twig', [
            'programmes' => $programmesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="programmes_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserInterface $user): Response
    {
        $programme = new Programmes();
        $form = $this->createForm(ProgrammesType::class, $programme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setProgrammes('Un programme');
         
            $entityManager->persist($programme);
            $entityManager->flush();

            return $this->redirectToRoute('programmes_index');
        }

        return $this->render('programmes/new.html.twig', [
            'programme' => $programme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="programmes_show", methods={"GET"})
     */
    public function show(Programmes $programme): Response
    {
        return $this->render('programmes/show.html.twig', [
            'programme' => $programme,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="programmes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Programmes $programme): Response
    {
        $form = $this->createForm(ProgrammesType::class, $programme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('programmes_index');
        }

        return $this->render('programmes/edit.html.twig', [
            'programme' => $programme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="programmes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Programmes $programme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$programme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($programme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('programmes_index');
    }
}
