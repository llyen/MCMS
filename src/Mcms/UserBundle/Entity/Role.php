<?php

namespace Mcms\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Mcms\UserBundle\Entity\Role
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="Mcms\UserBundle\Entity\RoleRepository")
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
     * Get the role name.
     * 
     * @return string The role name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the role name.
     * 
     * @param string $value The role name.
     */
    public function setName($value)
    {
        $this->name = $value;
    }

    /**
     * Get the role.Implementation of getRole from RoleInterface.
     * 
     * @return string The role name.
     */
    public function getRole()
    {
        return $this->getName();
    }
}