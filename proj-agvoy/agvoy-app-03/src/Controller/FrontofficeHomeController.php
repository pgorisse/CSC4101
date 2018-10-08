<?php

namespace App\Controller;

use App\Entity\Circuit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontofficeHomeController extends AbstractController
{
    /**
     * @Route("/home", name="front")
     */
    public function index()
    {
        $circuits=$this->getDoctrine()->getRepository(Circuit::class)->findAll();
        return $this->render('front/home.html.twig', [
            'circuits' => $circuits,
        ]);
    }

    /**
     * Finds and displays a circuit entity
     * @Route("/circuit/{id}", name="front_circuit_show")
     */
    public function circuitShow($id){
        $em=$this->getDoctrine()->getManager();
        $circuit=$em->getRepository(Circuit::class)->find($id);
        dump($circuit);
        return $this->render("front/circuit_show.html.twig",[
            'circuit' => $circuit,
        ]);
    }
}

