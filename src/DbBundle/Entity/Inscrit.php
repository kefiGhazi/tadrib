<?php

namespace DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscrit
 */
class Inscrit
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DbBundle\Entity\Chef
     */
    private $idChef;

    /**
     * @var \DbBundle\Entity\AtributType
     */
    private $idDirassa;

    /**
     * @var \DbBundle\Entity\Kesm
     */
    private $idKesm;

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

    /**
     * @return Chef
     */
    public function getIdChef()
    {
        return $this->idChef;
    }

    /**
     * @param Chef $idChef
     */
    public function setIdChef($idChef)
    {
        $this->idChef = $idChef;
    }

    /**
     * @return AtributType
     */
    public function getIdDirassa()
    {
        return $this->idDirassa;
    }

    /**
     * @param AtributType $idDirassa
     */
    public function setIdDirassa($idDirassa)
    {
        $this->idDirassa = $idDirassa;
    }

    /**
     * @return Link
     */
    public function getIdLink()
    {
        return $this->idLink;
    }

    /**
     * @param Link $idLink
     */
    public function setIdLink($idLink)
    {
        $this->idLink = $idLink;
    }

    /**
     * @return Kesm
     */
    public function getIdKesm()
    {
        return $this->idKesm;
    }

    /**
     * @param Kesm $idKesm
     */
    public function setIdKesm($idKesm)
    {
        $this->idKesm = $idKesm;
    }


    



    
    
}
