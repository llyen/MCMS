<?php

namespace Mcms\PatientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mcms\PatientBundle\Form\Type\PatientType;
use Mcms\UserBundle\Form\Type\UserType;

use Mcms\PatientBundle\Entity\Patient;
use Mcms\UserBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/register")
     * @Template()
     */
    public function indexAction()
    {

        $patientForm = $this->createForm(new PatientType());
    	$userForm = $this->createForm(new UserType());
    	return array('form1'=>$patientForm->createView(),
            'form2'=>$userForm->createView());
    	
    }

    /**
     * @Route("/create",name="create")
     * @Template("McmsPatientBundle:Patient:index")
     */
    public function createAction()
    {
        $patientForm = $this->createForm(new PatientType());
        $userForm = $this->createForm(new UserType());
        
        $patientForm->bindRequest($this->getRequest());
        $userForm->bindRequest($this->getRequest());

        $sequence = $this->getDoctrine()->getRepository('McmsUserBundle:Sequence')->findAll();
        $sequence = $sequence[0];

        $user = new User();
        $user = $userForm->getData();
        $user->setUsername($sequence->nextVal());
        $user->setSalt();

        $encoder=$this->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($encoder->encodePassword($sequence->getSeqValue(), $user->getSalt()));

        $patient = new Patient();
        $patient = $patientForm->getData();
        $patient->setUserId($user);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->persist($patient);
        $em->flush();


        return true;
    }

}
