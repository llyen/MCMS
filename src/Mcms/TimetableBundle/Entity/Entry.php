<?php

namespace Mcms\TimetableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mcms\TimetableBundle\Entity\Entry
 *
 * @ORM\Table(name="timetableEntries")
 * @ORM\Entity(repositoryClass="Mcms\TimetableBundle\Entity\EntryRepository")
 */
class Entry
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
     * @var integer $patient
     * 
     * @ORM\ManyToOne(targetEntity="Mcms\PatientBundle\Entity\Patient")
     * @ORM\JoinColumn(name="patient", referencedColumnName="id")
     */
    private $patient;

    /**
     * @var integer $employee
     * 
     * @ORM\ManyToOne(targetEntity="Mcms\EmployeeBundle\Entity\Employee")
     * @ORM\JoinColumn(name="employee", referencedColumnName="id")
     */
    private $employee;

    /**
     * @var datetime $date
     * 
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Strng $comment
     * 
     * @ORM\Column(name="comment", type="string", length="3000")
     */
    private $comment;

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
     * Get the patient Id.
     * 
     * @return integer The patient id
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * Set the patient id.
     *
     * @param integer $value The patient id
     */
    public function setPatient($value)
    {
        $this->patient = $value;
    }

    /**
     * Get the employee Id.
     * 
     * @return integer The employee id
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set the employee id.
     *
     * @param integer $value The employee id
     */
    public function setEmployee($value)
    {
        $this->employee = $value;
    }

    /**
     * Get the date
     * 
     * @return datetime the date.
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the date.
     * 
     * @param DateTime $value The date.
     */
    public function setDate(\DateTime $value)
    {
        $this->createdAt = $value;
    }

    /**
     * Get the entry comment
     * 
     * @return String The entry comment.
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the entry comment.
     * 
     * @param String $value The entry comment.
     */
    public function setComment($value)
    {
        $this->comment = $value;
    }
}