<?php

namespace Mcms\MedicalHistoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mcms\MedicalHistoryBundle\Entity\Entry;
use Mcms\MedicalHistoryBundle\Form\Type\EntryType;

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
            'entries' => $entries,
            'patient' => $patient
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
                throw $this->createNotFoundException('Unable to find patient.');
            }
        }

        $entry = $em->getRepository('McmsMedicalHistoryBundle:Entry')->findByPatientAndId($patient, $entryId);
        if(!$entry) {
            throw $this->createNotFoundException('Unable to find entry.');
        }

        return $this->render('McmsMedicalHistoryBundle:'.$roleTheme.':show.html.twig', array(
            'entry' => $entry
        ));
    }

    /**
     * Displays a form to create new entry
     * 
     * @param integer $patientId
     */
    public function newAction($patientId)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entry = new Entry();

        $patient = $em->getRepository('McmsPatientBundle:Patient')->find($patientId);
        if(!$patient) {
            throw $this->createNotFoundException('Unable to find patient.');
        }
        
        $form = $this->createForm(new EntryType(), $entry);
        return $this->render('McmsMedicalHistoryBundle:Employee:new.html.twig', array(
            'form' => $form->createView(),
            'patient' => $patient
        ));
    }

    /**
     * Creates new entry
     * 
     * @param integer $patientId
     */
    public function createAction($patientId)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $patient = $em->getRepository('McmsPatientBundle:Patient')->find($patientId);
        if(!$patient) {
            throw $this->createNotFoundException('Unable to find patient.');
        }

        $user = $this->get('security.context')->getToken()->getUser();
        $employee = $user->getEmployee();

        $entry = new Entry();
        $entry->setDoctor($employee);
        $entry->setPatient($patient);

        $request = $this->getRequest();
        
        $form = $this->createForm(new EntryType(), $entry);
        $form->bindRequest($request);

        if($form->isValid())
        {
            $em->persist($entry);
            $em->flush();

            return $this->redirect($this->generateUrl('employee.medicalHistory', array('patientId' => $patientId)));
        }

        return $this->render('McmsMedicalHistoryBundle:Employee:new.html.twig', array(
            'form' => $form->createView(),
            'patient' => $patient
        ));
    }

    /**
     * Displays a form to edit entry
     * 
     * @param integer $patientId
     * 
     */
    public function editAction($patientId, $entryId)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $patient = $em->getRepository('McmsPatientBundle:Patient')->find($patientId);
        if(!$patient) {
            throw $this->createNotFoundException('Unable to find patient.');
        }

        $entry = $em->getRepository('McmsMedicalHistoryBundle:Entry')->findByPatientAndId($patient, $entryId);
        if(!$entry) {
            throw $this->createNotFoundException('Unable to find entry.');
        }

        $form = $this->createForm(new EntryType(), $entry);

        return $this->render('McmsMedicalHistoryBundle:Employee:edit.html.twig', array(
            'form' => $form->createView(),
            'patient' => $patient,
            'entry' => $entry
        ));
    }

    /**
     * Updates entry details
     * 
     * @param integer $patientId
     * @param integer $entryId
     */
    public function updateAction($patientId, $entryId)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $patient = $em->getRepository('McmsPatientBundle:Patient')->find($patientId);
        if(!$patient) {
            throw $this->createNotFoundException('Unable to find patient.');
        }

        $entry = $em->getRepository('McmsMedicalHistoryBundle:Entry')->findByPatientAndId($patient, $entryId);
        if(!$entry) {
            throw $this->createNotFoundException('Unable to find entry.');
        }

        $request = $this->getRequest();

        $form = $this->createForm(new EntryType(), $entry);
        $form->bindRequest($request);

        if($form->isValid())
        {
            $em->persist($entry);
            $em->flush();

            return $this->redirect($this->generateUrl('employee.medicalHistory', array('patientId' => $patientId)));
        }

        return $this->render('McmsMedicalHistoryBundle:Employee:edit.html.twig', array(
            'form' => $form->createView(),
            'patient' => $patient,
            'entry' => $entry
        ));
    }
}