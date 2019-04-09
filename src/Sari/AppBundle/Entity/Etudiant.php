<?php

namespace Sari\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Etudiant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sari\AppBundle\Repository\EtudiantRepository")
 * @UniqueEntity("numEtudiant")
 */
class Etudiant
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
     * @Assert\Length(min=3, max=25)
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $numEtudiant;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=30)
     * @ORM\Column(type="string", length=30)
     */
    private $numIne;

    /**
     * @ORM\OneToOne(targetEntity="Personne")
     * @ORM\JoinColumn(name="personne_id", referencedColumnName="id")
     */
    private $personne;

    /**
     * @ORM\ManyToOne(targetEntity="Etablissement", inversedBy="etudiants")
     */
    protected $etablissement;

    /**
     * @ORM\OneToMany(targetEntity="Stage", mappedBy="etudiant")
     */
    private $stages;

    /**
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="etudiant")
     */
    protected $inscriptions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inscriptions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set numEtudiant
     *
     * @param string $numEtudiant
     *
     * @return Etudiant
     */
    public function setNumEtudiant($numEtudiant)
    {
        $this->numEtudiant = $numEtudiant;

        return $this;
    }

    /**
     * Get numEtudiant
     *
     * @return string
     */
    public function getNumEtudiant()
    {
        return $this->numEtudiant;
    }

    /**
     * Set numIne
     *
     * @param string $numIne
     *
     * @return Etudiant
     */
    public function setNumIne($numIne)
    {
        $this->numIne = $numIne;

        return $this;
    }

    /**
     * Get numIne
     *
     * @return string
     */
    public function getNumIne()
    {
        return $this->numIne;
    }

    /**
     * Set personne
     *
     * @param \Sari\AppBundle\Entity\Personne $personne
     *
     * @return Etudiant
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
     * Set etablissement
     *
     * @param \Sari\AppBundle\Entity\Etablissement $etablissement
     *
     * @return Etudiant
     */
    public function setEtablissement(\Sari\AppBundle\Entity\Etablissement $etablissement = null)
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * Get etablissement
     *
     * @return \Sari\AppBundle\Entity\Etablissement
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * Add stage
     *
     * @param \Sari\AppBundle\Entity\Stage $stage
     *
     * @return Etudiant
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

    /**
     * Add inscription
     *
     * @param \Sari\AppBundle\Entity\Inscription $inscription
     *
     * @return Etudiant
     */
    public function addInscription(\Sari\AppBundle\Entity\Inscription $inscription)
    {
        $this->inscriptions[] = $inscription;

        return $this;
    }

    /**
     * Remove inscription
     *
     * @param \Sari\AppBundle\Entity\Inscription $inscription
     */
    public function removeInscription(\Sari\AppBundle\Entity\Inscription $inscription)
    {
        $this->inscriptions->removeElement($inscription);
    }

    /**
     * Get inscriptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInscriptions()
    {
        return $this->inscriptions;
    }
}
