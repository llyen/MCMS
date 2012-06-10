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
}