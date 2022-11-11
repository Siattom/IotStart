<?php

namespace App\Form;

use App\Entity\Operateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PosteOperateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('surname', null,[
            'attr' => [
                'placeholder' => 'nom de famille'
            ]
        ])
        ->add('name', null,[
            'attr' => [
                'placeholder' => 'prénom'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Operateur::class,
        ]);
    }
}
