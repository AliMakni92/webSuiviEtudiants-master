<?php

namespace Sari\AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class)
            ->add('libelleCourt', TextType::class)
            ->add('description', TextType::class)
            ->add('etablissements', EntityType::class, array(
                'multiple' => true,
                'class' => 'SariAppBundle:Etablissement',
                'choice_label' => function ($etablissement) {
                    return $etablissement->getNom();
                }));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sari\AppBundle\Entity\Formation'
        ));
    }
}
