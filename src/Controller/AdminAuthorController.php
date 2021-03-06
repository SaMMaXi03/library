<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAuthorController extends AbstractController
{
    /**
     * @Route("/admin/insert-author", name="admin_insert_author")
     */
    public function insertAuthors(EntityManagerInterface $entityManager, Request $request): Response
    {
        $author = new Author();

        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($author);
            $entityManager->flush();

            $this->addFlash('success','author saved !');
        }

        return $this->render('admin/insert_author.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/authors", name="admin_list_authors")
     */
    public function listAuthors(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();

        return $this->render('admin/list_authors.html.twig', [
            'authors' => $authors
        ]);
    }

    /**
     * @Route("admin/authors/{id}", name="admin_show_author")
     */
    public function showAuthor($id, AuthorRepository $authorRepository): Response
    {
        $author = $authorRepository->find($id);

        return $this->render('admin/show_author.html.twig', [
            'author' => $author
        ]);
    }

    /**
     * @Route("/admin/author/delete/{id}", name="admin_delete_author")
     */
    public function deleteAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $author = $authorRepository->find($id);

        if (!is_null($author)) {
            $entityManager->remove($author);
            $entityManager->flush();

            $this->addFlash('success', 'Author is delete');
        } else {
            $this->addFlash('error', 'Author lost ');
        }
        return $this->redirectToRoute('admin_list_authors');
    }

    /**
     * @Route("/admin/authors/update/{id}", name="admin_update_author")
     */
    public function updateAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $author = $authorRepository->find($id);

        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($author);
            $entityManager->flush();

            $this->addFlash("success", " Cat??gorie modifi??e ! ");
        }

        return $this->render("admin/update_author.html.twig", ["form" => $form->createView()
        ]);
    }
}