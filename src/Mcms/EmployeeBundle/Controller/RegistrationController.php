<?php

namespace Mcms\EmployeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mcms\EmployeeBundle\Form\Type\RegistrationType;
use Mcms\EmployeeBundle\Form\Model\Registration;

class RegistrationController extends Controller
{
	/**
	 * @Route("/employee/new")
	 * @Template("McmsEmployeeBundle:Default:index.html.twig")
	 */
	public function registerAction()
	{
		$form = $this->createForm(new RegistrationType(), new Registration());

		return array('form' => $form->createView());
	}

	/**
	 * @Route("/employee/create", name="createemployee")
	 */
	public function registerProcessAction()
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
			$em->persist($user);
			$em->persist($employee);
			$em->flush();
		}

		return array('form'=>$form->createView());
	}
}