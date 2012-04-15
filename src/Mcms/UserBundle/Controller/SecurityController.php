<?php

namespace Mcms\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

<<<<<<< HEAD
<<<<<<< HEAD
use Symfony\Component\Security\Core\SecurityContext;

=======
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
use Symfony\Component\Security\Core\SecurityContext;

>>>>>>> upstream/master
class SecurityController extends Controller
{
	public function loginAction()
	{
		/**
		 * 1) Generate login form
		 * 2) Generate and show view
		 */
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> upstream/master
		$request = $this->getRequest();
		$session = $request->getSession();

		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('McmsUserBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
<<<<<<< HEAD
=======
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
>>>>>>> upstream/master
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