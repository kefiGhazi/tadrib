<?php

namespace DbBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tawsims
 *
 * @ORM\Table(name="tawsims")
 * @ORM\Entity(repositoryClass="DbBundle\Repository\TawsimsRepository")
 */
class Tawsims
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="dateDemande", type="datetime")
     */
    private $dateDemande;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="dateTawsim", type="datetime", nullable=true)
     */
    private $dateTawsim;

    /**
     * @var \DbBundle\Entity\Jiha
     *
     * @ORM\Column(name="idJiha", type="integer")
     */
    private $idJiha;

    /**
     * @var \DbBundle\Entity\Chef
     *
     * @ORM\Column(name="idChef", type="integer")
     */
    private $idChef;

    /**
     * @var string
     *
     * @ORM\Column(name="moisChara", type="string", length=255,)
     */
    private $moisChara;

    /**
     * @var string
     *
     * @ORM\Column(name="yearChara", type="string", length=255,)
     */
    private $yearChara;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuxChara", type="string", length=255)
     */
    private $lieuxChara;

    /**
     * @var string
     *
     * @ORM\Column(name="chefChara", type="string", length=255)
     */
    private $chefChara;

    /**
     * @var string
     *
     * @ORM\Column(name="chefUnite", type="string", length=255)
     */
    private $chefUnite;

    /**
     * @var string
     *
     * @ORM\Column(name="uniteName", type="string", length=255, nullable=true)
     */
    private $uniteName;

    /**
     * @var string
     *
     * @ORM\Column(name="camping", type="string", length=255)
     */
    private $camping;

    /**
     * @var string
     *
     * @ORM\Column(name="moisCamping", type="string", length=255, nullable=true)
     */
    private $moisCamping;

    /**
     * @var string
     *
     * @ORM\Column(name="yearCamping", type="string", length=255, nullable=true)
     */
    private $yearCamping;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="responseJiha", type="integer", nullable=true)
     */
    private $responseJiha;

    /**
     * @var string
     *
     * @ORM\Column(name="messageJiha", type="text", nullable=true)
     */
    private $messageJiha;

    /**
     * @var int
     *
     * @ORM\Column(name="responseWatani", type="integer", nullable=true)
     */
    private $responseWatani;

    /**
     * @var string
     *
     * @ORM\Column(name="messageWatani", type="text", nullable=true)
     */
    private $messageWatani;

    /**
     * @var int
     *
     * @ORM\Column(name="actif", type="integer")
     */
    private $actif;


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
     * Set dateDemande
     *
     * @param DateTime $dateDemande
     * @return Tawsims
     */
    public function setDateDemande($dateDemande)
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    /**
     * Get dateDemande
     *
     * @return DateTime
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
    }

    /**
     * Set dateTawsim
     *
     * @param DateTime $dateTawsim
     * @return Tawsims
     */
    public function setDateTawsim($dateTawsim)
    {
        $this->dateTawsim = $dateTawsim;

        return $this;
    }

    /**
     * Get dateTawsim
     *
     * @return DateTime
     */
    public function getDateTawsim()
    {
        return $this->dateTawsim;
    }

    /**
     * Set idJiha
     *
     * @param Jiha $idJiha
     * @return Tawsims
     */
    public function setIdJiha($idJiha)
    {
        $this->idJiha = $idJiha;

        return $this;
    }

    /**
     * Get idJiha
     *
     * @return Jiha
     */
    public function getIdJiha()
    {
        return $this->idJiha;
    }

    /**
     * Set idChef
     *
     * @param Chef $idChef
     * @return Tawsims
     */
    public function setIdChef($idChef)
    {
        $this->idChef = $idChef;

        return $this;
    }

    /**
     * Get idChef
     *
     * @return Chef
     */
    public function getIdChef()
    {
        return $this->idChef;
    }

    /**
     * Set moisChara
     *
     * @param string $moisChara
     * @return Tawsims
     */
    public function setMoisChara($moisChara)
    {
        $this->moisChara = $moisChara;

        return $this;
    }

    /**
     * Get moisChara
     *
     * @return string
     */
    public function getMoisChara()
    {
        return $this->moisChara;
    }

    /**
     * Set yearChara
     *
     * @param string $yearChara
     * @return Tawsims
     */
    public function setYearChara($yearChara)
    {
        $this->yearChara = $yearChara;

        return $this;
    }

    /**
     * Get yearChara
     *
     * @return string
     */
    public function getYearChara()
    {
        return $this->yearChara;
    }

    /**
     * Set lieuxChara
     *
     * @param string $lieuxChara
     * @return Tawsims
     */
    public function setLieuxChara($lieuxChara)
    {
        $this->lieuxChara = $lieuxChara;

        return $this;
    }

    /**
     * Get lieuxChara
     *
     * @return string 
     */
    public function getLieuxChara()
    {
        return $this->lieuxChara;
    }

    /**
     * Set chefChara
     *
     * @param string $chefChara
     * @return Tawsims
     */
    public function setChefChara($chefChara)
    {
        $this->chefChara = $chefChara;

        return $this;
    }

    /**
     * Get chefChara
     *
     * @return string 
     */
    public function getChefChara()
    {
        return $this->chefChara;
    }

    /**
     * Set chefUnite
     *
     * @param string $chefUnite
     * @return Tawsims
     */
    public function setChefUnite($chefUnite)
    {
        $this->chefUnite = $chefUnite;

        return $this;
    }

    /**
     * Get chefUnite
     *
     * @return string
     */
    public function getChefUnite()
    {
        return $this->chefUnite;
    }

    /**
     * Set uniteName
     *
     * @param string $uniteName
     * @return Tawsims
     */
    public function setUniteName($uniteName)
    {
        $this->uniteName = $uniteName;

        return $this;
    }

    /**
     * Get uniteName
     *
     * @return string 
     */
    public function getUniteName()
    {
        return $this->uniteName;
    }

    /**
     * Set camping
     *
     * @param string $camping
     * @return Tawsims
     */
    public function setCamping($camping)
    {
        $this->camping = $camping;

        return $this;
    }

    /**
     * Get camping
     *
     * @return string
     */
    public function getCamping()
    {
        return $this->camping;
    }

    /**
     * Set moisCamping
     *
     * @param string $moisCamping
     * @return Tawsims
     */
    public function setMoisCamping($moisCamping)
    {
        $this->moisCamping = $moisCamping;

        return $this;
    }

    /**
     * Get moisCamping
     *
     * @return string
     */
    public function getMoisCamping()
    {
        return $this->moisCamping;
    }

    /**
     * Set yearCamping
     *
     * @param string $yearCamping
     * @return Tawsims
     */
    public function setYearCamping($yearCamping)
    {
        $this->yearCamping = $yearCamping;

        return $this;
    }

    /**
     * Get yearCamping
     *
     * @return string
     */
    public function getYearCamping()
    {
        return $this->yearCamping;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     * @return Tawsims
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set responseJiha
     *
     * @param integer $responseJiha
     * @return Tawsims
     */
    public function setResponseJiha($responseJiha)
    {
        $this->responseJiha = $responseJiha;

        return $this;
    }

    /**
     * Get responseJiha
     *
     * @return integer
     */
    public function getResponseJiha()
    {
        return $this->responseJiha;
    }

    /**
     * Set messageJiha
     *
     * @param string $messageJiha
     * @return Tawsims
     */
    public function setMessageJiha($messageJiha)
    {
        $this->messageJiha = $messageJiha;

        return $this;
    }

    /**
     * Get messageJiha
     *
     * @return string 
     */
    public function getMessageJiha()
    {
        return $this->messageJiha;
    }

    /**
     * Set responseWatani
     *
     * @param integer $responseWatani
     * @return Tawsims
     */
    public function setResponseWatani($responseWatani)
    {
        $this->responseWatani = $responseWatani;

        return $this;
    }

    /**
     * Get responseWatani
     *
     * @return integer
     */
    public function getResponseWatani()
    {
        return $this->responseWatani;
    }

    /**
     * Set messageWatani
     *
     * @param string $messageWatani
     * @return Tawsims
     */
    public function setMessageWatani($messageWatani)
    {
        $this->messageWatani = $messageWatani;

        return $this;
    }

    /**
     * Get messageWatani
     *
     * @return string 
     */
    public function getMessageWatani()
    {
        return $this->messageWatani;
    }

    /**
     * Set actif
     *
     * @param integer $actif
     * @return Tawsims
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return integer 
     */
    public function getActif()
    {
        return $this->actif;
    }
}
