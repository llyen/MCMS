<?php

namespace Mcms\EmployeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mcms\EmployeeBundle\Form\Type\RegistrationType;
use Mcms\EmployeeBundle\Form\Model\Registration;

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
     * @param integer $employeeId Employee Id.
     * @param String $roleTheme Role theme name.
     */
    public function showAction($employeeId, $roleTheme)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $employee = $em->getRepository('McmsEmployeeBundle:Employee')->find($employeeId);

        if(!$employee)
        {
            throw $this->createNotFoundException('Unable to find employee.');
        }

        return $this->render('McmsEmployeeBundle:'.$roleTheme.':show.html.twig',array(
            'employee' => $employee
        ));
    }

    /**
     * Displays a form to create new Employee account.
     */
    public function newAction()
    {
        $form = $this->createForm(new RegistrationType(), new Registration());

        return $this->render('McmsEmployeeBundle:Admin:new.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * Creates new Employee acoount.
     */
    public function createAction()
    {
        $form = $this->createForm(new RegistrationType(), new Registration());
        $form->bindRequest($this->getRequest());

        if($form->isValid())
        {
            $registration = $form->getData();

            $user = $registration->getUser();
            $employee = $registration->getEmployee();

            $employee->setUser($user);

            $em = $this->getDoctrine()->getEntityManager();

            $role = $em->getRepository('McmsUserBundle:Role')->findOneByName('ROLE_EMPLOYEE');
            if (!$role)
            {
                throw $this->creteNewnotFoundException('Unable to find Employee role.');
            }

            $user->getUserRoles()->add($role);

            $em->persist($user);
            $em->persist($employee);
            $em->flush();

            return $this->redirect($this->generateUrl('admin.employeeShow', array('employeeId' => $employee->getId())));
        }

        return $this->render('McmsEmployeeBundle:Admin:new.html.twig',array(
            'form' => $form->createView()
        ));
    }
}