<?php

namespace Mcms\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mcms\UserBundle\Entity\User;
use Mcms\UserBundle\Form\Type\UserType;
use Mcms\UserBundle\Form\Type\ChangePasswordFormType;
use Mcms\UserBundle\Form\Model\ChangePassword;
use Mcms\PatientBundle\Form\Type\PatientType;
use Mcms\EmployeeBundle\Form\Type\EmployeeType;

class UserController extends Controller
{
    /**
     * List all users
     * 
     * @param String $roleTheme Role theme name.
     */
    public function listAction($roleTheme)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $usersList = $em->getRepository('McmsUserBundle:User')->findAll();

        $paginator = $this->get('knp_paginator');
        $request = $this->getRequest();

        $users = $paginator->paginate($usersList, $request->get('page'), 10);

        return $this->render('McmsUserBundle:'.$roleTheme.':list.html.twig',array(
            'users' => $users
        ));
    }

    /**
     * Finds and display single User
     * 
     * @param integer $id User id
     */
    public function showAction($id, $roleTheme)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $user = $em->getRepostory('McmsUserBundle:User')->find($id);

        if(!$user) {
            throw $this->createNotFoundException('Unable to find user.');
        }

        $passwordResetForm = $this->createSimpleForm($id);

        return $this->render('McmsUserBundle:'.$roleTheme.':show.html.twig',array(
            'user' => $user,
            'password_reset_form' => $passwordResetForm->createView()
        ));
    }

    /**
     * Display form to edit User account
     * 
     * @param integer $userId User unique id.
     */
    public function editAction($userId)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $user = $em->getRepository('McmsUserBundle:User')->find($userId);

        if(!$user) {
            throw $this->createNotFoundException('Unable to find user.');
        }

        $form = $this->createEditProfileForm($user);

        return $this->render('McmsUserBundle:Admin:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Updates User account details.
     * 
     * @param integer $userId User unique id.
     */
    public function updateAction($userId)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $user = $em->getRepository('McmsUserBundle:User')->find($userId);

        if(!$user) {
            throw $this->createNotFoundException('Unable to find user.');
        }

        $request = $this->getRequest();

        $form = $this->createEditProfileForm($user);
        $form->bindRequest($reqest);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $userId)));
        }

        return $this->render('McmsUserBundle:Admin:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Displays user profile
     * 
     * @param String $roleTheme Role theme name.
     */
    public function profileAction($roleTheme)
    {
        return $this->render('McmsUserBundle:'.$roleTheme.':profile.html.twig');
    }

    /**
     * Displays a form to edit own profile
     * 
     * @param String $roleTheme Role theme name. 
     */
    public function editProfileAction($roleTheme)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $form = $this->createEditProfileForm($user);

        return $this->render('McmsUserBundle:'.$roleTheme.':editProfile.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Updates own profile
     * 
     * @param String $roleTheme Role theme name. 
     */
    public function updateProfileAction($roleTheme)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $reqest = $this->getRequest();

        $form = $this->createEditProfileForm($user);
        $form->bindRequest($reqest);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl(strtolower($roleTheme).'.profile'));
        }

        return $this->render('McmsUserBundle:'.$roleTheme.':editProfile.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Displays form to change password
     * 
     * @param String $roleTheme Role theme name.
     */
    public function changePasswordAction($roleTheme)
    {
        $form = $this->createForm(new ChangePasswordFormType(), new ChangePassword());

        return $this->render('McmsUserBundle:'.$roleTheme.':changePassword.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Updates password
     * 
     * @param String $roleTheme Role theme name.
     */
    public function updatePasswordAction($roleTheme)
    {
        $request = $this->getRequest();

        $form = $this->createForm(new ChangePasswordFormType(), new ChangePassword());
        $form->bindRequest($request);

        if($form->isValid())
        {
            $user = $this->get('security.context')->getToken()->getUser();
            
            $factory = $this->container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);

            $newPassword = $encoder->encodePassword($form->getData()->getNewPassword(), $user->getSalt());

            $user->setPassword($newPassword);

            if($user->getIsActive()==false)
                $user->setIsActive(true);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl(strtolower($roleTheme).'.profile'));
        }

        return $this->render('McmsUserBundle:'.$roleTheme.':changePassword.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Generates new random user password
     * 
     * @param integer $id User id.
     */
    public function resetPasswordAction($userId)
    {
        $request = $this->getRequest();
        $form = $this->createSimpleForm($userId);
        $form->bindRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getEntityManager();

            $user = $em->getRepository('McmsUserBundle:User')->find($userId);

            if(!$user)
            {
                throw $this->createNotFoundException('Unable to find User.');
            }

            $factory = $this->container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);

            $newPassword = $encoder->encodePassword($user->getUsername(), $user->getSalt());

            $user->setPassword($newPassword);
                $user->setIsActive(false);
            
            $em->persist($user);
            $em->flush();

            $this->get('session')->setFlash('notice', 'Password reset SUCCESS');
            return $this->redirect($this->generateUrl('user_show', array('id' => $userId)));
            
        }     

        return $this->redirect($this->generateUrl('user_show', array('id' => $userId)));
    }

    /**
     * Creates and returns form to edit own profile
     * 
     * @param User $user Current logged it user object
     * @return Form Form to edit own profile.
     */
    private function createEditProfileForm(User $user)
    {
        $patient=$user->getPatient();
        $employee = $user->getEmployee();

        $form = $this->createFormBuilder(array('user' => $user, 'patient' => $patient, 'employee' => $employee))
            ->add('user', new UserType());
        
        if($patient)
            $form->add('patient', new PatientType());

        if($employee)
            $form->add('employee', new EmployeeType());

        return $form->getForm();
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