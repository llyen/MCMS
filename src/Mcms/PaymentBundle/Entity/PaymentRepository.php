<?php

namespace Mcms\PaymentBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PaymentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PaymentRepository extends EntityRepository
{
	/**
	 * Finds and returns payments by patient
	 * 
	 * @param Patien $patient
	 */	
	public function findByPatient($patient)
	{
		return $this->findBy(array('patient' => $patient->getId()));
	}

	/**
	 * Finds and returns unpaid payments
	 */
	public function findUnpaid()
	{
		return $this->findBy(array('is_paid' => false));
	}
}