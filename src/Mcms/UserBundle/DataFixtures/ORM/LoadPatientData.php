<?php

namespace Mcms\UserBundle\DataFixtures\Orm;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Mcms\PatientBundle\Entity\Patient;

class LoadPatientData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager  $manager)
    {
        $patient = new Patient();

        $patient->setUser($this->getReference('patient'));
        $patient->setPesel('12345678910');
        $patient->setAddress1('ul.Cwiartki 3');
        $patient->setAddress2('4');
        $patient->setPostalCode('12-345');
        $patient->setCity('Zadupie Wielkie');

        $manager->persist($patient);
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}