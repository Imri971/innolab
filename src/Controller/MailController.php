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

        if ($form->isSubmitted() && $form->isValid()) {
            
            $datas = $form->getData();
            dump($datas);
            $date = new \DateTime();
            
            $message = (new \Swift_Message('Innolab'))
            ->setFrom('imribalourd@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    // templates/mail/mail.html.twig
                    'mail/mail.html.twig',
                    ['name' => $user->getName(),
                     'email' => $user->getEmail(),
                     'message' => $datas['message'],
                     'date' => $date
                    ]
                )
            ,
            'text/html'
            );
            $mailer->send($message);

            return $this->redirectToRoute('innolab');
        }

        return $this->render('mail/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/confirm", name="confirm")
     */
    public function confirm(Request $request, UserInterface $user,  \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ConfirmType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $datas = $form->getData();
            dump($datas);

            $confirm = (new \Swift_Message('Innolab'))
            ->setFrom('imribalourd@gmail.com')
            ->setTo('jeremie_1998@hotmail.fr')
            ->setBody(
            "Un nouvel inscrit au programme : ".$user->getName()
            ,
            'text/html'
            );
            $mailer->send($confirm);

            return $this->redirectToRoute('innolab');
        }

        return $this->render('mail/confirm.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
