<?php

namespace Mcms\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mcms\UserBundle\Entity\User;

class ManageController extends Controller
{

	public function changePasswordAction()
	{
		/**
		 * 1) Generate change password form
		 * 2) Generate view
		 */
	}

	public function changePasswordProcessAction()
	{
		/**
		 * 1) Check whether form is valid or not
		 * 2) Get current user object
		 * 3) Get encoded user password - store it in variable (eg. oldPasswd)
		 * 4) Compare oldPasswd with old password passed by user (first passwd provided by user have to be encoded)
		 * 5) Store new password in DB
		 * 6) Show success page/message
		 */
	}

	public function resetPasswordAction()
	{
		/**
		 * 1) Show confirmation page
		 */
	}

	public function resetPasswordProcessAction()
	{
		/**
		 * 1) Validate ???
		 * 2) Create new password, store it in DB
		 * 3) Show printable page
		 */
	}

	public function editDetailsAction()
	{
		/**
		 * 1) Generate edit details form
		 * 2) Generate view
		 */
	}

	public function editDetailsProcessAction()
	{
		/**
		 * 1) Check whether form is valid
		 * 2) Get current user object
		 * 3) Change details and store the in DB
		 * 4) Show success page/message
		 */
	}
}