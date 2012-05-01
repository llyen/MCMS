<?php

namespace Mcms\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Manage users controller.
 * 
 * @Route("/users")
 */
class ManageController extends Controller
{
	/**
	 * List all users in application.
	 * 
	 * @Route("/", name="users")
	 * @Template("McmsProductBundle:Manage:listAllUsers.html.twig")
	 */
	public function userIndexAction()
	{
		$em = $this->getDoctrine()->getEntityManager();

		$users = $em->getRepository('McmsUserBundle:User')->findAll();

		return array('users' => $users);
	}
}