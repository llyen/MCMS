<?php

namespace Mcms\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
<<<<<<< HEAD
use Doctrine\Common\Collections\ArrayCollection;
=======
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
use Doctrine\Common\Collections\ArrayCollection;
>>>>>>> upstream/master
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Mcms\UserBundle\Entity\Role
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="Mcms\UserBundle\Entity\RoleRepository")
 */
<<<<<<< HEAD
<<<<<<< HEAD
class Role implements RoleInterface, \Serializable
=======
class Role implements RoleInterface
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
class Role implements RoleInterface, \Serializable
>>>>>>> upstream/master
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
     * @var ArrayCollection $users
     * 
<<<<<<< HEAD
<<<<<<< HEAD
     * @ORM\OneToMany(targetEntity="UserRole", mappedBy="roleId")
=======
     * @ORM\OneToMany(targetEntity="UserRole", mappedBy="User")
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
     * @ORM\OneToMany(targetEntity="UserRole", mappedBy="roleId")
>>>>>>> upstream/master
     */
    private $users;

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
    
    public function __construct()
    {
<<<<<<< HEAD
<<<<<<< HEAD
        $this->users = new ArrayCollection();
=======
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
        $this->users = new ArrayCollection();
>>>>>>> upstream/master
    }
    
    /**
     * Add users
     *
     * @param Mcms\UserBundle\Entity\UserRole $users
     */
    public function addUserRole(\Mcms\UserBundle\Entity\UserRole $users)
    {
        $this->users[] = $users;
    }

    /**
     * Get users
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> upstream/master

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->name,
            $this->users
        ));
    }

    public function unserialize($data)
    {
        list(
            $this->id,
            $this->name,
            $this->users
        ) = unserialize($data);
    }
<<<<<<< HEAD
=======
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
>>>>>>> upstream/master
}