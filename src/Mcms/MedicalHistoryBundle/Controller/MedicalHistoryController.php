<?php

namespace Mcms\MedicalHistoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MedicalHistoryController extends Controller
{
    /**
     * List all medical history entries.
     * 
     * @param integer $patientId Patient unique id.
     * @param String $roleTheme Theme role switcher.
     */
    public function listAction($roleTheme, $patientId = null)
    {
        $em = $this->getDoctrine()->getEntityManager();

        if(is_null($patientId) && $roleTheme==='Patient')
        {
            $user = $this->get('security.context')->getToken()->getUser();
            $patient = $user->getPatient();
        }
        else
        {
            $patient = $em->getRepository('McmsPatientBundle:Patient')->find($patientId);
            if(!$patient) {
                throw $tnis->createNotFoundException('Unable to find patient.');
            }
        }

        $entries = $em->getRepository('McmsMedicalHistoryBundle:Entry')->findByPatient($patient);

        return $this->render('McmsMedicalHistoryBundle:'.$roleTheme.':list.html.twig', array(
            'entries' => $entries
        ));
    }

    /**
     * Finds and display sindle entry details.
     * 
     * @param integer $patientId Patient unique id.
     * @param integer $entryId Entry unique id.
     * @param String $roleTheme Theme role switcher.
     */
    public function showAction($roleTheme, $patientId = null, $entryId)
    {
        $em = $this->getDoctrine()->getEntityManager();

        if(is_null($patientId) && $roleTheme==='Patient')
        {
            $user = $this->get('security.context')->getToken()->getUser();
            $patient = $user->getPatient();
        }
        else
        {
            $patient = $em->getRepository('McmsPatientBundle:Patient')->find($patientId);
            if(!$patient) {
                throw $tnis->createNotFoundException('Unable to find patient.');
            }
        }

        $entry = $em->getRepository('McmsMedicalHistoryBundle:Entry')->findByPatientAndId($patient, $entryId);

        return $this->render('McmsMedicalHistoryBundle:'.$roleTheme.':show.html.twig', array(
            'entry' => $entry
        ));
    }
}