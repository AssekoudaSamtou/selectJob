<?php

namespace App\Form;

use App\Entity\Profession;
use App\Entity\Experience;
use App\Entity\LangueParle;
use App\Entity\Particulier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticulierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('sexe')
            ->add('profession', EntityType::class, array(
                'class' =>Profession::class,
                'choice_label' => 'libelle',
                'label' => 'Profession'
            ))
            ->add('langues', EntityType::class, array(
                'class' =>LangueParle::class,
                'choice_label' => 'libelle',
                'label' => 'Langues Parlées'
            ))
            ->add('experiences', EntityType::class, array(
                'class' =>Experience::class,
                'choice_label' => 'description',
                'label' => 'Experience'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Particulier::class,
        ]);
    }
}
