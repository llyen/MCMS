<?php

namespace Mcms\MedicalHistoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mcms\MedicalHistoryBundle\Entity\Entry
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mcms\MedicalHistoryBundle\Entity\EntryRepository")
 */
class Entry
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}