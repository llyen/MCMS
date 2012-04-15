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
<<<<<<< HEAD
<<<<<<< HEAD
		$adminRole->setName("ROLE_ADMIN");
			$manager->persist($adminRole);

		$patientRole = new Role();
		$patientRole->setName("ROLE_PATIENT");
=======
		$adminRole->setName("Administrator");
			$manager->persist($adminRole);

		$patientRole = new Role();
		$patientRole->setName("Patient");
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
=======
		$adminRole->setName("ROLE_ADMIN");
			$manager->persist($adminRole);

		$patientRole = new Role();
		$patientRole->setName("ROLE_PATIENT");
>>>>>>> upstream/master
			$manager->persist($patientRole);
			
		$manager->flush();

		$this->addReference('admin-role', $adminRole);
	}

	public function getOrder()
	{
		return 2;
	}
}

