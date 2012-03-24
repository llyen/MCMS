<?php

namespace Mcms\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var integer $product
     * 
     * @ORM\OneToMany(targetEntity="Product", mappedBy="package")
     */
    private $product;

    /**
     * @var integer $package
     * 
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="product")
     * @ORM\JoinColumn(name="packageId", referencedColumnName="id")
     */
    private $package;

    /**
     * @var float $price
     * 
     * @ORM\Column(name="price", type="decimal", scale=2)
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

    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add product
     *
     * @param Mcms\ProductBundle\Entity\Product $product
     */
    public function addProduct(\Mcms\ProductBundle\Entity\Product $product)
    {
        $this->product[] = $product;
    }

    /**
     * Get product
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set package
     *
     * @param Mcms\ProductBundle\Entity\Product $package
     */
    public function setPackage(\Mcms\ProductBundle\Entity\Product $package)
    {
        $this->package = $package;
    }

    /**
     * Get package
     *
     * @return Mcms\ProductBundle\Entity\Product 
     */
    public function getPackage()
    {
        return $this->package;
    }
}