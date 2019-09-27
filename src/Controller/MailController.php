<?php

namespace App\Controller;

use App\Form\MailType;
use App\Form\ConfirmType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, UserInterface $user = null, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(MailType::class);
        $form->handleRequest($request);
        $date = new \DateTime();
        if ($form->isSubmitted() && $form->isValid()) {
            
            $datas = $form->getData();
            dump($datas);
            
            
            $message = (new \Swift_Message($datas['objet']))
            ->setFrom($datas['email'])
            ->setTo('innolab62sample@gmail.com')
            ->setBody(
                $this->renderView(
                    // templates/mail/mail.html.twig
                    'mail/mail.html.twig',
                    ['name' => $datas['nom'],
                     'email' => $datas['email'],
                     'message' => $datas['message'],
                     'date' => $date
                    ]
                )
            ,
            'text/html'
            );
            $mailer->send($message);
            $this->addFlash(
                'contact',
                'Votre avons bien pris en compte votre message '.$datas['nom']."."
            );
            return $this->redirectToRoute('innolab');
        }

        return $this->render('mail/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
}
