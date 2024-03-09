<?php

namespace App\Form;

use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class SearchReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('email', EmailType::class, [
            'label'=>'Email',
            'required'=>false,
            'empty_data' => '',
            
            
        ])

        ->add('dateLocation', DateType::class, [
            'label'=>'date de location',
             
            'required'=>false,
            'empty_data' => '',
            
        ])

        ->add('dateRetour', DateType::class, [
            'label'=>'date de retour',
             
            'required'=>false,
            'empty_data' => '',
            
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
