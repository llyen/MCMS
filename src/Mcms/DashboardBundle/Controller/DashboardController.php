<?php

namespace Mcms\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{

    /**
     * Main dashboard page
     * 
     * @param String $userTheme Theme role switcher.
     */
    public function indexAction($roleTheme)
    {
        return $this->render('McmsDashboardBundle:'.$roleTheme.':index.html.twig');
    }
}