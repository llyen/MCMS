<?php

namespace Mcms\UserBundle\Listener;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityListener
{
	/**
	 * @var Router $router
	 */
	private $router;

	/**
	 * @var SecurityContext $security
	 */
	private $security;

	/**
	 * Redirect route name
	 * 
	 * @var String $redirect
	 */
	private $redirect;

	public function __construct(Router $router, SecurityContext $security)
	{
		$this->router = $router;
		$this->security = $security;
	}

	/**
	 * Invoked after login success
	 * 
	 * @param InteractiveLoginEvent $enent The event.
	 */
	public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
	{
		$request = $event->getRequest();
		$session = $request->getSession();

		$target_path = $session->get('_security.target_path');

		if($target_path=='')
		{
			if($this->security->isGranted('ROLE_ADMIN'))
			{
				$session->set('roleTheme', 'Admin');
				$this->redirect = "admin_dashboard";
			}

			if($this->security->isGranted('ROLE_PATIENT'))
			{
				$session->set('roleTheme', 'Patient');
				$this->redirect = "patient_dashboard";
			}
		}
	}

	/**
	 * Invoked after login success response has been created
	 * 
	 * @param FilterResponseEvent $event The event.
	 */
	public function onKernelResponse(FilterResponseEvent $event)
	{
		if(!is_null($this->redirect))
		{
			$event->setResponse(new RedirectResponse($this->router->generate($this->redirect)));
		}
	}
}