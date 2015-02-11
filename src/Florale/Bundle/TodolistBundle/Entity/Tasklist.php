<?php

namespace Florale\Bundle\TodolistBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * tasklist
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TodolistBundle\Entity\Repository\tasklistRepository")
 */
class Tasklist
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
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
     * Set color
     *
     * @param string $color
     * @return Tasklist
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
    * Get color
    *
    * @return string 
    */
    public function getColor()
    {
        return $this->color;
    }
    
     /**
     * Set name
     *
     * @param string $name
     * @return Tasklist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    
    /**
    * Get name
    *
    * @return string 
    */
    public function getName()
    {
        return $this->name;
    }

}
