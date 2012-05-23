<?php

namespace Mcms\TimetableBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mcms\TimetableBundle\Form\Type\EntryType;
use Mcms\TimetableBundle\Entity\Entry;

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

    public function monthlyTimetableAction($year = null, $month = null, $patientId = null, $employeeId = null, $roleTheme)
    {
        $year = $year ? $year : date('o');
        $month = $month ? $month : date('n');
        $patient = null;
        $employee = null;

        $em = $this->getDoctrine()->getEntityManager();

        if($patientId) {
            $patient = $em->getRepository('McmsPatientBundle:Patient')->find($patientId);

            if(!$patient) {
                throw $this->createNotFoundException('Unable to find patient.');
            }
        }

        if($employeeId) {
            $employee = $em->getRepository('McmsEmployeeBundle:Employee')->find($employeeId);

            if(!$employee) {
                throw $this->createNotFoundException('Unable to find employee.');
            }
        }

        $entries = $em->getRepository('McmsTimetableBundle:Entry')->findByMonth($year, $month, $employee, $patient);

        //if request is from AJAX call
        if($this->getRequest()->isXmlHttpRequest()) {
            return $this->render('McmsTimetableBundle::showMonth.html.twig',array(
                'entries' => $entries
            )); 
        }

        return $this->render('McmsTimetableBundle:'.$roleTheme.':monthlyTimetable.html.twig',array(
            'entries' => $entries
        ));
    }

    /**
     * Finds and display single timetable entry
     * 
     * @param String $roleTheme Role theme name.
     * @param integer $id Time table entry id.
     */
    public function showAction($roleTheme, $id)
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

    /**
     * Displays a form to create new entry in timetable
     * 
     * @param String $roleTheme Role theme name.
     */
    public function newAction($roleTheme, $patientId = null, $employeeId = null, $year = null, $month= null)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getEntityManager();

        //Set employee and patient object
        if($roleTheme === 'Patient') {
            $patient = $user->getPatient();
            $employee = $em->getRepository('McmsEmployeeBundle:Employee')->find($employeeId);

            if(!$employee) {
                throw $this->createNotFoundException('Unable to find employee.');
            }

        }

        //Set employee and patient object
        if($roleTheme === 'Employee') {
            $employee = $user->getEmployee();
            $patient = $em->getRepository('McmsPatientBundle:Patient')->find($patientId);

            if(!$patient) {
                throw $this->createNotFoundException('Unable to find patient.');
            }
        }



        $entry = new Entry();
        $entry->setPatient($patient);
        $entry->setEmployee($employee);

        $form = $this->createForm(new EntryType(), $entry);

        return $this->render('McmsTimetableBundle::new.html.twig', array(
            'form' => $form->createView(),
            'employeeId' => $employeeId,
            'year' => $year,
            'month' => $month
        ));
    }

    /**
     * Creates new entry
     * 
     * @param String $roleTheme Role theme name.
     */
    public function createAction($roleTheme, $patientId = null, $employeeId = null, $year = null, $month= null)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getEntityManager();

        if($roleTheme === 'Patient') {
            $patient = $user->getPatient();
            $employee = $em->getRepository('McmsEmployeeBundle:Employee')->find($employeeId);

            if(!$employee) {
                throw $this->createNotFoundException('Unable to find employee.');
            }

        }

        if($roleTheme === 'Employee') {
            $employee = $user->getEmployee();
            $patient = $em->getRepository('McmsPatientBundle:Patient')->find($patientId);

            if(!$patient) {
                throw $this->createNotFoundException('Unable to find patient.');
            }
        }

        $entry = new Entry();

        $request = $this->getRequest();

        $form = $this->createForm(new EntryType(), $entry);
        $form->bindRequest($request);

        if($form->isValid())
        {
            $entry->setPatient($patient);
            $entry->setEmployee($employee);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entry);
            $em->flush();

            return $this->redirect($this->generateUrl('patient.showEmployeeTimetable', array(
                'employeeId' => $employeeId,
                'year' => $year,
                'month' => $month
                )
            ));
        }

        return $this->render('McmsTimetableBundle::new.html.twig', array(
            'form' => $form->createView(),
            'employeeId' => $employeeId,
            'year' => $year,
            'month' => $month
        ));
    }
}