<?php

namespace App\Form;

use App\Entity\Intervention;
use App\Entity\Operateur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffectFinalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name');
    /* $builder->add('operateur', 'entity', array(
        'class' => 'MonBundle:Entity',
        'property' => 'name',
        'multiple' => true,
        'expanded' => true,
    )); */
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
            // Nos attributs HTML
            'attr' => [
                'novalidate' => 'novalidate',
            ]
        ]);
    }
}
