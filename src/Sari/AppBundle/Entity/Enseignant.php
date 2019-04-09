<?php

namespace Sari\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Enseignant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sari\AppBundle\Repository\EnseignantRepository")
 */
class Enseignant
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=100)
     * @ORM\Column(type="string", length=100)
     */
    private $statut;

    /**
     * @ORM\ManyToMany(targetEntity="Etablissement", inversedBy="enseignants")
     * @ORM\JoinColumn(name="etablissement_id", referencedColumnName="id")
     */
    private $etablissements;

    /**
     * @ORM\OneToOne(targetEntity="Personne")
     * @ORM\JoinColumn(name="personne_id", referencedColumnName="id")
     */
    private $personne;

    /**
     * @ORM\OneToMany(targetEntity="Stage", mappedBy="enseignant")
     */
    private $stages;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->etablissements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->stages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Enseignant
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Add etablissement
     *
     * @param \Sari\AppBundle\Entity\Etablissement $etablissement
     *
     * @return Enseignant
     */
    public function addEtablissement(\Sari\AppBundle\Entity\Etablissement $etablissement)
    {
        $this->etablissements[] = $etablissement;

        return $this;
    }

    /**
     * Remove etablissement
     *
     * @param \Sari\AppBundle\Entity\Etablissement $etablissement
     */
    public function removeEtablissement(\Sari\AppBundle\Entity\Etablissement $etablissement)
    {
        $this->etablissements->removeElement($etablissement);
    }

    /**
     * Get etablissements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtablissements()
    {
        return $this->etablissements;
    }

    /**
     * Set personne
     *
     * @param \Sari\AppBundle\Entity\Personne $personne
     *
     * @return Enseignant
     */
    public function setPersonne(\Sari\AppBundle\Entity\Personne $personne = null)
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * Get personne
     *
     * @return \Sari\AppBundle\Entity\Personne
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * Add stage
     *
     * @param \Sari\AppBundle\Entity\Stage $stage
     *
     * @return Enseignant
     */
    public function addStage(\Sari\AppBundle\Entity\Stage $stage)
    {
        $this->stages[] = $stage;

        return $this;
    }

    /**
     * Remove stage
     *
     * @param \Sari\AppBundle\Entity\Stage $stage
     */
    public function removeStage(\Sari\AppBundle\Entity\Stage $stage)
    {
        $this->stages->removeElement($stage);
    }

    /**
     * Get stages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStages()
    {
        return $this->stages;
    }
}
