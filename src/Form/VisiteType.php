<?php

namespace App\Form;

use App\Entity\VisiteTechnique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('travaux_a_effectuer', TextareaType::class, [
            'attr' => ['placeholder' => 'Expliquez en quelques lignes la problématique'],
        ])
        ->add('materiel_necessaire', TextareaType::class, [
            'attr' => ['placeholder' => 'Quel materiel avez-vous dû utiliser ?'],
        ])
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
        ->add('temps_necessaire', null, [
            'attr' => ['placeholder' => 'merci de le mettre en minute !!']
        ])
        ->add('difficulte', ChoiceType::class, [
            'choices' => [
                'très facile' => '1',
                'facile' => '2',
                'normale' => '3',
                'compliqué' => '4',
                'très compliqué' => '5',
            ],
        ])
        ->add('commentaire', TextareaType::class, [
            'attr' => ['placeholder' => 'Ce champ est obligatoire'],
        ])
        ->add('personne_a_contacter', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Merci de renseignez la personne à contacter pour la prochaine visite'
            ],
        ])
        ->add('solution_1', textareaType::class, [
            'attr' => ['placeholder' => 'Précisez ce que vous avez fait ou proposé pour régler le soucis'],
        ])
        ->add('solution_2', textareaType::class, [
            'attr' => ['placeholder' => 'Précisez la deuxième solution apporté si possible'],
        ])
        ->add('solution_3', textareaType::class, [
            'attr' => ['placeholder' => 'Précisez la troisième solution'],
        ])
        ->add('date_de_disponibilite')
        ->add('moyen_de_securite', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Qu\'avez-vous fait pour parfaire la sécurité ?'
            ],
        ])
        ->add('adresse', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Merci d\'indiquer l\'adresse de la vt'
            ],
        ])
        ->add('nom', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Le nom de la personne qui vous a accueilli'
            ],
        ])
        ->add('telephone', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Le numero de la personne qui vous a accueilli'
            ],
        ])
        ->add('adresse_mail', TextareaType::class, [
            'attr' => [
                'placeholder' => 'L\'adresse mail de la personne qui vous a accueilli'
            ],
        ]);
    }
}