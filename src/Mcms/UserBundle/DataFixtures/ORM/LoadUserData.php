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
        //Get sequence intial value
        $sequence = $this->getReference('sequence')->getSeqValue();

    	$adminUser = new User();
        $adminUser->setUsername($sequence);
        $adminUser->setSalt();

        $encoder = $this->container->get('security.encoder_factory')->getEncoder($adminUser);
        $adminUser->setPassword($encoder->encodePassword($sequence, $adminUser->getSalt())); 
        
    	$adminUser->setFirstName("Jan");
    	$adminUser->setLastName("Kowalski");

    	$manager->persist($adminUser);
    	$manager->flush($adminUser);

    	$this->addReference('admin-user', $adminUser);
    }

    public function getOrder()
    {
    	return 2;
    }
}