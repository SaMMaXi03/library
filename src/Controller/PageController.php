<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{

    /**
     * @Route("/", name="front_home");
     */

    public function frontHome(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('front/base.html.twig');
    }

    /**
     * @Route("/admin", name="admin_home");
     */

    public function adminHome(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('admin/base.html.twig');
    }

}