<?php

namespace Mcms\MedicalHistoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mcms\MedicalHistoryBundle\Entity\Entry;
use Mcms\MedicalHistoryBundle\Form\Type\EntryType;

use Mcms\PaymentBundle\Entity\Payment;
use Mcms\PaymentBundle\Form\Type\PaymentType;

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
        $payment = new Payment();


        $patient = $em->getRepository('McmsPatientBundle:Patient')->find($patientId);
        if(!$patient) {
            throw $this->createNotFoundException('Unable to find patient.');
        }
        
        $payment->setPatient($patient);

        $paymentForm = $this->createForm(new PaymentType(), $payment);
        $entryForm = $this->createForm(new EntryType(), $entry);
        return $this->render('McmsMedicalHistoryBundle:Employee:new.html.twig', array(
            'entryForm' => $entryForm->createView(),
            'paymentForm' => $paymentForm->createView(),
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

        $payment = new Payment();
        $payment->setPatient($patient);

        $request = $this->getRequest();
        
        $entryForm = $this->createForm(new EntryType(), $entry);
        $paymentForm = $this->createForm(new PaymentType(), $payment);
        
        $entryForm->bindRequest($request);
        $paymentForm->bindRequest($request);

        if($entryForm->isValid() && $paymentForm->isValid())
        {
            $em->persist($entry);
            $em->flush();

            $payment->setEntry($entry);

            if(sizeof($paymentForm->getData()->getProducts()->toArray())!=0)
                return $this->forward('McmsPaymentBundle:Payment:create',array('payment'=>$payment, 'patient'=>$patient));
            else
                return $this->redirect($this->generateUrl('employee.medicalHistory', array('patientId' => $patientId)));
        }

        return $this->render('McmsMedicalHistoryBundle:Employee:new.html.twig', array(
            'entryForm' => $entryForm->createView(),
            'paymentForm' => $paymentForm->createView(),
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

        $payment = $entry->getPayment();

        $entryForm = $this->createForm(new EntryType(), $entry);
        $paymentForm = $this->createForm(new PaymentType(), $payment);

        return $this->render('McmsMedicalHistoryBundle:Employee:edit.html.twig', array(
            'entryForm' => $entryForm->createView(),
            'paymentForm' => $paymentForm->createView(),
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

        $payment = $entry->getPayment();
        if(!$payment) {
            $payment = new Payment();
            $payment->setEntry($entry);
            $payment->setPatient($patient);

            $em->persist($payment);
            $em->flush();
        } else {
            $payment->setPatient($patient);
        }


        $entryForm = $this->createForm(new EntryType(), $entry);
        $paymentForm = $this->createForm(new PaymentType(), new Payment());
        
        $request = $this->getRequest();

        $entryForm->bindRequest($request);
        $paymentForm->bindRequest($request);

        if($entryForm->isValid() && $paymentForm->isValid())
        {
            $em->persist($entry);
            $em->flush();
            
            return $this->forward('McmsPaymentBundle:Payment:update',array('paymentId'=>$payment->getId(), 'patientId'=>$patient->getId()));
                //return $this->redirect($this->generateUrl('employee.medicalHistory', array('patientId' => $patientId)));
        }

        return $this->render('McmsMedicalHistoryBundle:Employee:edit.html.twig', array(
            'entryForm' => $entryForm->createView(),
            'paymentForm' => $paymentForm->createView(),
            'patient' => $patient,
            'entry' => $entry
        ));
    }
}