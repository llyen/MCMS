<?php

namespace Mcms\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Mcms\UsersBundle\Form\Type\UserType;
use Mcms\UsersBundle\Entity\User;

class SecurityController extends Controller
{
    /**
     * Perform login action
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('McmsUsersBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    /**
     * Display register form
     */
    public function registerAction()
    {
        $form = $this->createForm(new UserType(), new User());
        return $this->render('McmsUsersBundle:Security:register.html.twig', array('form' => $form->createView()));
    }

    /**
     * Process register form
     */
    public function registerProcessAction()
    {
        $form = $this->createForm(new UserType(), new User());
        $form->bindRequest($this->getRequest());

        if($form->isvalid())
        {
            $factory = $this->get('security.encoder_factory');
            $user = new User();
            $encoder = $factory->getEncoder($user);

            $user = $form->getData();
            $user->setSalt();

            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('login'));
        }
        else
        {
            return $this->redirect($this->generateUrl('register'));
        }
    }
}