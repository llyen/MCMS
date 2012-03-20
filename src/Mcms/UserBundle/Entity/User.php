<?php

namespace Mcms\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Mcms\UserBundle\Entity\User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Mcms\UserBundle\Entity\UserRepository")
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
     * @var string $password
     * 
     * @ORM\Column(name="password", type="string", length=40)
     */
    private $password;

    /**
     * @var string $salt 
     *
     * @ORM\Column(name="salt", type="string", length=40)
     */
    private $salt;

    /**
     * @var String $firstName
     * 
     * @ORM\Column(name="firstName", type="string", length="20")
     */
    private $firstName;

    /**
     * @var String $lastName
     * 
     * @ORM\Column(name="lastName", type="string", length="30")
     */
    private $lastName;

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
     * Get the username.
     * 
     * @return string The username.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the username.
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
     * Get the first name.
     * 
     * @return String The first name
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set the first name.
     * 
     * @param String $value The first name
     */
    public function setFirstName($value)
    {
        $this->firstName = $value;
    }

    /**
     * Get the last name.
     * 
     * @return String The last name
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set the last name.
     * 
     * @param String $value The last name
     */
    public function setLatName($value)
    {
        $this->lastName = $value;
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
     * Get the user roles. Implementation of getRoles() from UserInterface.
     * 
     * @return array An array of Role objects.
     */
    public function getRoles()
    {
        return $this->getUserRoles()->toArray();
    }

    /**
     * Get the user roles.
     * 
     * @return ArrayCollection An Doctrine ArrayCollection of user roles.
     */
    public function getUserRoles()
    {
        return $this->userRoles;
    }
}