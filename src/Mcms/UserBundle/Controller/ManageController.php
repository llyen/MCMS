<?php

namespace Mcms\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

<<<<<<< HEAD
<<<<<<< HEAD
use Mcms\UserBundle\Form\Type\ChangePasswordFormType;
use Mcms\UserBundle\Form\Model\ChangePassword;
=======
use Mcms\UserBundle\Entity\User;
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
use Mcms\UserBundle\Form\Type\ChangePasswordFormType;
use Mcms\UserBundle\Form\Model\ChangePassword;
>>>>>>> upstream/master

class ManageController extends Controller
{

<<<<<<< HEAD
<<<<<<< HEAD
	/**
	 * @Template("McmsUserBundle:Manage:changePasswordForm.html.twig")
	 */
=======
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
	/**
	 * @Template("McmsUserBundle:Manage:changePasswordForm.html.twig")
	 */
>>>>>>> upstream/master
	public function changePasswordAction()
	{
		/**
		 * 1) Generate change password form
		 * 2) Generate view
		 */
<<<<<<< HEAD
<<<<<<< HEAD
		$form = $this->createForm(new ChangePasswordFormType(), new ChangePassword());

		return array('form'=>$form->createView());
=======
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
		$form = $this->createForm(new ChangePasswordFormType(), new ChangePassword());

		return array('form'=>$form->createView());
>>>>>>> upstream/master
	}

	public function changePasswordProcessAction()
	{
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> upstream/master
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

		return $this->render('McmsUserBundle:Manage:changePasswordForm.html.twig', array(
            'form' => $form->createView()
        ));
	
<<<<<<< HEAD
=======
		/**
		 * 1) Check whether form is valid or not
		 * 2) Get current user object
		 * 3) Get encoded user password - store it in variable (eg. oldPasswd)
		 * 4) Compare oldPasswd with old password passed by user (first passwd provided by user have to be encoded)
		 * 5) Store new password in DB
		 * 6) Show success page/message
		 */
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
>>>>>>> upstream/master
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