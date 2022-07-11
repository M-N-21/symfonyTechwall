<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig');
    }

    #[Route('/hello/{name}', name: 'app_hello')]
    public function hello($name): Response
    {
       return $this ->render('first/hello.html.twig', ['name' => $name]);
    }
    #[Route('/multi/{x<\d+>}/{y}', name: 'multi', requirements: ['y' => '\d+'])]
    public function multi($x, $y): Response
    {
        return new Response("<h1>$x x $y = ".$x*$y."</h1>");
    }
}
