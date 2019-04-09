<?php
/**
 * Created by PhpStorm.
 * User: pavya
 * Date: 28/02/2016
 * Time: 08:47
 */

namespace Sari\UserBundle\Form;


use Sari\AppBundle\Form\PersonneType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$builder->add('personne', PersonneType::class,
            [
                'data_class' => 'Sari\AppBundle\Entity\Personne'
            ]
        );*/
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'sariapp_utilisateur_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}