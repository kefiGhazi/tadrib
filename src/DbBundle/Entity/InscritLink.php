<?php

namespace DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InscritLink
 */
class InscritLink
{
    /**
     * @var int
     */
    private $id;
    

    /**
     * @var \DbBundle\Entity\AtributType
     */
    private $lastDirassa;
    /**
     * @var \DbBundle\Entity\Chef
     */
    private $idChef;

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
     * @var \DbBundle\Entity\Link
     */
    private $idLink;
    
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
    function getLastDirassa() {
        return $this->lastDirassa;
    }

    function getChefLastDirassa() {
        return $this->chefLastDirassa;
    }

    function getLieuxLastDirassa() {
        return $this->lieuxLastDirassa;
    }

    function getMoisLastDirassa() {
        return $this->moisLastDirassa;
    }

    function getYearLastDirassa() {
        return $this->yearLastDirassa;
    }

    function getIdLink() {
        return $this->idLink;
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

    function getPresence() {
        return $this->presence;
    }

    function getResult() {
        return $this->result;
    }

    function getIdDirassaA() {
        return $this->idDirassaA;
    }

    function setLastDirassa(\DbBundle\Entity\AtributType $lastDirassa) {
        $this->lastDirassa = $lastDirassa;
    }

    function setChefLastDirassa($chefLastDirassa) {
        $this->chefLastDirassa = $chefLastDirassa;
    }

    function setLieuxLastDirassa($lieuxLastDirassa) {
        $this->lieuxLastDirassa = $lieuxLastDirassa;
    }

    function setMoisLastDirassa($moisLastDirassa) {
        $this->moisLastDirassa = $moisLastDirassa;
    }

    function setYearLastDirassa($yearLastDirassa) {
        $this->yearLastDirassa = $yearLastDirassa;
    }

    function setIdLink(\DbBundle\Entity\Link $idLink) {
        $this->idLink = $idLink;
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

    function setPresence($presence) {
        $this->presence = $presence;
    }

    function setResult($result) {
        $this->result = $result;
    }

    function setIdDirassaA($idDirassaA) {
        $this->idDirassaA = $idDirassaA;
    }

    function getIdChef(){
        return $this->idChef;
    }

    function setIdChef(\DbBundle\Entity\Chef $idChef) {
        $this->idChef = $idChef;
    }


    
    
}
