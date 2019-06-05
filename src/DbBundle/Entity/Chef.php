<?php

namespace DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chef
 */
class Chef
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $prenom;

    /**
     * @var string
     */
    private $cin;

    /**
     * @var string
     */
    private $inscrit;

    /**
     * @var \DateTime
     */
    private $dateNaissance;

    /**
     * @var string
     */
    private $fawej;

    

    /**
     * @var string
     */
    private $lastDirasa;
    
    /**
     * @var string
     */
    private $etude;
    /**
     * @var string
     */
    private $travail;
    /**
     * @var string
     */
    private $tel;
    
    /**
     * @var string
     */
    private $valide = 'NON';
    
    /**
     * @var \DateTime
     */
    private $valideDateDeb;
    /**
     * @var \DateTime
     */
    private $valideDateFin;

   

    /**
     * @var \UserBundle\Entity\User
     */
    private $idUser;

    /**
     * @var \DbBundle\Entity\Kesm
     */
    private $idKesm;

    /**
     * @var \DbBundle\Entity\Jiha
     */
    private $idJiha;

/**
     * @var integer
     */
    private $actif = 1;
    
    /**
     * @var integer
     */
    private $sex = 1;
    
    
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
     * @return Chef
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
     * @return Chef
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
     * Set cin
     *
     * @param string $cin
     * @return Chef
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return string 
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set inscrit
     *
     * @param string $inscrit
     * @return Chef
     */
    public function setInscrit($inscrit)
    {
        $this->inscrit = $inscrit;

        return $this;
    }

    /**
     * Get inscrit
     *
     * @return string 
     */
    public function getInscrit()
    {
        return $this->inscrit;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Chef
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set fawej
     *
     * @param string $fawej
     * @return Chef
     */
    public function setFawej($fawej)
    {
        $this->fawej = $fawej;

        return $this;
    }

    /**
     * Get fawej
     *
     * @return string 
     */
    public function getFawej()
    {
        return $this->fawej;
    }

   
    /**
     * Set lastDirasa
     *
     * @param string $lastDirasa
     * @return Chef
     */
    public function setLastDirasa($lastDirasa)
    {
        $this->lastDirasa = $lastDirasa;

        return $this;
    }

    /**
     * Get lastDirasa
     *
     * @return string 
     */
    public function getLastDirasa()
    {
        return $this->lastDirasa;
    }

 
    /**
     * Set idUser
     *
     * @param \UserBundle\Entity\User $idUser
     * @return Chef
     */
    public function setIdUser(\UserBundle\Entity\User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idKesm
     *
     * @param \DbBundle\Entity\Kesm $idKesm
     * @return Chef
     */
    public function setIdKesm(\DbBundle\Entity\Kesm $idKesm = null)
    {
        $this->idKesm = $idKesm;

        return $this;
    }

    /**
     * Get idKesm
     *
     * @return \DbBundle\Entity\Kesm 
     */
    public function getIdKesm()
    {
        return $this->idKesm;
    }

    /**
     * Set idJiha
     *
     * @param \DbBundle\Entity\Jiha $idJiha
     * @return Chef
     */
    public function setIdJiha(\DbBundle\Entity\Jiha $idJiha = null)
    {
        $this->idJiha = $idJiha;

        return $this;
    }

    /**
     * Get idJiha
     *
     * @return \DbBundle\Entity\Jiha 
     */
    public function getIdJiha()
    {
        return $this->idJiha;
    }
    
    function getActif() {
        return $this->actif;
    }

    function setActif($actif) {
        $this->actif = $actif;
    }


    function getEtude() {
        return $this->etude;
    }

    function getTravail() {
        return $this->travail;
    }

    function getTel() {
        return $this->tel;
    }

    function setEtude($etude) {
        $this->etude = $etude;
    }

    function setTravail($travail) {
        $this->travail = $travail;
    }

    function setTel($tel) {
        $this->tel = $tel;
    }
    
    function getSex() {
        return $this->sex;
    }

    function setSex($sex) {
        $this->sex = $sex;
    }
    function getValide() {
        return $this->valide;
    }

    /**
     * Get valideDateDeb
     *
     * @return \DateTime 
     */
    function getValideDateDeb() {
        return $this->valideDateDeb;
    }

    /**
     * Get valideDateFin
     *
     * @return \DateTime 
     */
    function getValideDateFin(){
        return $this->valideDateFin;
    }

    function setValide($valide) {
        $this->valide = $valide;
    }

    /**
     * Set valideDateDeb
     *
     * @param \DateTime $valideDateDeb
     * @return Chef
     */
    function setValideDateDeb($valideDateDeb) {
        $this->valideDateDeb = $valideDateDeb;
    }

    /**
     * Set valideDateFin
     *
     * @param \DateTime $valideDateFin
     * @return Chef
     */
    function setValideDateFin($valideDateFin) {
        $this->valideDateFin = $valideDateFin;
    }





}
