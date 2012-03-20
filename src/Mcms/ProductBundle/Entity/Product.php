<?php

namespace Mcms\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mcms\ProductBundle\Entity\Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mcms\ProductBundle\Entity\ProductRepository")
 */
class Product
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