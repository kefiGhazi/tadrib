<?php

namespace DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Link
 */
class Link
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nom;
    /**
     * @var string
     */
    private $annee;
    /**
     * @var string
     */
    private $markez;

    /**
     * @var int
     */
    private $actif;

    /**
     * @var \DateTime
     */
    private $dateDeb;

    /**
     * @var \DateTime
     */
    private $dateFin;

    /**
     * @var \DateTime
     */
    private $dateDebInscrit;

    /**
     * @var \DateTime
     */
    private $dateFinInscrit;
    
    private $jihas;
    
    private $kesms;
    
    private $mostawaTadribis;
    
    
    
    public function __construct() {
        $this->jihas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actif = 1;
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
     * @return Link
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
     * Set actif
     *
     * @param integer $actif
     * @return Link
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

    /**
     * Set dateDeb
     *
     * @param \DateTime $dateDeb
     * @return Link
     */
    public function setDateDeb($dateDeb)
    {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    /**
     * Get dateDeb
     *
     * @return \DateTime 
     */
    public function getDateDeb()
    {
        return $this->dateDeb;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return Link
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
     * Set dateDebInscrit
     *
     * @param \DateTime $dateDebInscrit
     * @return Link
     */
    public function setDateDebInscrit($dateDebInscrit)
    {
        $this->dateDebInscrit = $dateDebInscrit;

        return $this;
    }

    /**
     * Get dateDebInscrit
     *
     * @return \DateTime 
     */
    public function getDateDebInscrit()
    {
        return $this->dateDebInscrit;
    }

    /**
     * Set dateFinInscrit
     *
     * @param \DateTime $dateFinInscrit
     * @return Link
     */
    public function setDateFinInscrit($dateFinInscrit)
    {
        $this->dateFinInscrit = $dateFinInscrit;

        return $this;
    }

    /**
     * Get dateFinInscrit
     *
     * @return \DateTime 
     */
    public function getDateFinInscrit()
    {
        return $this->dateFinInscrit;
    }
    
    function getJihas() {
        return $this->jihas;
    }

    function getKesms() {
        return $this->kesms;
    }

    function getMostawaTadribis() {
        return $this->mostawaTadribis;
    }

    function setJihas($jihas) {
        $this->jihas = $jihas;
    }

    function setKesms($kesms) {
        $this->kesms = $kesms;
    }

    function setMostawaTadribis($mostawaTadribis) {
        $this->mostawaTadribis = $mostawaTadribis;
    }
    function getAnnee() {
        return $this->annee;
    }

    function setAnnee($annee) {
        $this->annee = $annee;
    }

    function getMarkez() {
        return $this->markez;
    }

    function setMarkez($markez) {
        $this->markez = $markez;
    }








}
