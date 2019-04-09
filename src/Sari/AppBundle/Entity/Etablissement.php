<?php

namespace Sari\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Etablissement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sari\AppBundle\Repository\EtablissementRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @UniqueEntity("nom")
 */
class Etablissement
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
     * @Assert\Length(max=100)
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max=50)
     * @ORM\Column(type="string", length=50)
     */
    private $type_eta;

    /**
     * @var string
     * @Assert\Url(protocols = {"http", "https"}, checkDNS = true)
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $urlWeb;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var Adresse $adresse
     * @ORM\Embedded(class="Adresse", columnPrefix=false)
     */
    private $adresse;

    /**
     * @ORM\ManyToMany(targetEntity="Formation", mappedBy="etablissements")
     */
    protected $formations;

    /**
     * @ORM\OneToMany(targetEntity="Etudiant", mappedBy="etablissement")
     */
    private $etudiants;

    /**
     * @ORM\ManyToMany(targetEntity="Enseignant", mappedBy="etablissements")
     */
    protected $enseignants;

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
        $this->formations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etudiants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->enseignants = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Etablissement
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set typeEta
     *
     * @param string $typeEta
     *
     * @return Etablissement
     */
    public function setTypeEta($typeEta)
    {
        $this->type_eta = $typeEta;

        return $this;
    }

    /**
     * Get typeEta
     *
     * @return string
     */
    public function getTypeEta()
    {
        return $this->type_eta;
    }

    /**
     * Set urlWeb
     *
     * @param string $urlWeb
     *
     * @return Etablissement
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
     * Set description
     *
     * @param string $description
     *
     * @return Etablissement
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
     * Set adresse
     *
     * @param \Sari\AppBundle\Entity\Adresse $adresse
     *
     * @return Etablissement
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
     * Add formation
     *
     * @param \Sari\AppBundle\Entity\Formation $formation
     *
     * @return Etablissement
     */
    public function addFormation(\Sari\AppBundle\Entity\Formation $formation)
    {
        $this->formations[] = $formation;

        return $this;
    }

    /**
     * Remove formation
     *
     * @param \Sari\AppBundle\Entity\Formation $formation
     */
    public function removeFormation(\Sari\AppBundle\Entity\Formation $formation)
    {
        $this->formations->removeElement($formation);
    }

    /**
     * Get formations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFormations()
    {
        return $this->formations;
    }

    /**
     * Add etudiant
     *
     * @param \Sari\AppBundle\Entity\Etudiant $etudiant
     *
     * @return Etablissement
     */
    public function addEtudiant(\Sari\AppBundle\Entity\Etudiant $etudiant)
    {
        $this->etudiants[] = $etudiant;

        return $this;
    }

    /**
     * Remove etudiant
     *
     * @param \Sari\AppBundle\Entity\Etudiant $etudiant
     */
    public function removeEtudiant(\Sari\AppBundle\Entity\Etudiant $etudiant)
    {
        $this->etudiants->removeElement($etudiant);
    }

    /**
     * Get etudiants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtudiants()
    {
        return $this->etudiants;
    }

    /**
     * Add enseignant
     *
     * @param \Sari\AppBundle\Entity\Enseignant $enseignant
     *
     * @return Etablissement
     */
    public function addEnseignant(\Sari\AppBundle\Entity\Enseignant $enseignant)
    {
        $this->enseignants[] = $enseignant;

        return $this;
    }

    /**
     * Remove enseignant
     *
     * @param \Sari\AppBundle\Entity\Enseignant $enseignant
     */
    public function removeEnseignant(\Sari\AppBundle\Entity\Enseignant $enseignant)
    {
        $this->enseignants->removeElement($enseignant);
    }

    /**
     * Get enseignants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnseignants()
    {
        return $this->enseignants;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Etablissement
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
     * @return Etablissement
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
     * @return Etablissement
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
