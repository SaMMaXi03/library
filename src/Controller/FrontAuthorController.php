<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class FrontAuthorController extends AbstractController
{

    /**
     * @Route("/author-list", name="author_list")
     */
    public function authorList(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();

        return $this->render('front/list_authors.html.twig', [
            'authors' => $authors
        ]);
    }

    /**
     * @Route("/author-show/{id}", name="author_show")
     */
    public function authorShow($id, AuthorRepository $authorRepository): Response
    {
        $author = $authorRepository->find($id);
        return $this->render('front/show_author.html.twig', [
            'author' => $author
        ]);
    }
}