<?php

namespace App\Form;

use App\Entity\Turno;
use App\Entity\Tienda;
use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class TurnoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_usuario', EntityType::class, array(
                'class' => Usuario::class,
                'choice_label' => 'nombre_completo'
            ))
            ->add('id_tienda', EntityType::class, array(
                'class' => Tienda::class,               
                'choice_label' => 'nombre_tienda'
            ))
            ->add('fecha', DateType::class)
            ->add('hora_inicio',TimeType::class)
            ->add('hora_fin',TimeType::class)
            ->add('comentario',TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Turno::class,
        ));
    }
}