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
        $unassignedDates = $this->removeTakenDates($entries, $month, $year);

        //if request is from AJAX call
        if($this->getRequest()->isXmlHttpRequest()) {
            $response = new \Symfony\Component\HttpFoundation\Response(json_encode($unassignedDates));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        return $this->render('McmsTimetableBundle:'.$roleTheme.':monthlyTimetable.html.twig',array(
            'entries' => $entries,
            'unassignedDates' => $unassignedDates
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
    public function newAction($roleTheme, $patientId = null, $employeeId = null, $year, $month, $day, $hours, $minutes)
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

        $form = $this->createForm(new EntryType(), $entry);

        return $this->render('McmsTimetableBundle:'.$roleTheme.':newEntry.html.twig', array(
            'form' => $form->createView(),
            'employeeId' => $employeeId,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'hours' => $hours,
            'minutes' => $minutes
        ));
    }

    /**
     * Creates new entry
     * 
     * @param String $roleTheme Role theme name.
     */
    public function createAction($roleTheme, $patientId = null, $employeeId = null, $year, $month, $day, $hours, $minutes)
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

        $entryDate = new \DateTime("$year-$month-$day $hours:$minutes");

        $request = $this->getRequest();

        $form = $this->createForm(new EntryType(), $entry);
        $form->bindRequest($request);

        if($form->isValid())
        {
            $entry->setPatient($patient);
            $entry->setEmployee($employee);
            $entry->setDate($entryDate);

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

        return $this->render('McmsTimetableBundle:'.$roleTheme.':newEntry.html.twig', array(
            'form' => $form->createView(),
            'employeeId' => $employeeId,
            'year' => $year,
            'month' => $month,
            'day' => $day,
            'hours' => $hours,
            'minutes' => $minutes
        ));
    }

    /**
     * Creates and returns associated array with dates and hours that are free based on entries from database and range interval array.
     * 
     * @param Array $entries Array with entries found in database.
     * @param String $month The month.
     * @param String $year The year.
     * 
     * @return Array
     */
    private function removeTakenDates($entries,$month, $year)
    {
        $firstOfMonth = date('Y-m-d',strtotime($year.'-'.$month.'-01 00:00:00'));
        $lastOfMonth = date('Y-m-d', strtotime('-1 second',strtotime('+1 month',strtotime($year.'-'.$month.'-01 00:00:00'))));
        
        $dateRangeIntervalArr = $this->createDateRangeIntervalArray($firstOfMonth, '08:00', $lastOfMonth, '18:00', '+15 minutes');

        foreach ($entries as $entry) {
            $key=$this->array_search($entry->getDate()->format('Y-m-d H:i'), $dateRangeIntervalArr);
            if($key!==false)
            {
                unset($dateRangeIntervalArr[$key]);
            }
        }

        foreach ($dateRangeIntervalArr as $value) {
            $out[date('Y-m-d',strtotime($value))][]=date('H:i',strtotime($value));
        };
        
        return $out;
    }


    /**
     * Creates and return array with datetime elements between 2 dates, in range between 2 hours with certain interval.
     * 
     * @param String $startDay Eg. 2012-05-25
     * @param String $startHour Eg. 08:00
     * @param String $endDay Eg. 2012-06-10
     * @param String $endHour Eg. 16:00
     * @param String $interval Eg. +10 minutes
     */
    private function createDateRangeIntervalArray($startDay, $startHour, $endDay, $endHour, $interval)
    {
        $out = array();

        $first = strtotime($startDay.' '.$startHour);
        $current = $first;
        $last = strtotime($endDay.' '.$endHour);

        while ($current < $last) {
            $out[] = date('Y-m-d H:i',$current);
            $current = strtotime( $interval, $current );

            $d = date('Y-m-d', $current);

            if($current>strtotime($d.' '.$endHour))
            {
                $current = strtotime("+1 day", strtotime($d.' '.$startHour));
            }
        }
        
        return $out;
    }

    /**
     * Searches the array for a given value and returns the corresponding key if successful
     * 
     * @param Mixed $needle Searched value.
     * @param Array $array The array.
     * 
     * @return Boolean|Integer Returns the key for searched value if found in the array, FALSE otherwise.
     */
    private function array_search($needle,$array)
    { 
        foreach($array as $key => $value) { 
            if($needle === $value) 
                return $key; 
        } 
        return false; 
    } 
}