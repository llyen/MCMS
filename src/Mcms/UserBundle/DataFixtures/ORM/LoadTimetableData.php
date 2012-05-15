<?php

namespace Mcms\UserBundle\DataFixtures\Orm;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Mcms\TimetableBundle\Entity\Entry;

class LoadTimetableData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager  $manager)
    {
        $start = '2012-04-01 00:00:00';
        $end   = '2012-06-30 00:00:00';

        $start = strtotime($start);
        $end   = strtotime($end);

        for ($i=0; $i < 30; $i++) {         
                $entry1 = new Entry();

                $entry1->setPatient($this->getReference('patient'.mt_rand(1, 3))->getPatient());
                $entry1->setEmployee($this->getReference('employee'.mt_rand(1, 2))->getEmployee());
                $t = date('Y-m-d H:i:s', mt_rand($start, $end));
                $entry1->setDate(new \DateTime($t));
                $entry1->setComment('blabla');
                
                


                $manager->persist($entry1);
                $manager->flush();
        }
    }



    public function getOrder()
    {
        return 6;
    }
}