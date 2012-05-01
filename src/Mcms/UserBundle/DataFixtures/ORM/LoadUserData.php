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
    	$adminUser = new User();
        
    	$adminUser->setFirstName("Jan");
    	$adminUser->setLastName("Kowalski");
        $adminUser->getUserRoles()->add($this->getReference('admin-role'));

    	$manager->persist($adminUser);
    	$manager->flush($adminUser);
    }

    public function getOrder()
    {
    	return 3;
    }
}