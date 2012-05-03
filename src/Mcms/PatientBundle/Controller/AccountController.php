<?php

namespace Mcms\PatientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mcms\PatientBundle\Form\Type\RegistrationType;
use Mcms\PatientBundle\Form\Model\Registration;

class AccountController extends Controller
{
    /**
     * Display form to change User and Patient details.
     * 
     * @Template("McmsPatientBundle:Account:editDetailsForm.html.twig")
     */
    public function editAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $patient = $user->getPatient();

        $registartionModel = new Registration();

        $registartionModel->setUser($user);
        $registartionModel->setPatient($patient);

        $form = $this->createForm(new RegistrationType(), $registartionModel);

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * Edits User and Patient details.
     * 
     * @Template("McmsPatientBundle:Account:editDetailsForm.html.twig")
     */
    public function updateAction()
    {

        $user = $this->container->get('security.context')->getToken()->getUser();
        $patient = $user->getPatient();

        $registartionModel = new Registration();
        $registartionModel->setUser($user);
        $registartionModel->setPatient($patient);

        $request = $this->getRequest();

        $form = $this->createForm(new RegistrationType(), $registartionModel);
        $form->bindRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($user);
            $em->persist($patient);
            $em->flush();

            //return $this->redirect($this->generateUrl('patient_edit'));
        }

        return array(
            'form' => $form->createView()
        );
    }
}