<?php

namespace DbBundle\Entity;


/**
 * Inscrit
 */
class InscritV1
{
    /**
     * @var int
     */
    private $id;
    
    /**
     * @var int
     */
    private $sex;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $prenom;

    /**
     * @var \DateTime
     */
    private $dateNaissance;

    /**
     * @var string
     */
    private $niveau;

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
    private $email;

    /**
     * @var string
     */
    private $adress;

    /**
     * @var \DbBundle\Entity\AtributType
     */
    private $lastDirassa;

    /**
     * @var string
     */
    private $chefLastDirassa;

    /**
     * @var string
     */
    private $lieuxLastDirassa;

    /**
     * @var string
     */
    private $moisLastDirassa;

    /**
     * @var string
     */
    private $yearLastDirassa;

    /**
     * @var string
     */
    private $cin;

    /**
     * @var string
     */
    private $numeroInscrit;

    /**
     * @var string
     */
    private $imageCinFace;

    /**
     * @var string
     */
    private $imageCinPile;

    /**
     * @var \DbBundle\Entity\AtributType
     */
    private $idDirassa;

    /**
     * @var \DbBundle\Entity\Kesm
     */
    private $idKesm;

    /**
     * @var \DbBundle\Entity\Jiha
     */
    private $idJiha;

    /**
     * @var string
     */
    private $fawj;

    /**
     * @var string
     */
    private $wehda;
    
    /**
     * @var int
     */
    private $accepteW;
    
    /**
     * @var string
     */
    private $accepteMessageW;
    
    /**
     * @var int
     */
    private $accepteJ;
    
    /**
     * @var string
     */
    private $accepteMessageJ;
    
    /**
     * @var int
     */
    private $paye;
    /**
     * @var int
     */
    private $presence;
    /**
     * @var int
     */
    private $result;
    
    /**
     * @var int
     */
    private $idMarkez;
    
    /**
     * @var int
     */
    private $idDirassaA;


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
     * @return Inscrit
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
     * @return Inscrit
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
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Inscrit
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
     * Set niveau
     *
     * @param string $niveau
     * @return Inscrit
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string 
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set travail
     *
     * @param string $travail
     * @return Inscrit
     */
    public function setTravail($travail)
    {
        $this->travail = $travail;

        return $this;
    }

    /**
     * Get travail
     *
     * @return string 
     */
    public function getTravail()
    {
        return $this->travail;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return Inscrit
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Inscrit
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set adress
     *
     * @param string $adress
     * @return Inscrit
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string 
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set chefLastDirassa
     *
     * @param string $chefLastDirassa
     * @return Inscrit
     */
    public function setChefLastDirassa($chefLastDirassa)
    {
        $this->chefLastDirassa = $chefLastDirassa;

        return $this;
    }

    /**
     * Get chefLastDirassa
     *
     * @return string 
     */
    public function getChefLastDirassa()
    {
        return $this->chefLastDirassa;
    }

    /**
     * Set lieuxLastDirassa
     *
     * @param string $lieuxLastDirassa
     * @return Inscrit
     */
    public function setLieuxLastDirassa($lieuxLastDirassa)
    {
        $this->lieuxLastDirassa = $lieuxLastDirassa;

        return $this;
    }

    /**
     * Get lieuxLastDirassa
     *
     * @return string 
     */
    public function getLieuxLastDirassa()
    {
        return $this->lieuxLastDirassa;
    }

    /**
     * Set moisLastDirassa
     *
     * @param string $moisLastDirassa
     * @return Inscrit
     */
    public function setMoisLastDirassa($moisLastDirassa)
    {
        $this->moisLastDirassa = $moisLastDirassa;

        return $this;
    }

    /**
     * Get moisLastDirassa
     *
     * @return string 
     */
    public function getMoisLastDirassa()
    {
        return $this->moisLastDirassa;
    }

    /**
     * Set yearLastDirassa
     *
     * @param string $yearLastDirassa
     * @return Inscrit
     */
    public function setYearLastDirassa($yearLastDirassa)
    {
        $this->yearLastDirassa = $yearLastDirassa;

        return $this;
    }

    /**
     * Get yearLastDirassa
     *
     * @return string 
     */
    public function getYearLastDirassa()
    {
        return $this->yearLastDirassa;
    }

    /**
     * Set cin
     *
     * @param string $cin
     * @return Inscrit
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
     * Set numeroInscrit
     *
     * @param string $numeroInscrit
     * @return Inscrit
     */
    public function setNumeroInscrit($numeroInscrit)
    {
        $this->numeroInscrit = $numeroInscrit;

        return $this;
    }

    /**
     * Get numeroInscrit
     *
     * @return string 
     */
    public function getNumeroInscrit()
    {
        return $this->numeroInscrit;
    }

    /**
     * Set imageCinFace
     *
     * @param string $imageCinFace
     * @return Inscrit
     */
    public function setImageCinFace($imageCinFace)
    {
        $this->imageCinFace = $imageCinFace;

        return $this;
    }

    /**
     * Get imageCinFace
     *
     * @return string 
     */
    public function getImageCinFace()
    {
        return $this->imageCinFace;
    }

    /**
     * Set imageCinPile
     *
     * @param string $imageCinPile
     * @return Inscrit
     */
    public function setImageCinPile($imageCinPile)
    {
        $this->imageCinPile = $imageCinPile;

        return $this;
    }

    /**
     * Get imageCinPile
     *
     * @return string 
     */
    public function getImageCinPile()
    {
        return $this->imageCinPile;
    }



    /**
     * Set fawj
     *
     * @param string $fawj
     * @return Inscrit
     */
    public function setFawj($fawj)
    {
        $this->fawj = $fawj;

        return $this;
    }

    /**
     * Get fawj
     *
     * @return string 
     */
    public function getFawj()
    {
        return $this->fawj;
    }

    /**
     * Set wehda
     *
     * @param string $wehda
     * @return Inscrit
     */
    public function setWehda($wehda)
    {
        $this->wehda = $wehda;

        return $this;
    }

    /**
     * Get wehda
     *
     * @return string 
     */
    public function getWehda()
    {
        return $this->wehda;
    }
    
    function getLastDirassa() {
        return $this->lastDirassa;
    }

    function getIdDirassa() {
        return $this->idDirassa;
    }

    function getIdKesm() {
        return $this->idKesm;
    }

    function getIdJiha() {
        return $this->idJiha;
    }

    function setLastDirassa(\DbBundle\Entity\AtributType $lastDirassa) {
        $this->lastDirassa = $lastDirassa;
    }

    function setIdDirassa(\DbBundle\Entity\AtributType $idDirassa) {
        $this->idDirassa = $idDirassa;
    }

    function setIdKesm(\DbBundle\Entity\Kesm $idKesm) {
        $this->idKesm = $idKesm;
    }

    function setIdJiha(\DbBundle\Entity\Jiha $idJiha) {
        $this->idJiha = $idJiha;
    }

    function getAccepteW() {
        return $this->accepteW;
    }

    function getAccepteMessageW() {
        return $this->accepteMessageW;
    }

    function getAccepteJ() {
        return $this->accepteJ;
    }

    function getAccepteMessageJ() {
        return $this->accepteMessageJ;
    }

    function getPaye() {
        return $this->paye;
    }

    function getIdMarkez() {
        return $this->idMarkez;
    }

    function getIdDirassaA() {
        return $this->idDirassaA;
    }

    function setAccepteW($accepteW) {
        $this->accepteW = $accepteW;
    }

    function setAccepteMessageW($accepteMessageW) {
        $this->accepteMessageW = $accepteMessageW;
    }

    function setAccepteJ($accepteJ) {
        $this->accepteJ = $accepteJ;
    }

    function setAccepteMessageJ($accepteMessageJ) {
        $this->accepteMessageJ = $accepteMessageJ;
    }

    function setPaye($paye) {
        $this->paye = $paye;
    }

    function setIdMarkez(\DbBundle\Entity\MarkezTadrib $idMarkez) {
        $this->idMarkez = $idMarkez;
    }

    function setIdDirassaA(\DbBundle\Entity\DawraTadrib $idDirassaA) {
        $this->idDirassaA = $idDirassaA;
    }

    function getPresence() {
        return $this->presence;
    }

    function getResult() {
        return $this->result;
    }

    function setPresence($presence) {
        $this->presence = $presence;
    }

    function setResult($result) {
        $this->result = $result;
    }

    function getSex() {
        return $this->sex;
    }

    function setSex($sex) {
        $this->sex = $sex;
    }


    
    
}
