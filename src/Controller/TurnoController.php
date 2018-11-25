<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TurnoType;
use App\Entity\Turno;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;



class TurnoController extends AbstractController
{
    /**
     * @Route("/turno", name="turno")
     */
    public function index()
    {
        return $this->render('turno/index.html.twig');
    }

    /**
     * @Route("/turno/todos", name="turno_todos")
     */
    public function getAllTurnos()
    {
        $user = $this->getUser();
        $turnos = $user->getTurnos();
        $array = array();
        foreach ($turnos as $turno){
            array_push($array,$turno->toArray());
        }
        return $this->json($array);
    }

    /**
     * @Route("/turno/nuevo", name="nuevo_turno")
     */
    public function crearTurno(Request $request) {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // 1) build the form
        $turno = new Turno();
        $form = $this->createForm(TurnoType::class, $turno);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the Turno!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($turno);
            $entityManager->flush();            

            return $this->redirectToRoute('turno');
        }
        return $this->render(
            'turno/nuevo_turno.html.twig',
            ['form' => $form->createView(), 'titulo' => 'Nuevo Turno']
        );
    }
    
    /**
     * @Route("/turno/borrar/{id}", name="borrar_turno")
     */
    public function borrarTurno($id) {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $this->getDoctrine()->getManager();
       
        $turno = $this->getDoctrine()
            ->getRepository(Turno::class)
            ->find($id);
        
        if (!$turno) {
            throw $this->createNotFoundException(
                'El turno no ha sido encontrado '
            );
        }
        $entityManager->remove($turno);
        $entityManager->flush();
        
        return $this->redirectToRoute('turno');
    }

    /**
     * @Route("/turno/editar/{id}", name="editar_turno")
     */
    public function editarTurno($id,Request $request) {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager = $this->getDoctrine()->getManager();       
        $turno = $entityManager
                ->getRepository(Turno::class)
                ->find($id);
        
        if (!$turno) {
            throw $this->createNotFoundException(
                'El Turno no ha sido encontrado'
            );
        } 
        $form = $this->createForm(TurnoType::class, $turno);

        // 2) handle the submit (will only happen on POST)

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the Turno!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();            

            return $this->redirectToRoute('turno');
        }
        return $this->render(
            'turno/nuevo_turno.html.twig',
            ['form' => $form->createView(), 'titulo' => 'Editar Turno']
        );
             

    }

    /**
     * @Route("/turno/{id}", name="leer_turno")
     */
    public function leerTurno($id) {
        $entityManager = $this->getDoctrine()->getManager();  
        $turno = $entityManager
                ->getRepository(Turno::class)
                ->find($id);
                
        if (!$turno) {
            throw $this->createNotFoundException(
            'El Turno no ha sido encontrada '
            );
        } 
        return $this->render(
            'turno/leer_turno.html.twig',
            ['turno' => $turno]
        );

    }

}
