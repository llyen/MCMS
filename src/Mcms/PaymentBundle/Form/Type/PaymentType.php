<?php

namespace Mcms\PaymentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('products', 'collection', array(
                'type' => new PaymentProductType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
        ;
    }

    public function getName()
    {
        return 'payment';
    }

    public function getDefaultOptions(array $options)
    {
        return array( 'data_class' => 'Mcms\PaymentBundle\Entity\Payment');
    }
}
