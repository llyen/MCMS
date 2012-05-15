<?php

namespace Mcms\TimetableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mcms\PatientBundle\Entity\Patient;
use Mcms\EmployeeBundle\Entity\Employee;

class TimetableController extends Controller
{
    /**
     * Finds and renders monthly timetable for curent logged in user
     * 
     * @param integer $year The year no.
     * @param integer $month The month no.
     * @param String $roleTheme Role theme name.
     */
    public function myMonthlyTimetableAction($year = null, $month = null, $roleTheme)
    {
        $year = $year ? $year : date('o');
        $month = $month ? $month : date('n');

        $user = $this->get('security.context')->getToken()->getUser();

        if($roleTheme==='Patient') {
            $patient = $user->getPatient();
            $employee = null;
        } else {
            $patient = null;
            $employee = $user->getEmployee();
        }

        $em = $this->getDoctrine()->getEntityManager();

        $entries = $em->getRepository('McmsTimetableBundle:Entry')->findByMonth($year, $month, $employee, $patient);

        //if request is from AJAX call
        if($this->getRequest()->isXmlHttpRequest()) {
            return $this->render('McmsTimetableBundle::showMonth.html.twig',array(
                'entries' => $entries
            )); 
        }        

        return $this->render('McmsTimetableBundle:'.$roleTheme.':myTimetable.html.twig',array(
            'entries' => $entries
        ));
    }

    /**
     * Finds and display single timetable entry
     * 
     * @param String $roleTheme Role theme name.
     * @param integer $id Time table entry id.
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