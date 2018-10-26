<?php
/**
 * Created by PhpStorm.
 * User: pierrick
 * Date: 17/10/18
 * Time: 12:35
 */

namespace App\Controller\front;
use App\Entity\ProgrammationCircuit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HeaderController extends AbstractController
{
    public function header(){
        $progCircuits=$this->getDoctrine()->getRepository(ProgrammationCircuit::class)->findAll();
        return $this->render('front/header.html.twig', [
            'progCircuits'=>$progCircuits,
        ]);
    }
}