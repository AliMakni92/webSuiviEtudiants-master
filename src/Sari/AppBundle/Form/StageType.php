<?php

namespace Sari\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('entreprise', 'entity', array(
            'class' => 'SariAppBundle:Entreprise',
            'choice_label' => function ($entreprise) {
                return $entreprise->getRaisonSociale();
            }
        ))
            ->add('sujet')
            ->add('projet')
            ->add('description')
            ->add('fonction')
            ->add('etudiant', 'entity', array(
                'class' => 'SariAppBundle:Etudiant',
                'choice_label' => function ($etudiant) {
                    return $etudiant->getPersonne()->getPrenom() . " " . $etudiant->getPersonne()->getNom();
                }
            ))
            ->add('enseignant', 'entity', array(
                'class' => 'SariAppBundle:Enseignant',
                'choice_label' => function ($enseignant) {
                    return $enseignant->getPersonne()->getPrenom() . " " . $enseignant->getPersonne()->getNom();
                }
            ))
            ->add('professionnel', 'entity', array(
                'class' => 'SariAppBundle:Professionnel',
                'choice_label' => function ($professionnel) {
                    return $professionnel->getPersonne()->getPrenom() . " " . $professionnel->getPersonne()->getNom();
                }
            ))
            ->add('date_debut', 'date', array(
                'required' => true
            ))
            ->add('date_fin', 'date', array(
                'required' => true
            ))
            ->add('date_soutenance', 'date', array(
                'required' => true
            ))
            ->add('note_rapport', 'choice', array(
                'required' => false,
                'choices' => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20)
            ))
            ->add('note_soutenance', 'choice', array(
                'required' => false,
                'choices' => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20)
            ))
            ->add('note_projet', 'choice', array(
                'required' => false,
                'choices' => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20)
            ))
            ->add('note_travail', 'choice', array(
                'required' => false,
                'choices' => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20)
            ))
            ->add('enregistrer', 'submit');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sari\AppBundle\Entity\Stage'
        ));
    }
}
