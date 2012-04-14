<?php

namespace Mcms\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ChangePasswordFormType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('oldPassword','password')
			->add('newPassword','repeated',array('type'=>'password'));
	}

	public function getName()
	{
		return 'user_change_password';
	}
}