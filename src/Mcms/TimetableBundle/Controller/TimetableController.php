<?php

namespace Mcms\TimetableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mcms\PatientBundle\Entity\Patient;
use Mcms\EmployeeBundle\Entity\Employee;

class TimetableController extends Controller
{
    /**
     * Finds and returns patient timetable entries
     * 
     * @param Patient $patient
     */
    public function showPatientEntriesAction(Patient $patient)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entries = $em->getRepository('McmsTimetableBundle:Entry')->findByPatient($patient);

        return $entries;    
    }

    /**
     * Finds and returns employee timetable entries
     * 
     * @param Employee $employee.
     */
    public function showEmployeeEntriesAction(Employee $employee)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entries = $em->getRepository('McmsTimetableBundle:Entry')->findByEmployee($employee);

        return $entries;
    }

    /**
     * List all entries
     * @Template("McmsTimetableBundle::showEntries.html.twig")
     * @param Array $params An array with Patient,Employe
     */
    public function listAction(Patient $patient = null, Employee $employee = null)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entries = $em->getRepository('McmsTimetableBundle:Entry')->findBy(array(
            'patient' => $patient ? $patient->getId() : null,
            'employee' => $employee ? $employee->getId() : null
        ));

        return array('entries' => $entries);
    }


}