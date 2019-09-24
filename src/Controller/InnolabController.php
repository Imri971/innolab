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
     * @Route("/program", name="program")
     */
    public function program()
    {
        return $this->render('innolab/program.html.twig', [
            'controller_name' => 'InnolabController',
        ]);
    }

}
