<?php

namespace Mcms\UserBundle\DataFixtures\Orm;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mcms\UserBundle\Entity\Sequence;

/**
 * Mcms\UserBundle\DataFixtures\Orm
 */
class LoadSequenceData extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		mt_srand((double)microtime()*1000000);
		$seqSeed = mt_rand(10000000, 20000000);

		$seq = new Sequence();
		$seq->setSeqValue($seqSeed);

		$manager->persist($seq);
		$manager->flush();

		$this->addReference('sequence',$seq);
	}

	public function getOrder()
	{
		return 1;
	}
}