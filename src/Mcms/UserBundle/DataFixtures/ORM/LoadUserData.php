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

        $patient = new User();

        $patient->setFirstName('Tadeusz');
        $patient->setLastName('Morzy');
        $patient->setUsername('patient');
        $patient->setPassword('patient');
        $patient->getUserRoles()->add($this->getReference('patient-role'));

    	$manager->persist($admin);
        $manager->persist($patient);
    	$manager->flush();

        $this->addReference('patient', $patient);
    }

    public function getOrder()
    {
    	return 3;
    }
}