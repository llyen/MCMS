<?php

namespace Mcms\PatientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mcms\PatientBundle\Form\Type\RegistrationType;
use Mcms\PatientBundle\Form\Model\Registration;

class PatientController extends Controller
{
    /**
     * List all patients
     * 
     * @param String $roleTheme Theme role switcher.
     */
    public function listAction($roleTheme)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $patients = $em->getRepository('McmsPatientBundle:Patient')->findAll();

        return $this->render('McmsPatientBundle:'.$roleTheme.':list.html.twig', array(
            'patients' => $patients
        ));
    }

    /**
     * Finds and display details of single patient
     * 
     * @param String $roleTheme Theme role switcher.
     * @param integer $patientId Patient unique id.
     */
    public function showAction($roleTheme, $patientId)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $patient = $em->getRepository('McmsPatientBundle:Patient')->find($patientId);
        
        if(!$patient) {
            throw $this->createNotFoundException('Unable to find Patient.');
        }

        return $this->render('McmsPatientBundle:'.$roleTheme.':show.html.twig', array(
            'patient' => $patient
        ));
    }

    /**
     * Displays form to create new patient account.
     */
    public function newAction()
    {
        $form = $this->createForm(new RegistrationType(), new Registration());

        return $this->render('McmsPatientBundle::register.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Creates a new Patient account.
     */
    public function createAction()
    {
        $request = $this->getRequest();

        $form = $this->createForm(new RegistrationType(), new Registration());
        $form->bindRequest($request);

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

            return $this->redirect($this->generateUrl('employee.patientShow', array('patientId' => $patient->getId())));
        }

        return $this->render('McmsPatientBundle::register.html.twig', array(
            'form' => $form->createView()
        ));
    }
}