<?php

namespace Sari\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Personne
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sari\AppBundle\Repository\PersonneRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @UniqueEntity(
 *     fields={"nom", "prenom", "sexe", "date_naissance"},
 *     message="personne.same.fields")
 * @Vich\Uploadable
 */
class Personne
{
    /**
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nom
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @var string $prenom
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     * @ORM\Column(type="string", length=100)
     */
    private $prenom;

    /**
     * @var string $sexe
     * @Assert\NotBlank()
     * @Assert\Choice(choices = {"M", "F", "O"})
     * @ORM\Column(type="string", length=1)
     */
    private $sexe;

    /**
     * @var date $date_naissance
     * @Assert\Date()
     * @ORM\Column(type="date")
     */
    private $date_naissance;

    /**
     * @var string $photoName
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoName;

    /**
     * @var
     * @Assert\File(maxSize="512k", mimeTypes={"image/png","image/jpeg","image/jpg", "image/gif"})
     * @Assert\Image(maxWidth=1024, maxHeight=1024)
     * @Vich\UploadableField(mapping="personne_photo", fileNameProperty="photoName")
     */
    private $photoFile;

    /**
     * @var Adresse $adr_personnel
     * @ORM\Embedded(class="Adresse", columnPrefix = "adr_personnel_")
     */
    private $adr_personnel;

    /**
     * @ORM\OneToMany(targetEntity="Sari\UserBundle\Entity\Utilisateur", mappedBy="personne", cascade={"persist"})
     */
    private $utilisateurs;

    /**
     * @ORM\OneToOne(targetEntity="Professionnel", inversedBy="personne")
     */
    private $professionnel;

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
     * Permet d'avoir nom et prénom formater en POST chargement doctrine
     * @ORM\PostLoad
     */
    public function postLoad()
    {
        $this->nom = mb_strtoupper($this->nom);
        $this->prenom = ucfirst(mb_strtolower($this->prenom, 'utf-8'));
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
     * @return Personne
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Personne
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Personne
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Personne
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->date_naissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->date_naissance;
    }

    /**
     * Set adrPersonnel
     *
     * @param \Sari\AppBundle\Entity\Adresse $adrPersonnel
     *
     * @return Personne
     */
    public function setAdrPersonnel(\Sari\AppBundle\Entity\Adresse $adrPersonnel)
    {
        $this->adr_personnel = $adrPersonnel;

        return $this;
    }

    /**
     * Get adrPersonnel
     *
     * @return \Sari\AppBundle\Entity\Adresse
     */
    public function getAdrPersonnel()
    {
        return $this->adr_personnel;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return Personne
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

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Personne
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
     * @return Personne
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
     * Set photoName
     *
     * @param string $photoName
     *
     * @return Personne
     */
    public function setPhotoName($photoName)
    {
        $this->photoName = $photoName;

        return $this;
    }

    /**
     * Get photoName
     *
     * @return string
     */
    public function getPhotoName()
    {
        return $this->photoName;
    }

    public function setPhotoFile(File $image = null)
    {
        $this->photoFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getPhotoFile()
    {
        return $this->photoFile;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->utilisateur = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add utilisateur
     *
     * @param \Sari\UserBundle\Entity\Utilisateur $utilisateur
     *
     * @return Personne
     */
    public function addUtilisateur(\Sari\UserBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur[] = $utilisateur;

        return $this;
    }

    /**
     * Remove utilisateur
     *
     * @param \Sari\UserBundle\Entity\Utilisateur $utilisateur
     */
    public function removeUtilisateur(\Sari\UserBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur->removeElement($utilisateur);
    }

    /**
     * Get utilisateur
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set professionnel
     *
     * @param \Sari\AppBundle\Entity\Professionnel $professionnel
     *
     * @return Personne
     */
    public function setProfessionnel(\Sari\AppBundle\Entity\Professionnel $professionnel = null)
    {
        $this->professionnel = $professionnel;

        return $this;
    }

    /**
     * Get professionnel
     *
     * @return \Sari\AppBundle\Entity\Professionnel
     */
    public function getProfessionnel()
    {
        return $this->professionnel;
    }

    /**
     * Set etudiant
     *
     * @param \Sari\AppBundle\Entity\Etudiant $etudiant
     *
     * @return Personne
     */
    public function setEtudiant(\Sari\AppBundle\Entity\Etudiant $etudiant = null)
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return \Sari\AppBundle\Entity\Etudiant
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * Set enseignant
     *
     * @param \Sari\AppBundle\Entity\Enseignant $enseignant
     *
     * @return Personne
     */
    public function setEnseignant(\Sari\AppBundle\Entity\Enseignant $enseignant = null)
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    /**
     * Get enseignant
     *
     * @return \Sari\AppBundle\Entity\Enseignant
     */
    public function getEnseignant()
    {
        return $this->enseignant;
    }

    /**
     * Get utilisateurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }
}
