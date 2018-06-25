<?php

namespace DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DawraTadrib
 */
class DawraTadrib
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DbBundle\Entity\MarkezTadrib
     */
    private $idMarkez;

    /**
     * @var \DbBundle\Entity\AtributType
     */
    private $idAtributType;

    /**
     * @var \DbBundle\Entity\Kesm
     */
    private $idKesm;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $chef;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $psw;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    function getIdMarkez() {
        return $this->idMarkez;
    }

    function getIdAtributType() {
        return $this->idAtributType;
    }

    function getIdKesm(){
        return $this->idKesm;
    }

    function setIdMarkez(\DbBundle\Entity\MarkezTadrib $idMarkez) {
        $this->idMarkez = $idMarkez;
    }

    function setIdAtributType(\DbBundle\Entity\AtributType $idAtributType) {
        $this->idAtributType = $idAtributType;
    }

    function setIdKesm(\DbBundle\Entity\Kesm $idKesm) {
        $this->idKesm = $idKesm;
    }

        /**
     * Set nom
     *
     * @param string $nom
     * @return DawraTadrib
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
     * Set chef
     *
     * @param string $chef
     * @return DawraTadrib
     */
    public function setChef($chef)
    {
        $this->chef = $chef;

        return $this;
    }

    /**
     * Get chef
     *
     * @return string 
     */
    public function getChef()
    {
        return $this->chef;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return DawraTadrib
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set psw
     *
     * @param string $psw
     * @return DawraTadrib
     */
    public function setPsw($psw)
    {
        $this->psw = $psw;

        return $this;
    }

    /**
     * Get psw
     *
     * @return string 
     */
    public function getPsw()
    {
        return $this->psw;
    }
}
