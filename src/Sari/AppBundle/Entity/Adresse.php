<?php
/**
 * Created by PhpStorm.
 * User: pavya
 * Date: 11/02/2016
 * Time: 17:58
 */

namespace Sari\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class Adresse
{
    /**
     * @Assert\Length(max=255)
     * @ORM\Column(type = "string", length=255, nullable=true)
     */
    protected $adr;

    /**
     * @Assert\Length(max=255)
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $complement;

    /**
     * @Assert\Length(max=12)
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    protected $code_postal;

    /**
     * @Assert\Length(max=100)
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $ville;

    /**
     * @Assert\Country()
     * @Assert\Length(max=100)
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $pays;

    /**
     * @Assert\Length(max=25)
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    protected $tel_fixe;

    /**
     * @Assert\Length(max=25)
     * @ORM\Column(type = "string", length=25, nullable=true)
     */
    protected $tel_port;

    /**
     * Set adr
     *
     * @param string $adr
     *
     * @return Adresse
     */
    public function setAdr($adr)
    {
        $this->adr = $adr;

        return $this;
    }

    /**
     * Get adr
     *
     * @return string
     */
    public function getAdr()
    {
        return $this->adr;
    }

    /**
     * Set complement
     *
     * @param string $complement
     *
     * @return Adresse
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;

        return $this;
    }

    /**
     * Get complement
     *
     * @return string
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return Adresse
     */
    public function setCodePostal($codePostal)
    {
        $this->code_postal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->code_postal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Adresse
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Adresse
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set telFixe
     *
     * @param string $telFixe
     *
     * @return Adresse
     */
    public function setTelFixe($telFixe)
    {
        $this->tel_fixe = $telFixe;

        return $this;
    }

    /**
     * Get telFixe
     *
     * @return string
     */
    public function getTelFixe()
    {
        return $this->tel_fixe;
    }

    /**
     * Set telPort
     *
     * @param string $telPort
     *
     * @return Adresse
     */
    public function setTelPort($telPort)
    {
        $this->tel_port = $telPort;

        return $this;
    }

    /**
     * Get telPort
     *
     * @return string
     */
    public function getTelPort()
    {
        return $this->tel_port;
    }
}
