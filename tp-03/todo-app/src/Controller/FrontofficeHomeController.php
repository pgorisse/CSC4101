<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontofficeHomeController extends AbstractController
{
    /**
     * @Route("/frontoffice/home", name="frontoffice_home")
     */
    public function index()
    {
        return $this->render('frontoffice_home/index.html.twig', [
            'controller_name' => 'FrontofficeHomeController',
        ]);
    }
}
