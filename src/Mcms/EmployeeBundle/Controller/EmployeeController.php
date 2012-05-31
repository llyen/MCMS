<?php

namespace Mcms\EmployeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class EmployeeController extends Controller
{
    /**
     * Creates and returns employees list
     * 
     * @param String $roleTheme Role theme name.
     */
    public function listAction($roleTheme)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $employees = $em->getRepository('McmsEmployeeBundle:Employee')->findAll();

        return $this->render('McmsEmployeeBundle:'.$roleTheme.':list.html.twig',array(
            'employees' => $employees
        ));
    }

    /**
     * Finds and returns all information about certan employee
     * 
     * @param integer $id Employee Id.
     * @param String $roleTheme Role theme name.
     */
    public function showAction($id, $roleTheme)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $employee = $em->getRepository('McmsEmployeeBundle:Employee')->find($id);

        if(!$employee)
        {
            throw $this->createNotFoundException('Unable to find employee.');
        }

        return $this->render('McmsEmployeeBundle:'.$roleTheme.':show.html.twig',array(
            'employee' => $employee
        ));
    }
}