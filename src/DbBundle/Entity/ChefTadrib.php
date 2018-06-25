<?php

namespace DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ChefTadrib
 */
class ChefTadrib
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
     * @var \DbBundle\Entity\MostawaTadribi
     */
    private $idTadrib;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $chef;

    /**
     * @var string
     */
    private $lieux;


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
     * Set idChef
     *
     * @param integer $idChaf
     * @return ChefTadrib
     */
    public function setIdChef(\DbBundle\Entity\Chef $idChaf)
    {
        $this->idChef = $idChef;

        return $this;
    }

    /**
     * Get idChef
     *
     * @return integer 
     */
    public function getIdChef()
    {
        return $this->idChef;
    }

    /**
     * Set idTadrib
     *
     * @param \DbBundle\Entity\MostawaTadribi
     * @return ChefTadrib
     */
    public function setIdTadrib(\DbBundle\Entity\MostawaTadribi $idTadrib)
    {
        $this->idTadrib = $idTadrib;

        return $this;
    }

    /**
     * Get idTadrib
     *
     * @return integer 
     */
    public function getIdTadrib()
    {
        return $this->idTadrib;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return ChefTadrib
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set chef
     *
     * @param string $chef
     * @return ChefTadrib
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
     * Set lieux
     *
     * @param string $lieux
     * @return ChefTadrib
     */
    public function setLieux($lieux)
    {
        $this->lieux = $lieux;

        return $this;
    }

    /**
     * Get lieux
     *
     * @return string 
     */
    public function getLieux()
    {
        return $this->lieux;
    }
}
