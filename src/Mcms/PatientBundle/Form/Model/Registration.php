<?php

namespace Mcms\PatientBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Mcms\PatientBundle\Entity\Patient;
use Mcms\UserBundle\Entity\User;

class Registration
{
	/**
	 * @var User $user
	 */
	protected $user;

	/**
	 * @var Patient $patient
	 */
	protected $patient;

	/**
	 * Set the User object
	 * 
	 * @param User $user The User object.
	 */
	public function setUser(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Get the user object
	 * 
	 * @return User The user object.
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Set the Patient object
	 * 
	 * @param Patient $patient The Patient object.
	 */
	public function setPatient(Patient $patient)
	{
		$this->patient = $patient;
	}

	/**
	 * Get the Patient object
	 * 
	 * @return Patient The patient object.
	 */
	public function getPatient()
	{
		return $this->patient;
	}
}