<?php

namespace Sari\AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtablissementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('type_eta', TextType::class)
            ->add('urlWeb', UrlType::class)
            ->add('description', TextType::class)
            ->add('adresse', AdresseType::class, ['data_class' => 'Sari\AppBundle\Entity\Adresse', 'label' => 'Adresse de l\'établissement'])/*
            ->add('formations', EntityType::class, array(
                'multiple' => true,
                'required' => false,
                'class' => 'SariAppBundle:Formation',
                'choice_label' => function ($formation) {
                    return $formation->getLibelle();
                }))*/
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sari\AppBundle\Entity\Etablissement'
        ));
    }
}
