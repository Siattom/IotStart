<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PosteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Adresse')
            ->add('Activity', ChoiceType::class, [
                'choices' => [
                    'Telecom' => 'Telecom',
                    'IRVE' => 'IRVE',
                    'Videosurveillance' => 'Videosurveillance',
                    'Controle' => 'Controle',
                    'Autre' => 'Autre',
                ],
            ])
            ->add('CodePostal')
            ->add('Ville')
            ->add('Tel') 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
