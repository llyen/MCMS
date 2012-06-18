<?php

namespace Mcms\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mcms\PaymentBundle\Entity\PaymentProduct
 *
 * @ORM\Table(name="payments_products")
 * @ORM\Entity(repositoryClass="Mcms\PaymentBundle\Entity\PaymentProductRepository")
 */
class PaymentProduct
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
     * @var integer $payment
     * 
     * @ORM\ManyToOne(targetEntity="Payment", inversedBy="products")
     */
    private $payment;

    /**
     * @var integer $product
     * 
     * @ORM\ManyToOne(targetEntity="Mcms\ProductBundle\Entity\Product", inversedBy="payments")
     */
    private $product;

    /**
     * @var integer $count
     * 
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

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
     * Set count
     *
     * @param integer $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set payment
     *
     * @param Mcms\PaymentBundle\Entity\Payment $payment
     */
    public function setPayment(\Mcms\PaymentBundle\Entity\Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get payment
     *
     * @return Mcms\PaymentBundle\Entity\Payment 
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set product
     *
     * @param Mcms\ProductBundle\Entity\Product $product
     */
    public function setProduct(\Mcms\ProductBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Mcms\ProductBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}