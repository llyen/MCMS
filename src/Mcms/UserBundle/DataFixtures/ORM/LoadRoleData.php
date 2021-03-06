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

		$employeeRole = new Role();
		$employeeRole->setName("ROLE_EMPLOYEE");
			$manager->persist($employeeRole);
			
		$manager->flush();

		$this->addReference('admin-role', $adminRole);
		$this->addReference('patient-role', $patientRole);
		$this->addReference('employee-role', $employeeRole);
	}

	public function getOrder()
	{
		return 2;
	}
}

