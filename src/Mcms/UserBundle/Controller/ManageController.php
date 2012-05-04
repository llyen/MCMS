<?php

namespace Mcms\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Manage users controller.
 * 
 */
class ManageController extends Controller
{
	/**
	 * List all users in application.
	 * 
	 * @Template("McmsUserBundle::list.html.twig")
	 */
	public function usersListAction()
	{
		$em = $this->getDoctrine()->getEntityManager();

		$users = $em->getRepository('McmsUserBundle:User')->findAll();

		return array('users' => $users);
	}

	/**
	 * Finds and display single User
	 * 
	 * @param integer $id User id.
	 * 
	 * @Template("McmsUserBundle::show.html.twig")
	 */
	public function userShowAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$user = $em->getRepository('McmsUserBundle:User')->find($id);

		if(!$user)
		{
			throw $tnis->createNotFoundException('Unable to find User.');
		}

		$passwordResetForm = $this->createSimpleForm($id);

		return array(
			'user' => $user,
			'password_reset_form' => $passwordResetForm->createView()
		);
	}

	/**
	 * Generates new random user password
	 * 
	 * @param integer $id User id.
	 */
	public function userPasswordResetAction($id)
	{
		$request = $this->getRequest();
		$form = $this->createSimpleForm($id);
		$form->bindRequest($request);

		if($form->isValid())
		{
			$em = $this->getDoctrine()->getEntityManager();

			$user = $em->getRepository('McmsUserBundle:User')->find($id);

			if(!$user)
			{
				throw $this->createNotFoundException('Unable to find User.');
			}

			$factory = $this->container->get('security.encoder_factory');
			$encoder = $factory->getEncoder($user);

			$newPassword = $encoder->encodePassword('TEST', $user->getSalt());

			$user->setPassword($newPassword);
			
			$em->persist($user);
			$em->flush();
		}

		$this->get('session')->setFlash('notice', 'New pasword : TEST');

		return $this->redirect($this->generateUrl('users_list'));
	}

	/**
	 * Creates and returns simple form object
	 * 
	 * @param integer $id User id.
	 * @return Form The delete formobject.
	 */
	private function createSimpleForm($id)
	{
		return $this->createFormBuilder(array('id' => $id))
			->add('id', 'hidden')
			->getForm();
	}
}