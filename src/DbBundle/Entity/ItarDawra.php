<?php

namespace DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItarDawra
 */
class ItarDawra
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $actif;

    /**
     * @var \DbBundle\Entity\Dawra
     */
    private $idDawra;

    /**
     * @var \DbBundle\Entity\Sifa
     */
    private $idSifa;

    /**
     * @var \DbBundle\Entity\Chef
     */
    private $idChef;


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
     * Set actif
     *
     * @param integer $actif
     * @return ItarDawra
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
     * Set idDawra
     *
     * @param \DbBundle\Entity\Dawra $idDawra
     * @return ItarDawra
     */
    public function setIdDawra(\DbBundle\Entity\Dawra $idDawra = null)
    {
        $this->idDawra = $idDawra;

        return $this;
    }

    /**
     * Get idDawra
     *
     * @return \DbBundle\Entity\Dawra 
     */
    public function getIdDawra()
    {
        return $this->idDawra;
    }

    /**
     * Set idSifa
     *
     * @param \DbBundle\Entity\Sifa $idSifa
     * @return ItarDawra
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
     * Set idChef
     *
     * @param \DbBundle\Entity\Chef $idChef
     * @return ItarDawra
     */
    public function setIdChef(\DbBundle\Entity\Chef $idChef = null)
    {
        $this->idChef = $idChef;

        return $this;
    }

    /**
     * Get idChef
     *
     * @return \DbBundle\Entity\Chef 
     */
    public function getIdChef()
    {
        return $this->idChef;
    }
}
