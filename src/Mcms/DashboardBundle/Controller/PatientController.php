<?php

namespace Mcms\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PatientController extends Controller
{
    /**
     * Base patient dashboard view
     * 
     * @Template("McmsDashboardBundle:Patient:patientIndex.html.twig")
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * Shows patient account details (Firstname,Lastname,Address etc)
     * 
     * @Template("McmsDashboardBundle:Patient:showMyAccount.html.twig")
     */
    public function showMyAccountAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        return array(
            'user' => $user
        );
    }

    /**
     * Shows patient timetable (archive/future meetings with DR)
     * 
     * @Template("McmsDashboardBundle:Patient:showTimetable.html.twig")
     */
    public function showTimetableAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $entries = $this->get('timetable_controller')->showPatientEntriesAction($user->getPatient());

        return array(
            'user' => $user,
            'entries' => $entries
        );
    }

    /**
     * Shows list of all employees
     * 
     * @Template("McmsDashboardBundle:Patient:listOfEmployees.html.twig")
     */
    public function listOfEmployeesAction()
    {
        $employees = $this->get('employee_controller')->listAction();
        
        return array(
            'employees' => $employees
        );
    }

    /**
     * Shows information about selected employee
     * 
     * @Template("McmsDashboardBundle:Patient:showEmployee.html.twig")
     */
    public function showEmployeeAction($id)
    {
        $employee = $this->get('employee_controller')->showAction($id);

        return array(
            'employee' => $employee
        );
    }

    /**
     * Shows employee timetable
     * 
     * @Template("McmsDashboardBundle:Patient:showEmployeeTimetable.html.twig")
     */
    public function showEmployeeTimetableAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $employee = $em->getRepository('McmsEmployeeBundle:Employee')->find($id);

        if(!$employee)
        {
            throw $this->createNotFoundException('Unable to find employee.');
        }

        $entries = $this->get('timetable_controller')->showEmployeeEntriesAction($employee);

        return array(
            'employee' => $employee,
            'entries' => $entries
        );
    }
}