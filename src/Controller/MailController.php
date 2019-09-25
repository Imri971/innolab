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
            
            
            $message = (new \Swift_Message('Innolab'))
            ->setFrom($user->getEmail())
            ->setTo('innolab62sample@gmail.com')
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

    
}
