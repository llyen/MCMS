<?php

namespace Mcms\EmployeeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EmployeeType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('position', 'text');
	}

	public function getDefaultOptions(array $options)
	{
		return array(
			'data_class' => 'Mcms\EmployeeBundle\Entity\Employee',
		);
	}

	public function getName()
	{
		return 'employee';
	}
}