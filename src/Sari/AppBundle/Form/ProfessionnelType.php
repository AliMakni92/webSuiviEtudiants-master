<?php

namespace Sari\AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfessionnelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personne', EntityType::class, [
                'class' => 'SariAppBundle:Personne',
                'choice_label' => function ($personne) {
                    return $personne->getNom() . ' ' . $personne->getPrenom() . ' [#' . $personne->getId() . ']';
                },
                'required' => false
            ])
            ->add('poste')
            ->add('service')
            ->add('entreprise', 'entity', array(
                'class' => 'SariAppBundle:Entreprise',
                'choice_label' => function ($entreprise) {
                    return $entreprise->getRaisonSociale();
                }
            ))
            ->add('adrProfessionnel', AdresseType::class, ['data_class' => 'Sari\AppBundle\Entity\Adresse', 'label' => 'Adresse professionnelle']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sari\AppBundle\Entity\Professionnel'
        ));
    }
}
