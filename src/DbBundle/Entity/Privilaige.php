<?php

namespace DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Privilaige
 */
class Privilaige
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $actif;

    /**
     * @var \UserBundle\Entity\User
     */
    private $idUser;

    /**
     * @var \DbBundle\Entity\Sifa
     */
    private $idSifa;

    /**
     * @var \DbBundle\Entity\Jiha
     */
    private $idJiha;

    /**
     * @var \UserBundle\Entity\User
     */
    private $idDonneur;


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
     * Set date
     *
     * @param \DateTime $date
     * @return Privilaige
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set actif
     *
     * @param integer $actif
     * @return Privilaige
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
     * Set idUser
     *
     * @param \UserBundle\Entity\User $idUser
     * @return Privilaige
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
     * Set idSifa
     *
     * @param \DbBundle\Entity\Sifa $idSifa
     * @return Privilaige
     */
    public function setIdSifa(\DbBundle\Entity\Sifa $idSifa = null)
    {
        $this->idSifa = $idSifa;

        return $this;
    }

    /**
     * Get idSifa
     *
     * @return \DbBundle\Entity\Sifa 
     */
    public function getIdSifa()
    {
        return $this->idSifa;
    }

    /**
     * Set idJiha
     *
     * @param \DbBundle\Entity\Jiha $idJiha
     * @return Privilaige
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

    /**
     * Set idDonneur
     *
     * @param \UserBundle\Entity\User $idDonneur
     * @return Privilaige
     */
    public function setIdDonneur(\UserBundle\Entity\User $idDonneur = null)
    {
        $this->idDonneur = $idDonneur;

        return $this;
    }

    /**
     * Get idDonneur
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdDonneur()
    {
        return $this->idDonneur;
    }
}
