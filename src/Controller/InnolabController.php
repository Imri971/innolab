<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\img;
class InnolabController extends AbstractController
{
    /**
     * @Route("/", name="innolab")
     */
    public function index()
    {
        return $this->render('innolab/index.html.twig', [
            'controller_name' => 'InnolabController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('innolab/contact.html.twig', [
            'controller_name' => 'InnolabController',
        ]);
    }
}
