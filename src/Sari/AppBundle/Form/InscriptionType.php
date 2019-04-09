<?php

namespace Sari\AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anneeInscription', TextType::class)
            ->add('resultat', NumberType::class)
            ->add('etudiant', EntityType::class, array(
                'class' => 'SariAppBundle:Etudiant',
                'choice_label' => function ($etudiant) {
                    return $etudiant->getPersonne()->getNom() . ' ' . $etudiant->getPersonne()->getPrenom();
                }))
            ->add('formation', EntityType::class, array(
                'class' => 'SariAppBundle:Formation',
                'choice_label' => function ($formation) {
                    return $formation->getLibelle();
                }));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sari\AppBundle\Entity\Inscription'
        ));
    }
}
