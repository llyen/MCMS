<?php

namespace Mcms\PatientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mcms\PatientBundle\Form\Type\PatientType;
use Mcms\PatientBundle\Entity\Patient;

class ManageController extends Controller
{
    /**
     * List all patients
     */
    public function patientListAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $patients = $em->getRepository('McmsPatientBundle:Patient')->findAll();

        return array(
            'patients' => $patients
        );
    }

    /**
     * Finds and display single Patient
     * 
     * @param integer $id Patientid.
     */
    public function patientShowAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $patient = $em->getRepository('McmsPatientBundle:Patient')->find($id);

        if(!$patient)
        {
            throw $this->createNotFoundException('Unable to find patient.');
        }

        $deleteForm = $this->createSipleForm($id);

        return array(
            'patient' => $patient,
            'delete_form' => $deleteForm->createView()
        );
    }

    /**
     * Display a form to edit single Patient
     */
    public function patientEditAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $patient = $em->getRepository('McmsPatientBundle:Patient')->find($id);

        if(!$patient)
        {
            throw $this->createNotFoundException('Unable to find patient.');
        }

        $form = $this->createForm(new PatientType(), $patient);
        $deleteForm = $this->createSipleForm($id);

        return array(
            'patient' => $patient,
            'form' => $form->createView(),
            'delete_form' => $delete_form->createView()
        );
    }

    /**
     * Edits patient details
     */
    public function patientUpdate($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $patient = $em->getRepository('McmsPatientBundle:Patient')->find($id);

        if(!$patient)
        {
            throw $this->createNotFoundException('Unable to find patient.');
        }

        $request = $this->getRequest();
        $form = $this->createForm(new PatientType(), $patient);
        $form->bindRequest($request);

        if($form->isValid())
        {
            $em->persist($patient);
            $em->flush();

            //add redirect to show patient details page
        }

        $deleteForm = $this->createSipleForm($id);

        return array(
            'patient' => $patient,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView()
        );
    }

    /**
     * Creates and returns simple submit form object
     * 
     * @param integer $id 
     * @return Form The form object.
     */
    private function createSipleForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id','hidden')
            ->getForm()
        ;
    }
}