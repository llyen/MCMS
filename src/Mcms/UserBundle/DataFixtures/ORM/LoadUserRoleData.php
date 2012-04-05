<?php

namespace Mcms\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mcms\UserBundle\Entity\UserRole;

/**
 * Mcms\UserBundle\DataFixtures\ORM
 */
class LoadUserRoleData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$userRoleAdmin = new UserRole();
		$userRoleAdmin->setUserId($manager->merge($this->getReference('admin-user')));
		$userRoleAdmin->setRoleId($manager->merge($this->getReference('admin-role')));

		$manager->persist($userRoleAdmin);
        $manager->flush();
	}

	public function getOrder()
	{
		return 3;
	}
}