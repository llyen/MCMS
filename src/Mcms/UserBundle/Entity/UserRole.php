<?php

namespace Mcms\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mcms\UserBundle\Entity\UserRole
 *
 * @ORM\Table(name="user_roles")
 * @ORM\Entity(repositoryClass="Mcms\UserBundle\Entity\UserRoleRepository")
 */
class UserRole
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
     * @var integer $user
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;

    /**
     * @var integer $role
     *
     * @ORM\ManyToOne(targetEntity="Role")
     */
    private $role;

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
     * Set user
     *
     * @param integer $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set role
     *
     * @param integer $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Get role
     *
     * @return Mcms\UserBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }
}