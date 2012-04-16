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
	 * @Route("/patient/new")
	 * @Template("McmsPatientBundle:Patient:register.html.twig")
	 */
	public function registerAction()
	{
		$form = $this->createForm(new RegistrationType(), new Registration());

		return array('form'=>$form->createView());
	}

	/**
	 * @Route("/patient/create",name="createpatient")
	 * @Template("McmsPatientBundle:Patient:register.html.twig")
	 */
	public function registerProcessAction()
	{
		/**
		 * 1) Validate form
		 * 2) Create new user
		 * 3) Create new patient
		 * 4) Store user and patient in DB
		 * 5) Show success page/message + printable page with details
		 */
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
        	$em->persist($user);
        	$em->persist($patient);
        	$em->flush();

		}
		return array('form'=>$form->createView());
	}
}