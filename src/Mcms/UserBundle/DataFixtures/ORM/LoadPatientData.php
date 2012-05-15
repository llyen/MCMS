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
        $patient1 = new Patient();

        $patient1->setUser($this->getReference('patient1'));
        $patient1->setPesel('12345678910');
        $patient1->setAddress1('ul.Cwiartki 3');
        $patient1->setAddress2('4');
        $patient1->setPostalCode('12-345');
        $patient1->setCity('Zadupie Wielkie');

        $patient2 = new Patient();
        $patient2->setPesel('12345678910');
        $patient2->setAddress1('ul.Cwiartki 3');
        $patient2->setAddress2('4');
        $patient2->setPostalCode('12-345');
        $patient2->setCity('Zadupie Wielkie');
        $patient2->setUser($this->getReference('patient2'));

        $patient3 = new Patient();
        $patient3->setPesel('12345678910');
        $patient3->setAddress1('ul.Cwiartki 3');
        $patient3->setAddress2('4');
        $patient3->setPostalCode('12-345');
        $patient3->setCity('Zadupie Wielkie');
        $patient3->setUser($this->getReference('patient3'));

        $manager->persist($patient1);
        $manager->persist($patient2);
        $manager->persist($patient3);
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}