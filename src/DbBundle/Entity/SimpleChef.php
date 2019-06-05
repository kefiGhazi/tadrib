<?php

namespace DbBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * SimpleChef
 */
class SimpleChef
{

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     * )
     * @Assert\Regex(pattern="/[0-9]{8}/")
     */
    private $cin;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      max = 10,
     * )
     * @Assert\Regex(pattern="/[0-9]{10}/")
     */
    private $numInscrit;

    function getCin() {
        return $this->cin;
    }

    function getNumInscrit() {
        return $this->numInscrit;
    }

    function setCin($cin) {
        $this->cin = $cin;
    }

    function setNumInscrit($numInscrit) {
        $this->numInscrit = $numInscrit;
    }





}
