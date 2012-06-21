<?php

namespace Mcms\PaymentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PaymentProductType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('count')
            ->add('product','entity', array(
                'class' => 'McmsProductBundle:Product'
            ))
        ;
    }

    public function getName()
    {
        return 'payment_product';
    }

    public function getDefaultOptions(array $options)
    {
        return array( 'data_class' => 'Mcms\PaymentBundle\Entity\PaymentProduct');
    }
}
