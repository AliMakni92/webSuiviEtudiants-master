<?php
/**
 * Created by PhpStorm.
 * User: Arnaud
 * Date: 04/02/2016
 * Time: 11:07
 */

namespace Sari\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Professionnel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sari\AppBundle\Repository\ProfessionnelRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @UniqueEntity(
 *     fields={"entreprise", "personne"},
 *     message="professionnel.same.fields")
 */
class Professionnel
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\Length(max=100)
     * @ORM\Column(type="string",  length=100)
     */
    protected $poste;

    /**
     * @Assert\Length(max=100)
     * @ORM\Column(type="string",  length=100)
     */
    protected $service;

    /**
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="professionnels")
     * @ORM\JoinColumn(name="entreprise_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $entreprise;

    /**
     * @var Adresse $adr_professionnel
     * @ORM\Embedded(class="Adresse", columnPrefix = "adr_professionel_")
     */
    private $adr_professionnel;

    /**
     * @ORM\OneToOne(targetEntity="Personne",  mappedBy="professionnel")
     * @ORM\JoinColumn(name="personne_id", referencedColumnName="id")
     */
    private $personne;

    /**
     * @ORM\OneToMany(targetEntity="Stage", mappedBy="professionnel")
     */
    private $stages;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set poste
     *
     * @param string $poste
     *
     * @return Professionnel
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set service
     *
     * @param string $service
     *
     * @return Professionnel
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set adrProfessionnel
     *
     * @param \Sari\AppBundle\Entity\Adresse $adrProfessionnel
     *
     * @return Professionnel
     */
    public function setAdrProfessionnel(\Sari\AppBundle\Entity\Adresse $adrProfessionnel)
    {
        $this->adr_professionnel = $adrProfessionnel;

        return $this;
    }

    /**
     * Get adrProfessionnel
     *
     * @return \Sari\AppBundle\Entity\Adresse
     */
    public function getAdrProfessionnel()
    {
        return $this->adr_professionnel;
    }

    /**
     * Set entreprise
     *
     * @param \Sari\AppBundle\Entity\Entreprise $entreprise
     *
     * @return Professionnel
     */
    public function setEntreprise(\Sari\AppBundle\Entity\Entreprise $entreprise = null)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return \Sari\AppBundle\Entity\Entreprise
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * Set personne
     *
     * @param \Sari\AppBundle\Entity\Personne $personne
     *
     * @return Professionnel
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
     * @return Professionnel
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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Professionnel
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
