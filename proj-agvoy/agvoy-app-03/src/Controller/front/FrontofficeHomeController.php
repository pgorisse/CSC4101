<?php

namespace App\Controller\front;

use App\Entity\Circuit;
use App\Entity\User;
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
        if($this->isGranted('ROLE_ADMIN')){
            $circuits=$this->getDoctrine()->getRepository(Circuit::class)->findAll();
            $circuits=array_diff($circuits,$progCircuits);
            return $this->render(
                'front/home.html.twig',
                [
                    'progCircuits' => $progCircuits,
                    'circuits' => $circuits,
                ]
            );
        }
        return $this->render('front/home.html.twig', [
            'progCircuits' => $progCircuits,
        ]);
    }

    /**
     * Finds and displays a circuit entity
     * @Route("/circuit/{id}", name="front_circuit_show")
     */

    public function circuitShow(ProgrammationCircuit $progCircuit){
        return $this->render("front/circuit_show.html.twig",[
            'progCircuit' => $progCircuit,
        ]);
    }

    /**
     * @Route("/circuit_like/{id}", name="front_circuit_like")
     */
    public function circuitLike($id){
        $em=$this->getDoctrine()->getManager();
        $user=$this->getUser();
        $progCircuit=$em->getRepository(ProgrammationCircuit::class)->find($id);
        //##########If the user user authenticated, we refer to it's account's likes, else to the session likes.
        if($user){
            $likes=$user->getLikes();
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
            $user->setLikes($likes);
            $em->persist($user);
            $em->flush();
        } else {
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
            $this->get('session')->set('likes', $likes);
        }

        return $this->render("front/circuit_show.html.twig",[
            'progCircuit'=>$progCircuit
        ]);
    }
    public function circuitList(){
        $em=$this->getDoctrine()->getManager();
        $progCircuits=$em->getRepository(ProgrammationCircuit::class)->findAll();
        return array(['progCircuits' => $progCircuits,]);
    }
    /**
     * @Route("/my_likes", name="front_likes")
     */
    public function myLikes(){
        $em=$this->getDoctrine()->getManager();
        if($this->getUser()){
            $likes_id=$this->getUser()->getLikes();
            dump($this->getUser()->getFirstname(), $this->getUser()->getId());
        } else{
            $likes_id=$this->get('session')->get('likes');
        }
        $likes=[];
        if ($likes_id != null) {
            foreach ($likes_id as $id) {
                $likes[] = $em->getRepository(ProgrammationCircuit::class)->find($id);
            }
        }
        return $this->render("front/likes.html.twig",[
           'likes'=>$likes
        ]);
    }
}

