<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBookController extends AbstractController
{
    /**
     * @Route("/admin/book/{id}", name="admin_book")
     */
    public function showBook(BookRepository $bookRepository, $id)
    {

        $book = $bookRepository->find($id);

        return $this->render('admin/show_book.html.twig', [
            'book' => $book
        ]);

    }

    /**
     * @Route("/admin/books", name="admin_books")
     */
    public function listBooks(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();

        return $this->render('admin/list_books.html.twig', [
            'books' => $books
        ]);
    }



    /**
     * @Route("/admin/insert-book", name="admin_insert_book")
     */
    public function insertBook(EntityManagerInterface $entityManager, Request $request)
    {
        // je créé une instance de la classe d'entité Article
        // dans le but de créer un article en BDD
        $book = new Book();

        // j'ai utilisé en ligne de commandes "php bin/console make:form"
        // pour que Symfony me créé une classe qui contiendra "le plan", "le patron"
        // du formulaire pour créer les articles. C'est la classe ArticleType
        // j'utilise la méthode $this->createForm pour créer un formulaire
        // en utilisant le plan du formulaire (ArticleType) et une instance d'Article
        $form = $this->createForm(BookType::class, $book);

        // On "donne" à la variable qui contient le formulaire
        // une instance de la classe  Request
        // pour que le formulaire puisse récupérer toutes les données
        // des inputs et faire les setters sur $article automatiquement
        $form->handleRequest($request);

        // si le formulaire a été posté et que les données sont valides (valeurs
        // des inputs correspondent à ce qui est attendu en bdd pour la table article)
        if ($form->isSubmitted() && $form->isValid()) {
            // alors on enregistre l'article en BDD
            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('success', 'book add !');
        }

        // j'affiche mon twig, en lui passant une variable
        // form, qui contient la vue du formulaire, c'est à dire,
        // le résultat de la méthode createView de la variable $form
        return $this->render("admin/insert_book.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/books/delete/{id}", name="admin_delete_book")
     */
    public function deleteBook($id, BookRepository $bookRepository, EntityManagerInterface $entityManager)
    {
        $book = $bookRepository->find($id);

        if (!is_null($book)) {
            $entityManager->remove($book);
            $entityManager->flush();

            $this->addFlash('success', 'You did delete the book !');
        } else {
            $this->addFlash('error', 'book not found!');
        }

        return $this->redirectToRoute('admin_books');
    }


    /**
     * @Route("/admin/books/update/{id}", name="admin_update_book")
     */
    public function updateBook($id, BookRepository $bookRepository, EntityManagerInterface $entityManager, Request $request)
    {
        $book = $bookRepository->find($id);

        $form = $this->createForm(BookType::class, $book);

        // On "donne" à la variable qui contient le formulaire
        // une instance de la classe  Request
        // pour que le formulaire puisse récupérer toutes les données
        // des inputs et faire les setters sur $article automatiquement
        $form->handleRequest($request);

        // si le formulaire a été posté et que les données sont valides (valeurs
        // des inputs correspondent à ce qui est attendu en bdd pour la table article)
        if ($form->isSubmitted() && $form->isValid()) {
            // alors on enregistre l'article en BDD
            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('success', 'Registered book!');
        }

        // j'affiche mon twig, en lui passant une variable
        // form, qui contient la vue du formulaire, c'est à dire,
        // le résultat de la méthode createView de la variable $form
        return $this->render("admin/update_book.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/book/search", name="admin_search_books")
     */
    public function searchBooks(Request $request, BookRepository $bookRepository)
    {
        // je récupère les valeurs du formulaire dans ma route
        $search = $request->query->get('search');

        // je vais créer une méthode dans l'ArticleRepository
        // qui trouve un article en fonction d'un mot dans son titre ou son contenu
        $books = $bookRepository->searchByWord($search);

        // je renvoie un fichier twig en lui passant les articles trouvé
        // et je les affiche

        return $this->render('admin/search_books.html.twig', [
            'books' => $books
        ]);
    }
}