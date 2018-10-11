<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Entity\ProgrammationCircuit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontofficeHomeController extends AbstractController
{
    /**
     * @Route("/home", name="front")
     */
    public function index()
    {
        $progCircuits=$this->getDoctrine()->getRepository(ProgrammationCircuit::class)->findAll();
        return $this->render('front/home.html.twig', [
            'progCircuits' => $progCircuits,
        ]);
    }

    /**
     * Finds and displays a circuit entity
     * @Route("/circuit/{id}", name="front_circuit_show")
     */
    public function circuitShow($id){
        $em=$this->getDoctrine()->getManager();
        $progCircuit=$em->getRepository(ProgrammationCircuit::class)->find($id);
        dump($progCircuit);
        return $this->render("front/circuit_show.html.twig",[
            'progCircuit' => $progCircuit,
        ]);
    }
}

