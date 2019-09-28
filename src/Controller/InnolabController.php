<?php

namespace App\Controller;

use App\img;
use App\Form\ConfirmType;
use App\Entity\Programmes;
use App\Form\ChoixProgType;
use App\Form\ProgrammesType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InnolabController extends AbstractController
{
    /**
     * @Route("/", name="innolab")
     */
    public function index()
    {
        
        $pro = $this->getDoctrine()->getRepository(Programmes::class);
        
        $programmes = $pro->findAll();
        return $this->render('innolab/index.html.twig', [
            'programmes' => $programmes
        ]);
    }
    /**
     * @Route("/program", name="program")
     */
    public function program()
    {
        $pro = $this->getDoctrine()->getRepository(Programmes::class);
        
        $programmes = $pro->findAll();

        return $this->render('prog/program.html.twig', [
            'controller_name' => 'InnolabController',
            'programmes' => $programmes
        ]);
    }

    /**
     * @Route("/program/{id}", name="program_show", methods={"GET","POST"})
     */
    public function show(Programmes $programmes, ObjectManager $manager, Request $request ,  \Swift_Mailer $mailer,  UserInterface $user = null): Response
    {
        $form = $this->createForm(ChoixProgType::class);
        $form->handleRequest($request);
        
        $date = new \DateTime();
        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager = $this->getDoctrine()->getManager();
            $datas = $form->getData();
            
            $datas['name']= $programmes->getName();
            
            $user->setAlias($datas['name']);
            $manager->persist($user);
            $manager->flush();
           
            $confirm = (new \Swift_Message('Innolab 62'))
            ->setFrom('innolab62sample@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    // templates/mail/mailAdmin.html.html.twig
                    'mail/mailAdmin.html.html.twig',
                    ['name' => $user->getName(),
                     'email' => $user->getEmail(),
                     'tel' => $user->getTel(),
                     'programmes' => $programmes,
                     'date' => $date
                    ]
                ),
            'text/html'
            );
            $mailer->send($confirm);

            //$request->getSession()->getFlashBag()->add();
            $this->addFlash(
                'success',
                'Votre demande d\'informations sur le programme '.$user->getAlias().' a bien été prise en compte '.$user->getName()."."
            );
            return $this->redirectToRoute('innolab');
        }

        return $this->render('prog/show.html.twig', [
            'programmes' => $programmes,
            'form' => $form->createView()
        ]);
    }

    
}
