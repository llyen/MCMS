<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\DoctrineBundle\DoctrineBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new Mcms\UserBundle\McmsUserBundle(),
            new Mcms\PatientBundle\McmsPatientBundle(),
            new Mcms\EmployeeBundle\McmsEmployeeBundle(),
            new Mcms\ProductBundle\McmsProductBundle(),
            new Mcms\TimetableBundle\McmsTimetableBundle(),
            new Mcms\MedicalHistoryBundle\McmsMedicalHistoryBundle(),
            new Mcms\PaymentBundle\McmsPaymentBundle(),
            new Symfony\Bundle\DoctrineFixturesBundle\DoctrineFixturesBundle(),
<<<<<<< HEAD
<<<<<<< HEAD
            new Mcms\DashboardBundle\McmsDashboardBundle(),
=======
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
            new Mcms\DashboardBundle\McmsDashboardBundle(),
>>>>>>> upstream/master
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
