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

    /**
     * @Route("/confirm", name="confirm", methods={"GET", "POST"})
     */
    public function confirm(Request $request, UserInterface $user,  \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ConfirmType::class);
        $form->handleRequest($request);
        $date= new \DateTime();
        if ($form->isSubmitted() && $form->isValid()) {
            
            $datas = $form->getData();
            
            $confirm = (new \Swift_Message('Innolab'))
            ->setFrom($user->getEmail())
            ->setTo('innolab62sample@gmail.com')
            ->setBody(
                $this->renderView(
                    // templates/mail/mailAdmin.html.twig
                    'mail/mailAdmin.html.twig',
                    ['name' => $user->getName(),
                     'email' => $user->getEmail(),
                     'tel' => $user->getTel(),
                     'alias' => $user->getAlias(),
                     'date' => $date,
                     'creation' => $user->getCreatedAt()
                    ]
                )
            ,
            'text/html'
            );
            $mailer->send($confirm);
            $this->addFlash(
                'confirm',
                'Votre souscription à été validée '.$user->getName().". Notre équipe vous recontactera prochainement."
            );
            return $this->redirectToRoute('innolab');
        }

        return $this->render('mail/confirm.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
