<?php

namespace Mcms\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Mcms\PaymentBundle\Entity\Payment
 *
 * @ORM\Table(name="payments")
 * @ORM\Entity(repositoryClass="Mcms\PaymentBundle\Entity\PaymentRepository")
 */
class Payment
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
     * @var integer $patient
     * 
     * @ORM\ManyToOne(targetEntity="Mcms\PatientBundle\Entity\Patient")
     * @ORM\JoinColumn(name="patient", referencedColumnName="id")
     */
    private $patient;

    /**
     * @var boolean $isPaid
     * 
     * @ORM\Column(name="isPaid", type="boolean")
     */
    private $isPaid = false;

    /**
     * @var ArrayColection $products
     * 
     * @ORM\ManyToMany(targetEntity="Mcms\ProductBundle\Entity\Product")
     * @ORM\JoinTable(name="payments_products",
     *      joinColumns={@ORM\JoinColumn(name="payment_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     * )
     */
    private $products;

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
     * Get patient id.
     * 
     * @return integer The patient id.
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * Set the patient id.
     * 
     * @param integer $value The patient id.
     */
    public function setPatient($value)
    {
        $this->patient = $value;
    }

    /**
     * Get the isPaid value.
     * 
     * @return boolean The isPaid value.
     */
    public function getIsPaid()
    {
        return $this->isPaid;
    }

    /**
     * Set the isPaid value.
     * 
     * @param boolean $value The isPaid value.
     */
    public function setIsPaid($value)
    {
        $this->isPaid = $value;
    }

    /**
     * Get products under payment
     * 
     * @return ArrayCollection An Doctrine ArrayCollection of products.
     */
    public function getProducts()
    {
        return $this->products;
    }
}