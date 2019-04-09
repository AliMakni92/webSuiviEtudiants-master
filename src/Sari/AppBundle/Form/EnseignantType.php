<?php

namespace Sari\AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnseignantType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personne', EntityType::class, array(
                'label' => "Personne",
                'class' => 'SariAppBundle:Personne',
                'choice_label' => 'nom',
                'empty_value' => "Choix de la personne"
            ))
            ->add('etablissements', EntityType::class, array(
                'required' => false,
                'multiple' => true,
                'class' => 'SariAppBundle:Etablissement',
                'choice_label' => function ($etablissement) {
                    return $etablissement->getNom() . ' à ' . $etablissement->getAdresse()->getVille();
                }))
            ->add('statut');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sari\AppBundle\Entity\Enseignant'
        ));
    }
}
