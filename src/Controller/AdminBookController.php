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
use Symfony\Component\String\Slugger\SluggerInterface;

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
     * @Route("admin/insert_book", name="admin_insert_book")
     */
    public function insertBook(EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger): Response
    {
        $book = new Book();

        $form = $this->createForm(BookType::class,$book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image =$form->get('image')->getData();

            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $slugger->slug($originalFilename);

            $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

            $image->move(
                $this->getParameter('images_directory'),
                $newFilename
            );
            $book->setImage($newFilename);

            $entityManager->persist($book);
            $entityManager->flush();

            $this->addFlash('success','Livre enregistré');
        }

        return $this->render("admin/insert_book.html.twig", [
            'form'=> $form->createView()
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
    public function updateBook($id, BookRepository $bookRepository, EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger): Response
    {
        $book = $bookRepository->find($id);

        $form = $this->createForm(BookType::class,$book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            $safeFilename = $slugger->slug($originalFilename);

            $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

            $image->move(
                $this->getParameter('images_directory'),
                $newFilename
            );
            $book->setImage($newFilename);

            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('success', 'Vous avez bien modifié votre livre');
        }

        return $this->render("admin/update_book.html.twig", [
            'form'=> $form->createView(),
            'book'=> $book
        ]);
    }
}