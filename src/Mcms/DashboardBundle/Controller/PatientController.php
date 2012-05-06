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
     * Shows list of all employees
     * 
     * @Template("McmsDashboardBundle:Patient:listOfEmployees.html.twig")
     */
    public function listOfEmployeesAction()
    {
        $employees = $this->get('employee_controller')->createList();
        
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
        $employee = $this->get('employee_controller')->showSingle($id);

        return array(
            'employee' => $employee
        );
    }
}