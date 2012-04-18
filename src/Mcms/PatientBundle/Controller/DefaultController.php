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
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
