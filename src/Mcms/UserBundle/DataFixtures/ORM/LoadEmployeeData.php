<?php

namespace Mcms\UserBundle\DataFixtures\Orm;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Mcms\EmployeeBundle\Entity\Employee;

class LoadEmployeeData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager  $manager)
    {
        $employee1 = new Employee();
        $employee1->setUser($this->getReference('employee1'));
        $employee1->setPosition('Lekarz Internista');

        $employee2 = new Employee();
        $employee2->setUser($this->getReference('employee2'));
        $employee2->setPosition('Urolog od mózgu');

        $manager->persist($employee1);
        $manager->persist($employee2);
        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}