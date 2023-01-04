<?php

namespace App\Form;

use App\Entity\Rapport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Activite', ChoiceType::class, [
            'choices' => [
                'Telecom' => 'Telecom',
                'IRVE' => 'IRVE',
                'Videosurveillance' => 'Videosurveillance',
                'Controle' => 'Controle',
            ],
            'expanded' => true, 
            'multiple' => false,
        ])

        ->add('Realisation_des_travaux', TextareaType::class, [
            'attr' => ['class' => 'tinymce'],
        ])

        ->add('fonctionnement_apres_intervention', ChoiceType::class, [
            'choices' => [
                'oui' => '1',
                'non' => '0',
            ],
            'expanded' => true,
            'multiple' => false,
        ])

        ->add('equipement_installe', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Il faut préciser le matériel si oui et écrire non si rien d\'installé'
            ],
        ])

        ->add('Content', TextareaType::class, [
            'attr' => ['class' => 'tinymce'],
        ])

        ->add('numero_telephone_client', null, [
            'attr' => [
                'placeholder' => 'merci de mettre le numero en brut',
            ],
        ])
        ->add('adresse_mail_client')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rapport::class,
        ]);
    }
}
