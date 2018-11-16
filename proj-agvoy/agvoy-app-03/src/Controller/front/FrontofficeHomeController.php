<?php

namespace App\Controller\front;

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
        $circuits=$this->getDoctrine()->getRepository(Circuit::class)->findAll();
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

    /**
     * @Route("/circuit_like/{id}", name="front_circuit_like")
     */
    public function circuitLike($id){
        $em=$this->getDoctrine()->getManager();
        $progCircuit=$em->getRepository(ProgrammationCircuit::class)->find($id);
        $likes=$this->get('session')->get('likes');
        if ($likes==null){
            $likes=[];
        }
        if (! in_array($id, $likes) ) {
            $likes[] = $id;
            $this->get('session')->getFlashBag('message','Circuit ajouté aux likes');
        }
        else {
            $likes = array_diff($likes, array($id));
            $this->get('session')->getFlashBag('message',"Circuit enlevé des likes");
        }
        $this->get('session')->set('likes',$likes);
        dump($likes);
        return $this->render("front/circuit_show.html.twig",[
            'progCircuit'=>$progCircuit
        ]);
    }
    public function circuitList(){
        $em=$this->getDoctrine()->getManager();
        $progCircuits=$em->getRepository(ProgrammationCircuit::class)->findAll();
        return array(['progCircuits' => $progCircuits,]);
    }
}

