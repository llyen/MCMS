<?php

namespace Mcms\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('firstName','text')
        	->add('lastName','text');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Mcms\UserBundle\Entity\User',
        );
    }

    public function getName()
    {
        return 'user';
    }
}