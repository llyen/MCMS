<?php

namespace Mcms\UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Mcms\UsersBundle\Entity\User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User implements UserInterface
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
     * @var string $username
     * 
     * @ORM\Column(name="username", type="string", length=100, unique=true)
     */
    private $username;
    
    /**
     * @var string $salt 
     *
     * @ORM\Column(name="salt", type="string", length=40)
     */
    private $salt;

    /**
     * @var string $password
     * 
     * @ORM\Column(name="password", type="string", length=40)
     */
    private $password;

    /**
     * @var ArrayCollection $userRoles
     * 
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="user_role",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    private $userRoles;

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
     * Gets the username.
     * 
     * @return string The username.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets the username.
     * 
     * @param string $value The username.
     */
    public function setUsername($value)
    {
        $this->username = $value;
    }

    /**
     * Gets the password.
     * 
     * @return string The password.
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the password.
     * 
     * @param string $value The password.
     */
    public function setPassword($value)
    {
        $this->password = $value;
    }

    /**
     * Gets the salt.
     * 
     * @return string The salt.
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Sets the salt.
     * 
     * @param string $value The salt.
     */
    public function setSalt($value=null)
    {
        if ($value === null)
            $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        else
            $this->salt = $value;
    }

    /**
     * Erases the user credentials.
     */
    public function eraseCredentials()
    {        
    }

    /**
     * Compares this user to another to determine if they are the same.
     * 
     * @param UserInterface $user The user.
     * @return boolean True if equal, False if not.
     */
    public function equals(UserInterface $user)
    {
        return $this->getUsername() == $user->getUsername();
    }

    /**
     * Gets the user roles. Implementation of getRoles() from UserInterface.
     * 
     * @return array An array of Role objects.
     */
    public function getRoles()
    {
        return $this->getUserRoles()->toArray();
    }

    /**
     * Gets the user roles.
     * 
     * @return ArrayCollection An Doctrine ArrayCollection of user roles.
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }

    public function __construct()
    {
        $this->userRoles = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add userRoles
     *
     * @param Mcms\UsersBundle\Entity\Role $userRoles
     */
    public function addRole(\Mcms\UsersBundle\Entity\Role $userRoles)
    {
        $this->userRoles[] = $userRoles;
    }
}