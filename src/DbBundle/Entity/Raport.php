<?php

namespace DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Raport
 */
class Raport
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
     * @var string
     */
    private $activite;

    /**
     * @var string
     */
    private $cause;

    /**
     * @var string
     */
    private $lieu;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $mochref;

    /**
     * @var string
     */
    private $note;

    /**
     * @var string
     */
    private $resume;

    /**
     * @var integer
     */
    private $actif = 1;

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
     * @param \DbBundle\Entity\Chef $idChef
     * @return Raport
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

    
    /**
     * Set activite
     *
     * @param string $activite
     * @return Raport
     */
    public function setActivite($activite)
    {
        $this->activite = $activite;

        return $this;
    }

    /**
     * Get activite
     *
     * @return string 
     */
    public function getActivite()
    {
        return $this->activite;
    }

    /**
     * Set cause
     *
     * @param string $cause
     * @return Raport
     */
    public function setCause($cause)
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * Get cause
     *
     * @return string 
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     * @return Raport
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string 
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Raport
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
     * Set mochref
     *
     * @param string $mochref
     * @return Raport
     */
    public function setMochref($mochref)
    {
        $this->mochref = $mochref;

        return $this;
    }

    /**
     * Get mochref
     *
     * @return string 
     */
    public function getMochref()
    {
        return $this->mochref;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Raport
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set resume
     *
     * @param string $resume
     * @return Raport
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string 
     */
    public function getResume()
    {
        return $this->resume;
    }
    
    function getActif() {
        return $this->actif;
    }

    function setActif($actif) {
        $this->actif = $actif;
    }


}
