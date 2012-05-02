<?php

namespace Mcms\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mcms\ProductBundle\Entity\Product
 *
 * @ORM\Table(name="products")
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
     * @var String $name
     * 
     * @ORM\Column(name="name", type="string", length=40)
     */
    private $name;

    /**
     * @var float $price
     * 
     * @ORM\Column(name="price", type="decimal", scale=2)
     * @Assert\Type(type="float", message="Wartość {{ value }} powinna być typu {{ type }}.")
     * @Assert\Min(limit="0", message="Wartość w polu cena nie może być ujemna")
     */
    private $price;

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
     * Get the price
     *
     * @return decimal The price
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Set the price
     *
     * @param decimal $value The price
     */
    public function setPrice($value)
    {
        $this->price = $value;
    }

    /**
     * Get the name.
     * 
     * @return String The name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name.
     * 
     * @param String $value The name.
     */
    public function setName($value)
    {
        $this->name = $value;
    }
}