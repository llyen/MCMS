<?php

namespace Mcms\UserBundle\DataFixtures\Orm;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Mcms\UserBundle\Entity\User;

/**
* Mcms\UserBundle\DataFixtures\Orm
*/
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface,ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
    	$admin = new User();
        
    	$admin->setFirstName("Jan");
    	$admin->setLastName("Kowalski");
        $admin->setUsername('admin');
        $admin->setPassword('admin');
        $admin->getUserRoles()->add($this->getReference('admin-role'));

        $patient1 = new User();

        $patient1->setFirstName('Tadeusz');
        $patient1->setLastName('Morzy');
        $patient1->setUsername('patient');
        $patient1->setPassword('patient');
        $patient1->getUserRoles()->add($this->getReference('patient-role'));
        $this->addReference('patient1', $patient1);

        $patient2 = new User();
        $patient2->setFirstName('Zdzislaw');
        $patient2->setLastName('Motyka');
        $patient2->getUserRoles()->add($this->getReference('patient-role'));
        $this->addReference('patient2', $patient2);

        $patient3 = new User();
        $patient3->setFirstName('Joanna');
        $patient3->setLastName('Nowak');
        $patient3->getUserRoles()->add($this->getReference('patient-role'));
        $this->addReference('patient3', $patient3);

        $employee1 = new User();
        $employee1->setFirstName('Mirosław');
        $employee1->setLastName('Klozet');
        $employee1->getUserRoles()->add($this->getReference('employee-role'));
        $this->addReference('employee1', $employee1);

        $employee2 = new User();
        $employee2->setFirstName('Katarzyna');
        $employee2->setLastName('Nijak');
        $employee2->getUserRoles()->add($this->getReference('employee-role'));
        $this->addReference('employee2', $employee2);

    	$manager->persist($admin);
        $manager->persist($patient1);
        $manager->persist($patient2);
        $manager->persist($patient3);
        $manager->persist($employee1);
        $manager->persist($employee2);
    	$manager->flush();
    }

    public function getOrder()
    {
    	return 3;
    }
}