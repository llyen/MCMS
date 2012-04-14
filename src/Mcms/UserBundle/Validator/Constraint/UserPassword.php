<?php

namespace Mcms\UserBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserPassword extends Constraint
{
	/**
	 * @var String $message Basic error message.
	 */
	public $message = 'This value should be the user current password.';


	/**
	 * Returns the name of class that validate UserPassword constraint
	 * 
	 * @return String The class name.
	 */
	public function validatedBy()
	{
		return 'user_password_validator';
	}
}