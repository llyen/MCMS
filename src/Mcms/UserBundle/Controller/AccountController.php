<?php

namespace Mcms\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Mcms\UserBundle\Form\Type\ChangePasswordFormType;
use Mcms\UserBundle\Form\Model\ChangePassword;

class AccountController extends Controller
{

	/**
	 * Displays a form to change password.
	 * 
	 * @Template("McmsUserBundle:Account:changePasswordForm.html.twig")
	 */
	public function changePasswordAction()
	{
		/**
		 * 1) Generate change password form
		 * 2) Generate view
		 */
		$form = $this->createForm(new ChangePasswordFormType(), new ChangePassword());

		return array('form'=>$form->createView());
	}

	/**
	 * Edit current user password.
	 */
	public function changePasswordProcessAction()
	{
		$form = $this->createForm(new ChangePasswordFormType(), new ChangePassword());
		$form->bindRequest($this->getRequest());

		$formData = $form->getData();

		if($form->isValid())
		{
			/**
			 * @var User $user Current logged user
			 */
			$user = $this->get('security.context')->getToken()->getUser();

			$factory = $this->container->get('security.encoder_factory');
			$encoder = $factory->getEncoder($user);

			$newPassword = $encoder->encodePassword($formData->getNewPassword(), $user->getSalt());

			$user->setPassword($newPassword);

			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($user);
			$em->flush();

			echo "SUCCESS";
		}

		return $this->render('McmsUserBundle::changePassword.html.twig', array(
            'form' => $form->createView()
        ));
	
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