<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Контроллер домашней страницы
 */
class MainController extends AbstractController
{
    /**
     * Главная страница
     */
    #[Route('/', name: 'homepage')]
    public function homepage(): Response
    {
        return $this->render('main/homepage.html.twig');
    }
}