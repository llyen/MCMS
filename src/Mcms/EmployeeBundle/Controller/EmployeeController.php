<?php

namespace Mcms\EmployeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EmployeeController extends Controller
{
    /**
     * Creates and returns employees list
     * 
     * @return Array The employees list.
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $employees = $em->getRepository('McmsEmployeeBundle:Employee')->findAll();

        return $employees;
    }

    /**
     * Finds and returns all information about certan employee
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $employee = $em->getRepository('McmsEmployeeBundle:Employee')->find($id);

        if(!$employee)
        {
            throw $this->createNotFoundException('Unable to find employee.');
        }

        return $employee;
    }
}