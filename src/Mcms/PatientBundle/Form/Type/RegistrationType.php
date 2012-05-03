<?php

namespace Mcms\PatientBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

use Mcms\UserBundle\Form\Type\UserType;
use Mcms\PatientBundle\Form\Type\PatientType;

class RegistrationType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('user', new UserType());
		$builder->add('patient', new PatientType());
	}

	public function getName()
	{
		return 'user_patient';
	}
}