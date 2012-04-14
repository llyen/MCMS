<?php

namespace Mcms\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/dash/dashboard")
     * @Template("McmsDashboardBundle:Administrator:admin.html.twig")
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
