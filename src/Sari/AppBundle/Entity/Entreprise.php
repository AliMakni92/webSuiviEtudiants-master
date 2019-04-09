<?php

namespace Sari\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Entreprise
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sari\AppBundle\Repository\EntrepriseRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @UniqueEntity("raisonSociale")
 */
class Entreprise
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
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $raisonSociale;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=255)
     */
    private $secteurActivite;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=150)
     */
    private $typeEntreprise;

    /**
     * @var integer
     * @Assert\Range(min=1)
     * @ORM\Column(type="integer")
     */
    private $effectif;

    /**
     * @var string
     * @Assert\Length(max=100)
     * @ORM\Column(type="string", length=100)
     */
    private $statutJuridique;

    /**
     * @var string
     * @Assert\Length(max=35)
     * @ORM\Column(name="code_NAF", type="string", length=35, nullable=true)
     */
    private $codeNAF;

    /**
     * @var string
     * @Assert\Length(max=35)
     * @ORM\Column(name="siret", type="string", length=50, nullable=true)
     */
    private $siret;

    /**
     * @var string
     * @Assert\Url(protocols = {"http", "https"}, checkDNS = true)
     * @ORM\Column(name="url_web", type="string", length=255, nullable=true)
     */
    private $urlWeb;

    /**
     * @var Adresse $adresse
     *
     * @ORM\Embedded(class="Adresse", columnPrefix = false)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="Professionnel", mappedBy="entreprise")
     */
    private $professionnels;

    /**
     * @ORM\OneToMany(targetEntity="Stage", mappedBy="entreprise")
     */
    private $stages;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->professionnels = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set raisonSociale
     *
     * @param string $raisonSociale
     *
     * @return Entreprise
     */
    public function setRaisonSociale($raisonSociale)
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    /**
     * Get raisonSociale
     *
     * @return string
     */
    public function getRaisonSociale()
    {
        return $this->raisonSociale;
    }

    /**
     * Set secteurActivite
     *
     * @param string $secteurActivite
     *
     * @return Entreprise
     */
    public function setSecteurActivite($secteurActivite)
    {
        $this->secteurActivite = $secteurActivite;

        return $this;
    }

    /**
     * Get secteurActivite
     *
     * @return string
     */
    public function getSecteurActivite()
    {
        return $this->secteurActivite;
    }

    /**
     * Set typeEntreprise
     *
     * @param string $typeEntreprise
     *
     * @return Entreprise
     */
    public function setTypeEntreprise($typeEntreprise)
    {
        $this->typeEntreprise = $typeEntreprise;

        return $this;
    }

    /**
     * Get typeEntreprise
     *
     * @return string
     */
    public function getTypeEntreprise()
    {
        return $this->typeEntreprise;
    }

    /**
     * Set effectif
     *
     * @param integer $effectif
     *
     * @return Entreprise
     */
    public function setEffectif($effectif)
    {
        $this->effectif = $effectif;

        return $this;
    }

    /**
     * Get effectif
     *
     * @return integer
     */
    public function getEffectif()
    {
        return $this->effectif;
    }

    /**
     * Set statutJuridique
     *
     * @param string $statutJuridique
     *
     * @return Entreprise
     */
    public function setStatutJuridique($statutJuridique)
    {
        $this->statutJuridique = $statutJuridique;

        return $this;
    }

    /**
     * Get statutJuridique
     *
     * @return string
     */
    public function getStatutJuridique()
    {
        return $this->statutJuridique;
    }

    /**
     * Set codeNAF
     *
     * @param string $codeNAF
     *
     * @return Entreprise
     */
    public function setCodeNAF($codeNAF)
    {
        $this->codeNAF = $codeNAF;

        return $this;
    }

    /**
     * Get codeNAF
     *
     * @return string
     */
    public function getCodeNAF()
    {
        return $this->codeNAF;
    }

    /**
     * Set siret
     *
     * @param string $siret
     *
     * @return Entreprise
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set urlWeb
     *
     * @param string $urlWeb
     *
     * @return Entreprise
     */
    public function setUrlWeb($urlWeb)
    {
        $this->urlWeb = $urlWeb;

        return $this;
    }

    /**
     * Get urlWeb
     *
     * @return string
     */
    public function getUrlWeb()
    {
        return $this->urlWeb;
    }

    /**
     * Set adresse
     *
     * @param \Sari\AppBundle\Entity\Adresse $adresse
     *
     * @return Entreprise
     */
    public function setAdresse(\Sari\AppBundle\Entity\Adresse $adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return \Sari\AppBundle\Entity\Adresse
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Add professionnel
     *
     * @param \Sari\AppBundle\Entity\Professionnel $professionnel
     *
     * @return Entreprise
     */
    public function addProfessionnel(\Sari\AppBundle\Entity\Professionnel $professionnel)
    {
        $this->professionnels[] = $professionnel;

        return $this;
    }

    /**
     * Remove professionnel
     *
     * @param \Sari\AppBundle\Entity\Professionnel $professionnel
     */
    public function removeProfessionnel(\Sari\AppBundle\Entity\Professionnel $professionnel)
    {
        $this->professionnels->removeElement($professionnel);
    }

    /**
     * Get professionnels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfessionnels()
    {
        return $this->professionnels;
    }

    /**
     * Add stage
     *
     * @param \Sari\AppBundle\Entity\Stage $stage
     *
     * @return Entreprise
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Entreprise
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Entreprise
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Entreprise
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
