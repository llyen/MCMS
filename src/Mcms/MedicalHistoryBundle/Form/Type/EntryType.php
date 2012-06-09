<?php

namespace Mcms\MedicalHistoryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EntryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('content')
        ;
    }

    public function getName()
    {
        return 'mcms_medicalhistorybundle_entrytype';
    }
}
