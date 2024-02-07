<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           

            ->add('marques', ChoiceType::class, [
                'label'=>'Marque',
                'choices' => [
                    'Toutes les Marques' => '',
                    'Aston Martin' => 'Aston Martin',
                    'Audi' => 'Audi',
                    'Bentley' => 'Bentley',
                    'BMW' => 'BMW',
                    'Bugatti' => 'Bugatti',
                    'Ferrari' => 'Ferrari',
                    'Jaguar' => 'Jaguar',
                    'Lamborghini' => 'Lamborghini',
                    'Lexus' => 'Lexus',
                    'Maserati' => 'Maserati',
                    'McLaren' => 'McLaren',
                    'Mercedes-Benz' => 'Mercedes-Benz',
                    'Porsche'=> 'Porsche',
                    'Rolls-Royce'=>'Rolls-Royce',
                    'Lotus'=>'Lotus'

                    
                ],
                'required'=>false,
                
            ])

            ->add('categories', ChoiceType::class, [
                'label'=>'Categorie',
                'choices' => [
                    'Toutes les Categorie' => '',
                    'Coupé' => 'coupé',
                    'Berline'=>'Berline',
                    'Cabriolet' => 'cabriolet',
                    'Break' => 'break',
                    'Suv' => 'suv',
                    'SuperCar' => 'superCar'
                         
                ],
                'required'=>false,
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
