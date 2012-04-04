<?php

namespace Mcms\EmployeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mcms\EmployeeBundle\Entity\Employee
 *
 * @ORM\Table(name="employees")
 * @ORM\Entity(repositoryClass="Mcms\EmployeeBundle\Entity\EmployeeRepository")
 */
class Employee
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $userId
     * 
     * @ORM\OneToOne(targetEntity="Mcms\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var String $position
     * 
     * @ORM\Column(name="position", type="string", length="40")
     */
    private $position;

    /**
     * Get the id.
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the user id.
     * 
     * @return integer The user id
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the user id.
     * 
     * @param integer $value The user id.
     */
    public function setUserId($value)
    {
        $this->userId = $value;
    }

    /**
     * Get the position.
     * 
     * @return String The position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set the position.
     * 
     * @param String $value The position
     */
    public function setPosition($value)
    {
        $this->position = $value;
    }
}