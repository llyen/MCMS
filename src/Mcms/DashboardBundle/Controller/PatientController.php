<?php

namespace Mcms\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PatientController extends Controller
{
    /**
     * Base patient dashboard view
     * 
     * @Template("McmsDashboardBundle::patientIndex.html.twig")
     */
    public function indexAction()
    {
        return array();
    }
}