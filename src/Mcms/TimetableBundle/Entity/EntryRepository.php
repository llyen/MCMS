<?php

namespace Mcms\TimetableBundle\Entity;

use Doctrine\ORM\EntityRepository;

use Mcms\PatientBundle\Entity\Patient;
use Mcms\EmployeeBundle\Entity\Employee;
/**
 * EntryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EntryRepository extends EntityRepository
{
    /**
     * Finds and returns entries by Patient
     * 
     * @param Patient $patient
     */
    public function findByPatient(Patient $patient)
    {
        return $this->findBy(array('patient' => $patient->getId()));
    }

    /**
     * Finds and returns entries by Employee
     * 
     * @param Employee $employee
     */
    public function findByEmployee(Employee $employee)
    {
        return $this->findBy(array('employee' => $employee->getId()));
    }
}