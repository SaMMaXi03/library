<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchBarController extends AbstractController
{

    /**
     * @Route("search", name="search_bar")
     */
    public function searchBar(Request $request, AuthorRepository $authorRepository, BookRepository $bookRepository): \Symfony\Component\HttpFoundation\Response
    {
        $search = $request->query->get('search');
        $author = $authorRepository->searchByWord($search);
        $book = $bookRepository->searchByWord($search);

        return $this->render('admin/search_books.html.twig', [
            'authors' => $author,
            'books' => $book
        ]);
    }
}