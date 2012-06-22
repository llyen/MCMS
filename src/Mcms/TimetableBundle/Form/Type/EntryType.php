<?php

namespace Mcms\TimetableBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EntryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('comment', 'textarea')
        ;
    }

    public function getName()
    {
        return 'mcms_timetablebundle_entrytype';
    }
}
