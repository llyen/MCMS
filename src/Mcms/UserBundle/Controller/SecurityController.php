<?php

namespace Mcms\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller
{
	public function loginAction()
	{
		/**
		 * 1) Generate login form
		 * 2) Generate and show view
		 */
	}

	public function loginProcessAction()
	{
		/**
		 * 1) Validate form
		 * 2) Login user to system
		 * 3) Set credentials
		 * 4) Execute loginAfterProcessAction()
		 */
	}

	public function loginAfterProcessAction()
	{
		/**
		 * 1) Check credentials
		 * 2) Redirect based on credentials
		 */
	}
}