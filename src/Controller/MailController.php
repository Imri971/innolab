<?php

namespace App\Controller;

use App\Form\MailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(MailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $datas = $form->getData();
            dump($datas);

            $message = (new \Swift_Message('Innolab'))
            ->setFrom($datas['email'])
            ->setTo($datas['email'])
            ->setBody(
                $datas['name']." a envoyé: ".$datas['message']
            ,
            'text/html'
            );
            $mailer->send($message);
        }

        return $this->render('mail/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
