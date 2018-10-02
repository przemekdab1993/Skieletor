<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SkieletorController extends AbstractController
{
    /**
     * @Route("/skieletor", name="skieletor")
     */
    public function index()
    {
        return $this->render('skieletor/index.html.twig', [
            'controller_name' => 'SkieletorController',
        ]);
    }
}
