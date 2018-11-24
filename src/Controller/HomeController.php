<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Turno;
use App\Form\TurnoType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
    
        return $this->render('home/index.html.twig');
        
    }
    /**
     * @Route("/home/turnos", name="home_turnos")
     */
    public function getAllTurnos()
    {

        $repository = $this->getDoctrine()->getRepository(Turno::class);
        $turnos = $repository->findAll();
        $array = array();

        foreach ($turnos as $turno){
            array_push($array,$turno->toArray());
        }
        return $this->json($array);
    }
    
}
