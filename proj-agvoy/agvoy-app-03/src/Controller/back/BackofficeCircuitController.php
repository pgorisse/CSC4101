<?php

namespace App\Controller\back;

use App\Entity\Circuit;
use App\Entity\Etape;
use App\Form\CircuitType;
use App\Form\EtapeType;
use App\Repository\CircuitRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/admin/circuit")
 */
class BackofficeCircuitController extends AbstractController
{
    /**
     * @Route("/", name="admin_circuit_index", methods="GET")
     */
    public function index(CircuitRepository $circuitRepository): Response
    {
        return $this->render('back/circuit/index.html.twig', ['circuits' => $circuitRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_circuit_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $circuit = new Circuit();
        $form = $this->createForm(CircuitType::class, $circuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($circuit);
            $em->flush();

            $this->get('session')->getFlashBag()->add('message',"Circuit $circuit bien ajouté!");

            return $this->redirectToRoute('admin_circuit_index');
        }

        return $this->render('back/circuit/new.html.twig', [
            'circuit' => $circuit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_circuit_show", methods="GET")
     */
    public function show(Circuit $circuit): Response
    {
        return $this->render('back/circuit/show.html.twig', ['circuit' => $circuit]);
    }

    /**
     * @Route("/{id}/edit", name="admin_circuit_edit", methods="GET|POST")
     */
    public function edit(Request $request, Circuit $circuit): Response
    {
        $form = $this->createForm(CircuitType::class, $circuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_circuit_edit', ['id' => $circuit->getId()]);
        }

        return $this->render('back/circuit/edit.html.twig', [
            'circuit' => $circuit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_circuit_delete", methods="DELETE")
     */
    public function delete(Request $request, Circuit $circuit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$circuit->getId(), $request->request->get('_token'))) {
            $circuitrip=$circuit;
            $em = $this->getDoctrine()->getManager();
            $em->remove($circuit);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('message',"Circuit $circuitrip supprimé!");

        return $this->redirectToRoute('admin_circuit_index');
    }
    /**
     * @Route("/{id}/addetape", name="admin_circuit_addetape")
     *
     */
    public function addEtape(Request $request, Circuit $circuit){

        $etape = new Etape();

        $form = $this->createForm(EtapeType::class, $etape, array('circuits_list'=>array("0"=>$circuit)));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($etape);
            $em->flush();
            $this->get('session')->getFlashBag()->add('message',"Etape $etape bien ajoutée!");
            return $this->redirectToRoute('admin_circuit_show',array('id'=>$circuit));
        }

        return $this->render('back/circuit/addEtape.html.twig',[
            'circuit' => $circuit,
            'form' => $form->createView()
        ]);
    }
}
