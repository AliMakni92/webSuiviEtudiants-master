<?php

namespace Sari\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Formation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sari\AppBundle\Repository\FormationRepository")
 * @UniqueEntity("libelle")
 */
class Formation
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
     * @Assert\Length(max=100)
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $libelle;

    /**
     * @var string
     * @Assert\Length(max=30)
     * @ORM\Column(type="string", length=30)
     */
    private $libelleCourt;

    /**
     * @var string
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="Etablissement", inversedBy="formations")
     **/
    protected $etablissements;

    /**
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="formation")
     */
    protected $inscriptions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->etablissements = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Formation
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set libelleCourt
     *
     * @param string $libelleCourt
     *
     * @return Formation
     */
    public function setLibelleCourt($libelleCourt)
    {
        $this->libelleCourt = $libelleCourt;

        return $this;
    }

    /**
     * Get libelleCourt
     *
     * @return string
     */
    public function getLibelleCourt()
    {
        return $this->libelleCourt;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Formation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add etablissement
     *
     * @param \Sari\AppBundle\Entity\Etablissement $etablissement
     *
     * @return Formation
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
     * Add inscription
     *
     * @param \Sari\AppBundle\Entity\Inscription $inscription
     *
     * @return Formation
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
