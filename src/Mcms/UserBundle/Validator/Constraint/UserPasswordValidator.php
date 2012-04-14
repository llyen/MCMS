<?php

namespace Mcms\UserBundle\Validator\Constraint;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;


class UserPasswordValidator extends ConstraintValidator
{
	private $encoderFactory;
	private $securityContext;

	public function __construct(SecurityContextInterface $securityContext, EncoderFactoryInterface $encoderFactory)
	{
		$this->securityContext = $securityContext;
		$this->encoderFactory = $encoderFactory;
	}

	public function isValid($password, Constraint $constraint)
	{
		$user = $this->securityContext->getToken()->getUser();

		if(!$user instanceof UserInterface)
		{
			throw new ConstraintDefinitionException('The user must extend UserInterface.');
		}

		$encoder = $this->encoderFactory->getEncoder($user);

		if (!$encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
            $this->setMessage($constraint->message);
            
            return false;
        }
        
        return true;
	}
}