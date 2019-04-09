<?php

namespace Sari\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Stage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sari\AppBundle\Repository\StageRepository")
 */
class Stage
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
     * @var DateTime
     * @Assert\DateTime()
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @var DateTime
     * @Assert\DateTime()
     * @ORM\Column(type="datetime")
     */
    private $dateFin;

    /**
     * @var string
     * @Assert\Length(max=255)
     * @ORM\Column(name="sujet", type="string", length=255)
     */
    private $sujet;

    /**
     * @var string
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=255)
     */
    private $projet;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=255)
     */
    private $fonction;

    /**
     * @var DateTime
     * @Assert\DateTime()
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateSoutenance;

    /**
     * @var string
     * @Assert\Range(min = 0, max = 20)
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $noteRapport;

    /**
     * @var string
     * @Assert\Range(min = 0, max = 20)
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $noteSoutenance;

    /**
     * @var string
     * @Assert\Range(min = 0, max = 20)
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $noteProjet;

    /**
     * @var string
     * @Assert\Range(min = 0, max = 20)
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $noteTravail;

    /**
     * @ORM\ManyToOne(targetEntity="Etudiant", inversedBy="stages")
     * @ORM\JoinColumn(name="etudiant_id", referencedColumnName="id")
     */
    protected $etudiant;

    /**
     * @ORM\ManyToOne(targetEntity="Entreprise", inversedBy="stages")
     * @ORM\JoinColumn(name="entreprise_id", referencedColumnName="id")
     */
    protected $entreprise;

    /**
     * @var Adresse $adr_stage
     * @ORM\Embedded(class="Adresse", columnPrefix = "adr_stage_")
     */
    private $adr_stage;

    /**
     * @ORM\ManyToOne(targetEntity="Enseignant", inversedBy="stages")
     * @ORM\JoinColumn(name="enseignant_id", referencedColumnName="id")
     */
    protected $enseignant;

    /**
     * @ORM\ManyToOne(targetEntity="Professionnel", inversedBy="stages")
     * @ORM\JoinColumn(name="professionnel_id", referencedColumnName="id")
     */
    protected $professionnel;

    /**
     * @ORM\OneToMany(targetEntity="SuiviStage", mappedBy="stage")
     **/
    protected $suivis_stage;

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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Stage
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Stage
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set sujet
     *
     * @param string $sujet
     *
     * @return Stage
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set projet
     *
     * @param string $projet
     *
     * @return Stage
     */
    public function setProjet($projet)
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * Get projet
     *
     * @return string
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Stage
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
     * Set fonction
     *
     * @param string $fonction
     *
     * @return Stage
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set dateSoutenance
     *
     * @param \DateTime $dateSoutenance
     *
     * @return Stage
     */
    public function setDateSoutenance($dateSoutenance)
    {
        $this->dateSoutenance = $dateSoutenance;

        return $this;
    }

    /**
     * Get dateSoutenance
     *
     * @return \DateTime
     */
    public function getDateSoutenance()
    {
        return $this->dateSoutenance;
    }

    /**
     * Set noteRapport
     *
     * @param string $noteRapport
     *
     * @return Stage
     */
    public function setNoteRapport($noteRapport)
    {
        $this->noteRapport = $noteRapport;

        return $this;
    }

    /**
     * Get noteRapport
     *
     * @return string
     */
    public function getNoteRapport()
    {
        return $this->noteRapport;
    }

    /**
     * Set noteSoutenance
     *
     * @param string $noteSoutenance
     *
     * @return Stage
     */
    public function setNoteSoutenance($noteSoutenance)
    {
        $this->noteSoutenance = $noteSoutenance;

        return $this;
    }

    /**
     * Get noteSoutenance
     *
     * @return string
     */
    public function getNoteSoutenance()
    {
        return $this->noteSoutenance;
    }

    /**
     * Set noteProjet
     *
     * @param string $noteProjet
     *
     * @return Stage
     */
    public function setNoteProjet($noteProjet)
    {
        $this->noteProjet = $noteProjet;

        return $this;
    }

    /**
     * Get noteProjet
     *
     * @return string
     */
    public function getNoteProjet()
    {
        return $this->noteProjet;
    }

    /**
     * Set noteTravail
     *
     * @param string $noteTravail
     *
     * @return Stage
     */
    public function setNoteTravail($noteTravail)
    {
        $this->noteTravail = $noteTravail;

        return $this;
    }

    /**
     * Get noteTravail
     *
     * @return string
     */
    public function getNoteTravail()
    {
        return $this->noteTravail;
    }

    /**
     * Set adrStage
     *
     * @param \Sari\AppBundle\Entity\Adresse $adrStage
     *
     * @return Stage
     */
    public function setAdrStage(\Sari\AppBundle\Entity\Adresse $adrStage)
    {
        $this->adr_stage = $adrStage;

        return $this;
    }

    /**
     * Get adrStage
     *
     * @return \Sari\AppBundle\Entity\Adresse
     */
    public function getAdrStage()
    {
        return $this->adr_stage;
    }

    /**
     * Set etudiant
     *
     * @param \Sari\AppBundle\Entity\Etudiant $etudiant
     *
     * @return Stage
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
     * Set entreprise
     *
     * @param \Sari\AppBundle\Entity\Entreprise $entreprise
     *
     * @return Stage
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
     * Set enseignant
     *
     * @param \Sari\AppBundle\Entity\Enseignant $enseignant
     *
     * @return Stage
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
     * Set professionnel
     *
     * @param \Sari\AppBundle\Entity\Professionnel $professionnel
     *
     * @return Stage
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
     * Constructor
     */
    public function __construct()
    {
        $this->suivis_stage = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add suivisStage
     *
     * @param \Sari\AppBundle\Entity\SuiviStage $suivisStage
     *
     * @return Stage
     */
    public function addSuivisStage(\Sari\AppBundle\Entity\SuiviStage $suivisStage)
    {
        $this->suivis_stage[] = $suivisStage;

        return $this;
    }

    /**
     * Remove suivisStage
     *
     * @param \Sari\AppBundle\Entity\SuiviStage $suivisStage
     */
    public function removeSuivisStage(\Sari\AppBundle\Entity\SuiviStage $suivisStage)
    {
        $this->suivis_stage->removeElement($suivisStage);
    }

    /**
     * Get suivisStage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSuivisStage()
    {
        return $this->suivis_stage;
    }
}
