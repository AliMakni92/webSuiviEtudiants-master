<?php

namespace Sari\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('raisonSociale', TextType::class)
            ->add('secteurActivite', TextType::class)
            ->add('typeEntreprise', TextType::class)
            ->add('effectif', IntegerType::class)
            ->add('statutJuridique', TextType::class)
            ->add('codeNAF', TextType::class, ['required' => false])
            ->add('siret', TextType::class, ['required' => false])
            ->add('urlWeb', UrlType::class, ['required' => false])
            ->add('adresse', AdresseType::class, ['data_class' => 'Sari\AppBundle\Entity\Adresse', 'label' => 'Adresse de l\'Entreprise']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sari\AppBundle\Entity\Entreprise'
        ));
    }
}
