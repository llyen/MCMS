<?php

namespace Mcms\PatientBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('pesel','text');
        $builder->add('address1','text');
        $builder->add('address2','text');
        $builder->add('postalcode','text');
        $builder->add('city','text');
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Mcms\PatientBundle\Entity\Patient',
        );
    }

    public function getName()
    {
        return 'patient';
    }
}