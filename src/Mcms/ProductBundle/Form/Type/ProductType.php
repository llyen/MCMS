<?php

namespace Mcms\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProductType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('name', 'text');
		$builder->add('price', 'number');
	}

	public function getName()
	{
		return 'product';
	}
}