<?php

namespace Mcms\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * List all users
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
     * Display user profile
     */
    public function profileAction()
    {
        return $this->render('McmsUserBundle:'.$roleTheme.':profile.html.twig');
    }
}