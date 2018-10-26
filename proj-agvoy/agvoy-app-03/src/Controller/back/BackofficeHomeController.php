<?php

namespace App\Controller\back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BackofficeHomeController extends AbstractController
{
    /**
     * @Route("/admin", name="back")
     */
    public function index()
    {
        return $this->render('back/index.html.twig');
    }
}
