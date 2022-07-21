<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // Création de la route vers l'accueil
    /**
     * @Route ("/", name="front_home")
     */
    public function home(BookRepository $bookRepository): Response
    {
        $lastBooks = $bookRepository->findBy([], ['id' => 'DESC'],3);
        return $this->render('front/home.html.twig', [
            'lastBooks' => $lastBooks
        ]);
    }

    /**
     * @Route ("/admin/", name="admin_home")
     */
    public function adminHome(BookRepository $bookRepository): Response
    {
        $lastBooks = $bookRepository->findBy([], ['id' => 'DESC'],3);
        return $this->render('admin/home.html.twig', [
            'lastBooks' => $lastBooks
        ]);
    }
}