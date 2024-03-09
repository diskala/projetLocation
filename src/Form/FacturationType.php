<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class FacturationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class,[
            "label"=>false,
        ])
        ->add('lastname', TextType::class,[
            "label"=>false,
        ])
        ->add('email', EmailType::class,[
            "label"=>false,
        ])
        ->add('address', TextType::class,[
            "label"=>false,
        ])
        ->add('phone', TextType::class,[
            "label"=>false,
        ])


        ->add('depassement', CheckboxType::class, [
            
        ])
         ->add('valeurKm', NumberType::class,[
            "label"=>false,
        ])
        ->add('prixDepassementKm', TextType::class,[
            "label"=>false,
        ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
