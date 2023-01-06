<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Intervention;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('not') 
            ->add('Name')
            ->add('Description')
            ->add('adresse')
            ->add('Client', EntityType::class, [
                'class' => Client::class,

                'choice_label' => 'Name',
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}
