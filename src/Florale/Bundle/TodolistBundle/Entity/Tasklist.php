<?php

namespace Florale\Bundle\TodolistBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * tasklist
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Florale\Bundle\TodolistBundle\Entity\Repository\TasklistRepository")
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
     * @ORM\OneToMany(targetEntity="Task", mappedBy="tasklist", cascade={"remove"})
     **/
    private $tasks;
    
    public function __construct() {
        $this->tasks = new ArrayCollection();
    }


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


    /**
     * Add tasks
     *
     * @param \Florale\Bundle\TodolistBundle\Entity\Task $tasks
     * @return Tasklist
     */
    public function addTask(\Florale\Bundle\TodolistBundle\Entity\Task $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \Florale\Bundle\TodolistBundle\Entity\Task $tasks
     */
    public function removeTask(\Florale\Bundle\TodolistBundle\Entity\Task $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
