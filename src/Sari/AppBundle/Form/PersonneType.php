<?php

namespace Sari\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'male' => 'M',
                    'female' => 'F'
                ],
                'expanded' => true,
                'multiple' => false,
                'choices_as_values' => true])
            ->add('date_naissance', BirthdayType::class, [
                'placeholder' => array(
                    'year' => 'year', 'month' => 'month', 'day' => 'day',
                )
            ])
            ->add('photoFile', 'vich_file', array(
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
            ))
            ->add('adr_personnel', AdresseType::class, ['data_class' => 'Sari\AppBundle\Entity\Adresse']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sari\AppBundle\Entity\Personne'
        ));
    }
}
