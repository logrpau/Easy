<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TiendaType;
use App\Entity\Tienda;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class TiendaController extends AbstractController
{
    /**
     * @Route("/tienda", name="tienda")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Tienda::class);
        $tiendas = $repository->findAll();
        return $this->render('tienda/index.html.twig', [
            'tiendas' => $tiendas
        ]);
    }

    /**
     * @Route("/tienda/nueva", name="nueva_tienda")
     */
    public function crearTienda(Request $request) {
        // 1) build the form
        $tienda = new Tienda();
        $form = $this->createForm(TiendaType::class, $tienda);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the Tienda!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tienda);
            $entityManager->flush();            

            return $this->redirectToRoute('tienda');
        }
        return $this->render(
            'tienda/nueva_tienda.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/tienda/borrar/{id}", name="borrar_tienda")
     */
    public function borrarTienda($id) {

        $entityManager = $this->getDoctrine()->getManager();
       
        $tienda = $this->getDoctrine()
            ->getRepository(Tienda::class)
            ->find($id);
        
        if (!$tienda) {
            throw $this->createNotFoundException(
                'La tienda no ha sido encontrada '
            );
        }
        $entityManager->remove($tienda);
        $entityManager->flush();
        
        return $this->redirectToRoute('tienda');
    }

    /**
     * @Route("/tienda/editar/{id}", name="editar_tienda")
     */
    public function editarTienda($id,Request $request) {

        $entityManager = $this->getDoctrine()->getManager();       
        $tienda = $entityManager
                ->getRepository(Tienda::class)
                ->find($id);
        
        if (!$tienda) {
            throw $this->createNotFoundException(
                'La tienda no ha sido encontrada '
            );
        }
         
        $form = $this->createForm(TiendaType::class, $tienda);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the Tienda!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();            

            return $this->redirectToRoute('tienda');
        }
        return $this->render(
            'tienda/nueva_tienda.html.twig',
            array('form' => $form->createView())
        );
            return $this->redirectToRoute('tienda');

    }


}

