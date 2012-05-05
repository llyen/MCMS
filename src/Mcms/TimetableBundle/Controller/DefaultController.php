<?php

namespace Mcms\TimetableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mcms\PatientBundle\Entity\Patient;
use Mcms\EmployeeBundle\EntityEmployee;

class DefaultController extends Controller
{
    /**
     * Finds and shows patient timetable entries
     * 
     * @param Patient $patient
     * 
     * @Template("McmsTimetableBundle::showEntries.html.twig")
     */
    public function showPatientEntriesAction(Patient $patient)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entries = $em->getRepository('McmsTimetableBundle:Entry')->findByPatient($patient);

        return array(
            'entries' => $entries
        );
    }

    /**
     * Finds and show employee timetable entries
     * 
     * @param Employee $employee.
     * 
     * @Template("McmsTimetableBundle::showEntries.html.twig")
     */
    public function showEmployeeEntriesAction(Employee $employee)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entries = $em->getEntityManager('McmsTimetableBundle:Entry')->findByEmployee($employee);

        return array(
            'entries' => $entries
        );
    }

}
