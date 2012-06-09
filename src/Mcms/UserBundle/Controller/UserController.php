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

        $users = $em->getRepostory('McmsUserBundle:User')->findAll();

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

        return $this->render('McmsUserBundle:'.$roleTheme.':show.html.twig',array(
            'user' => $user
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
}