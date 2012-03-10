<?php

namespace Mcms\UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Mcms\UsersBundle\Entity\Role
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity
 */
class Role implements RoleInterface
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
     * @var string $name
     * 
     * @ORM\Column(name="name", type="string", length=255, unique=true)
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
     * Gets the role name.
     * 
     * @return string The role name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the role name.
     * 
     * @param string $value The role name.
     */
    public function setName($value)
    {
        $this->name = $value;
    }

    /**
     * Gets the role.Implementation of getRole from RoleInterface.
     * 
     * @return string The role name.
     */
    public function getRole()
    {
        return $this->getName();
    }
}