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
 * @ORM\HasLifeCycleCallbacks
 */
class User implements UserInterface, \Serializable
{
    const DEFAULT_ROLE = 'ROLE_DEFAULT_USER';

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
     * @ORM\OneToMany(targetEntity="UserRole", mappedBy="userId")
     */
    private $userRoles;

    /**
     * @var boolean $isActive
     * 
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive = false;

    /**
     * @var DateTime $createdAt
     * 
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime $updatedAt
     * 
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

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
    public function setLastName($value)
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
        $roles = array();

        foreach ($this->userRoles as $key => $value) {
            $roles[$key] = $value->getRoleId()->getName();
        }

        $roles[] = static::DEFAULT_ROLE;

        return array_unique($roles);
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
    
    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
    }
    
    /**
     * Add userRoles
     *
     * @param Mcms\UserBundle\Entity\UserRole $userRoles
     */
    public function addUserRole(\Mcms\UserBundle\Entity\UserRole $userRoles)
    {
        $this->userRoles[] = $userRoles;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Get creation date and time
     * 
     * @return DateTime Creation date and time.
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     * 
     * Set creation date and time.
     * Called automaticly.
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     * 
     * Set last edit date and time.
     * Caled automaticly.
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
            $this->firstName,
            $this->lastName,
            $this->userRoles,
            $this->isActive,
            $this->createdAt,
            $this->updatedAt
        ));
    }

    public function unserialize($data)
    {
        list(
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
            $this->firstName,
            $this->lastName,
            $this->userRoles,
            $this->isActive,
            $this->createdAt,
            $this->updatedAt
        ) = unserialize($data);
    }
}