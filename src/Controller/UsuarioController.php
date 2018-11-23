<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UsuarioType;
use App\Form\ChangePasswType;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

use App\Form\Model\ChangePassword;

class UsuarioController extends AbstractController
{

    
    /**
     * @Route("/usuario", name="usuario")
     */
    public function index()
    {
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }

    /**
     * @Route("/usuario/nuevo", name="nuevo_usuario")
     */
    public function crearUsuario(Request $request,UserPasswordEncoderInterface $passwordEncoder) {
        // 1) build the form
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($usuario, $usuario->getPlainPassword());
            $usuario->setPassword($password);

            // 4) save the Usuario!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usuario);
            $entityManager->flush();            

            return $this->redirectToRoute('usuario');
        }
        return $this->render(
            'usuario/nuevo_usuario.html.twig',
            array('form' => $form->createView())
        );
    }
    
    /**
     * @Route("/usuario/borrar/{id}", name="borrar_usuario")
     */
    public function borrarUsuario($id) {

        $entityManager = $this->getDoctrine()->getManager();
       
        $usuario = $this->getDoctrine()
            ->getRepository(Usuario::class)
            ->find($id);
        
        if (!$usuario) {
            throw $this->createNotFoundException(
                'El usuario no ha sido encontrado '
            );
        }
        $entityManager->remove($usuario);
        $entityManager->flush();
        
        return $this->redirectToRoute('usuario');
    }

    /**
     * @Route("/usuario/editar/{id}", name="editar_usuario")
     */
    public function editarUsuario($id,Request $request) {

        $entityManager = $this->getDoctrine()->getManager();       
        $usuario = $entityManager
                ->getRepository(Usuario::class)
                ->find($id);
        
        if (!$usuario) {
            throw $this->createNotFoundException(
                'El Usuario no ha sido encontrado '
            );
        } 
        $form = $this->createForm(UsuarioType::class, $usuario);

        // 2) handle the submit (will only happen on POST)

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the Usuario!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();            

            return $this->redirectToRoute('usuario');
        }
        return $this->render(
            'usuario/nuevo_usuario.html.twig',
            array('form' => $form->createView())
        );
            return $this->redirectToRoute('usuario');

    }

    
     /**
     * @Route("/usuario/cambiarcontrasena", name="cambiar_contrasena")
     */
    public function cambiarContrasena(Request $request,UserPasswordEncoderInterface $passwordEncoder) {

        $user = $this->getUser();      
        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(ChangePasswType::class, $changePasswordModel);

        // 2) handle the submit (will only happen on POST)

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            // 4) save the Passw!    

            
            $newPassword = $changePasswordModel->getNewPassword();

            // 3) Encode the password (you could also do this via Doctrine listener)
            
            $password = $passwordEncoder->encodePassword($user, $newPassword);
            $user->setPassword($password);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();   
                 

            return $this->redirectToRoute('home');
        }
        return $this->render(
            'usuario/cambiar_contrasena.html.twig',
            array('form' => $form->createView())
        );
           

    }

}
