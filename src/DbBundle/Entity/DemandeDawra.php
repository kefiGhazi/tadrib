<?php

namespace DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeDawra
 */
class DemandeDawra {

    /**
     * @var integer
     */
    private $id;

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
    private $dateAccept;

    /**
     * @var string
     */
    private $lieux;

    /**
     * @var string
     */
    private $repense;

    /**
     * @var string
     */
    private $realiser;

    /**
     * @var string
     */
    private $generer;

    /**
     * @var string
     */
    private $raison;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $chefDawra;

    /**
     * @var \DateTime
     */
    private $dateCreation;

    /**
     * @var integer
     */
    private $actif;

    /**
     * @var \UserBundle\Entity\User
     */
    private $idCreateur;

    /**
     * @var \DbBundle\Entity\Jiha
     */
    private $idJiha;

    /**
     * @var \DbBundle\Entity\Kesm
     */
    private $idKesm;

    /**
     * @var \DbBundle\Entity\TypeDawra
     */
    private $idType;

    /**
     * @var \DbBundle\Entity\AtributType
     */
    private $idAtributType;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set dateDeb
     *
     * @param \DateTime $dateDeb
     * @return Dawra
     */
    public function setDateDeb($dateDeb) {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    /**
     * Get dateDeb
     *
     * @return \DateTime 
     */
    public function getDateDeb() {
        return $this->dateDeb;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return Dawra
     */
    public function setDateFin($dateFin) {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime 
     */
    public function getDateFin() {
        return $this->dateFin;
    }

    /**
     * Set lieux
     *
     * @param string $lieux
     * @return Dawra
     */
    public function setLieux($lieux) {
        $this->lieux = $lieux;

        return $this;
    }

    /**
     * Get lieux
     *
     * @return string 
     */
    public function getLieux() {
        return $this->lieux;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Dawra
     */
    public function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation() {
        return $this->dateCreation;
    }

    /**
     * Set actif
     *
     * @param integer $actif
     * @return Dawra
     */
    public function setActif($actif) {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return integer 
     */
    public function getActif() {
        return $this->actif;
    }

    /**
     * Set idCreateur
     *
     * @param \UserBundle\Entity\User $idCreateur
     * @return Dawra
     */
    public function setIdCreateur(\UserBundle\Entity\User $idCreateur = null) {
        $this->idCreateur = $idCreateur;

        return $this;
    }

    /**
     * Get idCreateur
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdCreateur() {
        return $this->idCreateur;
    }

    /**
     * Set idJiha
     *
     * @param \DbBundle\Entity\Jiha $idJiha
     * @return Dawra
     */
    public function setIdJiha(\DbBundle\Entity\Jiha $idJiha = null) {
        $this->idJiha = $idJiha;

        return $this;
    }

    /**
     * Get idJiha
     *
     * @return \DbBundle\Entity\Jiha 
     */
    public function getIdJiha() {
        return $this->idJiha;
    }

    /**
     * Set idKesm
     *
     * @param \DbBundle\Entity\Kesm $idKesm
     * @return Dawra
     */
    public function setIdKesm(\DbBundle\Entity\Kesm $idKesm = null) {
        $this->idKesm = $idKesm;

        return $this;
    }

    /**
     * Get idKesm
     *
     * @return \DbBundle\Entity\Kesm 
     */
    public function getIdKesm() {
        return $this->idKesm;
    }

    /**
     * Set idType
     *
     * @param \DbBundle\Entity\TypeDawra $idType
     * @return Dawra
     */
    public function setIdType(\DbBundle\Entity\TypeDawra $idType = null) {
        $this->idType = $idType;

        return $this;
    }

    /**
     * Get idType
     *
     * @return \DbBundle\Entity\TypeDawra 
     */
    public function getIdType() {
        return $this->idType;
    }

    /**
     * Set idAtributType
     *
     * @param \DbBundle\Entity\AtributType $idAtributType
     * @return Dawra
     */
    public function setIdAtributType(\DbBundle\Entity\AtributType $idAtributType = null) {
        $this->idAtributType = $idAtributType;

        return $this;
    }

    /**
     * Get idAtributType
     *
     * @return \DbBundle\Entity\AtributType 
     */
    public function getIdAtributType() {
        return $this->idAtributType;
    }

    function getEtat() {
        return $this->etat;
    }

    function setEtat($etat) {
        $this->etat = $etat;
    }

    function getRepense() {
        return $this->repense;
    }

    function getRaison() {
        return $this->raison;
    }

    function getChefDawra() {
        return $this->chefDawra;
    }

    function setRepense($repense) {
        $this->repense = $repense;
    }

    function setRaison($raison) {
        $this->raison = $raison;
    }

    function setChefDawra($chefDawra) {
        $this->chefDawra = $chefDawra;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function getRealiser() {
        return $this->realiser;
    }

    function setRealiser($realiser) {
        $this->realiser = $realiser;
    }

    function getGenerer() {
        return $this->generer;
    }

    function setGenerer($generer) {
        $this->generer = $generer;
    }

    function getDateAccept(){
        return $this->dateAccept;
    }

    function setDateAccept($dateAccept) {
        $this->dateAccept = $dateAccept;
    }

}
