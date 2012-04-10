<?php

namespace Mcms\UserBundle\DataFixtures\Orm;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mcms\UserBundle\Entity\Role;

/**
 * Mcms\UserBundle\DataFixtures\Orm
 */
class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$adminRole = new Role();
		$adminRole->setName("ROLE_ADMIN");
			$manager->persist($adminRole);

		$patientRole = new Role();
		$patientRole->setName("ROLE_PATIENT");
			$manager->persist($patientRole);
			
		$manager->flush();

		$this->addReference('admin-role', $adminRole);
	}

	public function getOrder()
	{
		return 2;
	}
}

