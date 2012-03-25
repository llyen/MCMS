<?php

namespace Mcms\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mcms\UserBundle\Entity\Sequence
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mcms\UserBundle\Entity\SequenceRepository")
 */
class Sequence
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
     * @var bigint $seqValue
     *
     * @ORM\Column(name="seqValue", type="bigint")
     */
    private $seqValue;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set seqValue
     *
     * @param bigint $seqValue
     */
    public function setSeqValue($seqValue)
    {
        $this->seqValue = $seqValue;
    }

    /**
     * Get seqValue
     *
     * @return bigint 
     */
    public function getSeqValue()
    {
        return $this->seqValue;
    }

    /**
     * Get next value
     * 
     * @return bigint
     */
    public function nextVal()
    {
        mt_srand((double)microtime()*1000000);
       
        $current = $this->getSeqValue();
        $current+=mt_rand(25, 100);
        $this->setSeqValue($current);

        return $current;
    }
}