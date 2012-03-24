<?php

namespace Mcms\MedicalHistoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mcms\MedicalHistoryBundle\Entity\Entry
 *
 * @ORM\Table(name="medicalHistoryEntries")
 * @ORM\Entity(repositoryClass="Mcms\MedicalHistoryBundle\Entity\EntryRepository")
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
     * @var integer $patientId
     * 
     * @ORM\ManyToOne(targetEntity="Mcms\PatientBundle\Entity\Patient")
     * @ORM\JoinColumn(name="patientId", referencedColumnName="id")
     */
    private $patientId;

    /**
     * @var integer $doctorId
     * 
     * @ORM\ManyToOne(targetEntity="Mcms\EmployeeBundle\Entity\Employee")
     * @ORM\JoinColumn(name="doctorId", referencedColumnName="id")
     */
    private $doctorId;

    /**
     * @var datetime $createdAt
     * 
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime $editedAt
     * 
     * @ORM\Column(name="editedAt", type="datetime")
     */
    private $editedAt;

    /**
     * @var Strng $content
     * 
     * @ORM\Column(name="content", type="string", length="5000")
     */
    private $content;

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
     * Get the patient id
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
     * @param integer $value The patient id
     */
    public function setPatientId($value)
    {
        $this->patientId = $value;
    }

    /**
     * Get the doctor id
     * 
     * @return integer The doctor id.
     */
    public function getDoctorId()
    {
        return $this->doctorId;
    }

    /**
     * Set the doctor id.
     * 
     * @param integer $value The doctor id
     */
    public function setDoctorId($value)
    {
        $this->doctorId = $value;
    }

    /**
     * Get creation date and time
     * 
     * @return datetime Creation date and time.
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set creation date and time.
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get last edit date and time
     * 
     * @return datetime last edit date and time.
     */
    public function getEditedAt()
    {
        return $this->editedAt;
    }

    /**
     * Set last edit date and time.
     */
    public function setEditedAt()
    {
        $this->editedAt = new \DateTime();
    }

    /**
     * Get the entry content
     * 
     * @return String The entry content.
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the entry content.
     * 
     * @param String $value The entry content.
     */
    public function setContent($value)
    {
        $this->content = $value;
    }
}