<?php

namespace App\Form;

use App\Entity\Secteur;
use App\Entity\Entreprise;
use App\Entity\Localisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('createdAt')
            // ->add('modifiedAt')
            // ->add('user')
            ->add('nom', TextType::class, array(
                'label' => 'Nom de l\'entreprise'
            ))
            ->add('secteur', EntityType::class, array(
                'class' =>Secteur::class,
                'choice_label' => 'libelle',
                'label' => 'secteur d\'activité'
            ))
            ->add('localisation', EntityType::class, array(
                'class' =>Localisation::class,
                'choice_label' => 'description'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
