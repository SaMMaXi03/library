<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class FrontBookController extends AbstractController
{

    /**
     * @Route ("/book-list", name="book_list")
     */
    public function bookList(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        return $this->render('front/list_books.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route ("book-show/{id}", name="book_show")
     */

    public function bookShow($id, BookRepository $bookRepository): Response
    {
        $book = $bookRepository->find($id);
        return $this->render('front/show_book.html.twig', [
            'book' => $book
        ]);
    }
}