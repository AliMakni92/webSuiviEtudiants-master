<?php

namespace Sari\AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
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
            ->add('etablissement', EntityType::class, [
                'class' => 'SariAppBundle:Etablissement',
                'choice_label' => function ($etablissement) {
                    return $etablissement->getNom();
                },
                'required' => false
            ])
            ->add('NumIne', TextType::class)
            ->add('NumEtudiant', TextType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sari\AppBundle\Entity\Etudiant'
        ));
    }
}
