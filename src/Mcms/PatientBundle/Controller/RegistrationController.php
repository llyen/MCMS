<?php

namespace Mcms\PatientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mcms\PatientBundle\Form\Type\RegistrationType;
use Mcms\PatientBundle\Form\Model\Registration;

class RegistrationController extends Controller
{

	/**
	 * Displays a form to create new Patient account.
	 * 
	 * @Route("/patient/new")
	 * @Template("McmsPatientBundle:Patient:register.html.twig")
	 */
	public function newAction()
	{
		$form = $this->createForm(new RegistrationType(), new Registration());

		return array('form' => $form->createView());
	}

	/**
	 * Creates a new Patient account.
	 * 
	 * @Route("/patient/create",name="createpatient")
	 * @Template("McmsPatientBundle:Patient:register.html.twig")
	 */
	public function createAction()
	{
		$form = $this->createForm(new RegistrationType(), new Registration());
		$form->bindRequest($this->getRequest());

		if($form->isValid())
		{
			$registration = $form->getData();
			
			/**
			 * Retrive User object from submited form.
			 * Retrive Patient object from submited form.
			 */
			$user = $registration->getUser();
			$patient = $registration->getPatient();

        	/**
        	 * Connect User with patient
        	 */
        	$patient->setUser($user);

			$em = $this->getDoctrine()->getEntityManager();

			$role = $em->getRepository('McmsUserBundle:Role')->findOneByName('ROLE_PATIENT');
			if (!$role)
			{
				throw $this->creteNewnotFoundException('Unable to find Patient role.');
			}
			
			$user->getUserRoles()->add($role);

        	$em->persist($user);
        	$em->persist($patient);
        	$em->flush();

		}

		return array('form'=>$form->createView());
	}
}