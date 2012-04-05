<?php

namespace Mcms\PatientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mcms\PatientBundle\Entity\Patient
 *
 * @ORM\Table(name="patients")
 * @ORM\Entity(repositoryClass="Mcms\PatientBundle\Entity\PatientRepository")
 */
class Patient
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
     * @var String $pesel
     * 
     * @ORM\Column(name="pesel", type="string", length="11")
     */
    private $pesel;

    /**
     * @var String $address1
     * 
     * @ORM\Column(name="address1", type="string", length="40")
     */
    private $address1;

    /**
     * @var String $address2
     * 
     * @ORM\Column(name="address2", type="string", length="40")
     */
    private $address2;

    /**
     * @var String $postalCode
     * 
     * @ORM\Column(name="postalCode", type="string", length="5")
     */
    private $postalCode;

    /**
     * @var String $city
     * 
     * @ORM\Column(name="city", type="string", length="30")
     */
    private $city;

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
     * Get the pesel.
     * 
     * @return String The pesel
     */
    public function getPesel()
    {
        return $this->pesel;
    }

    /**
     * Set the pesel
     * 
     * @param String $value The pesel.
     */
    public function setPesel($value)
    {
        $this->pesel = $value;
    }

    /**
     * Get the address1
     * 
     * @return String The address1.
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set the address1.
     * 
     * @param String $value The address1
     */
    public function setAddress1($value)
    {
        $this->address1 = $value;
    }

    /**
     * Get the address2
     * 
     * @return String The address1.
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set the address2.
     * 
     * @param String $value The address1
     */
    public function setAddress2($value)
    {
        $this->address2 = $value;
    }

    /**
     * Get the postal code.
     * 
     * @return String The postal code.
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set the postal code.
     * 
     * @param String $value The postal code.
     */
    public function setPostalCode($value)
    {
        $this->postalCode = $value;
    }

    /**
     * Get the city
     * 
     * @return String The city.
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the city.
     * 
     * @param String $value The city.
     */
    public function setCity($value)
    {
        $this->city = $value;
    }
}