<?php

namespace Sari\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Inscription
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Sari\AppBundle\Repository\InscriptionRepository")
 */
class Inscription
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
     * @Assert\Length(max=30)
     * @ORM\Column(type="string", length=30)
     */
    private $anneeInscription;

    /**
     * @var string
     * @Assert\Range(min = 0, max = 20)
     * @ORM\Column(type="decimal")
     */
    private $resultat;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Etudiant", inversedBy="inscriptions")
     * @ORM\JoinColumn(name="etudiant_id", referencedColumnName="id")
     **/
    protected $etudiant;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="Formation", inversedBy="inscriptions", cascade={"persist"})
     * @ORM\JoinColumn(name="formation_id", referencedColumnName="id")
     **/
    protected $formation;


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
     * Set anneeInscription
     *
     * @param string $anneeInscription
     *
     * @return Inscription
     */
    public function setAnneeInscription($anneeInscription)
    {
        $this->anneeInscription = $anneeInscription;

        return $this;
    }

    /**
     * Get anneeInscription
     *
     * @return string
     */
    public function getAnneeInscription()
    {
        return $this->anneeInscription;
    }

    /**
     * Set resultat
     *
     * @param string $resultat
     *
     * @return Inscription
     */
    public function setResultat($resultat)
    {
        $this->resultat = $resultat;

        return $this;
    }

    /**
     * Get resultat
     *
     * @return string
     */
    public function getResultat()
    {
        return $this->resultat;
    }

    /**
     * Set etudiant
     *
     * @param \Sari\AppBundle\Entity\Etudiant $etudiant
     *
     * @return Inscription
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
     * Set formation
     *
     * @param \Sari\AppBundle\Entity\Formation $formation
     *
     * @return Inscription
     */
    public function setFormation(\Sari\AppBundle\Entity\Formation $formation = null)
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * Get formation
     *
     * @return \Sari\AppBundle\Entity\Formation
     */
    public function getFormation()
    {
        return $this->formation;
    }
}
