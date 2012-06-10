<?php

namespace Mcms\PatientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}