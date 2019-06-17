<?php

namespace DbBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MarkezTadrib
 */
class MarkezTadrib
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DbBundle\Entity\Link
     */
    private $idLink;

    /**
     * @var string
     */
    private $nom;


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
     * @return MarkezTadrib
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


}
