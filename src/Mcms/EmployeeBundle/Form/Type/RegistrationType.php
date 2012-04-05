<?php

namespace Mcms\EmployeeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Mcms\UserBundle\Form\Type\UserType;
use Mcms\EmployeeBundle\Form\Type\EmployeeType;

class RegistrationType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('user', new UserType());
		$builder->add('employee', new EmployeeType());
	}

	public function getName()
	{
		return 'registration';
	}
}