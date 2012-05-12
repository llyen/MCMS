<?php

namespace Mcms\TimetableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mcms\PatientBundle\Entity\Patient;
use Mcms\EmployeeBundle\Entity\Employee;

class TimetableController extends Controller
{
    /**
     * List entries
     * 
     * @param String $roleTheme Role theme name.
     * @param Patient $patient An Patient entity
     * @param Employee $employee An Employee entity
     */
    public function listAction(Patient $patient = null, Employee $employee = null,$roleTheme)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entries = $em->getRepository('McmsTimetableBundle:Entry')->findBy(array(
            'patient' => $patient ? $patient->getId() : null,
            'employee' => $employee ? $employee->getId() : null
        ));

        return $this->render('McmsTimetableBundle:'.$roleTheme.':list.html.twig', array(
            'entries' => $entries,
        ));
    }

    /**
     * Finds and display single timetable entry
     * 
     * @param String $roleTheme Role theme name.
     * @param integer $id Time table entry id
     */
    public function show($roleTheme, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entry = $em->getRepository('McmsTimetableBundle:Entry')->find($id);

        if(!$entry) {
            throw $this->createNotFoundException('Unable to find timetable entry.');
        }

        return $this->render('McmsTimetableBundle:'.$roleTheme.':show.html.twig', array(
            'entry' => $entry
        ));
    }


}