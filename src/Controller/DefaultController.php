<?php

// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="_default_home")
     */
    public function home()
    {
        $number = random_int(0, 100);

        return $this->render('default/home.html.twig', [
            'number' => $number,
        ]);
    }
}
