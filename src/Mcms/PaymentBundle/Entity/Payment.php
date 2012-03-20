<?php

namespace Mcms\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mcms\PaymentBundle\Entity\Payment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mcms\PaymentBundle\Entity\PaymentRepository")
 */
class Payment
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
     * @var integer $patientId
     * 
     * @ORM\ManyToOne(targetEntity="Mcms\PatientBundle\Entity\Patient")
     * @ORM\JoinColumn(name="patientId", referencedColumnName="id")
     */
    private $patientId;

    /**
     * @var boolean $isPaid
     * 
     * @ORM\Column(name="isPaid", type="boolean")
     */
    private $isPaid = false;

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
     * Get patient id.
     * 
     * @return integer The patient id.
     */
    public function getPatientId()
    {
        return $this->patientId;
    }

    /**
     * Set the patient id.
     * 
     * @param integer $value The patient id.
     */
    public function setPatientId($value)
    {
        $this->patient = $value;
    }

    /**
     * Get the isPaid value.
     * 
     * @return boolean The isPaid value.
     */
    public function getIsPaid()
    {
        return $this->isPaid;
    }

    /**
     * Set the isPaid value.
     * 
     * @param boolean $value The isPaid value.
     */
    public function setIsPaid($value)
    {
        $this->isPaid = $value;
    }
}