<?php

namespace Mcms\EmployeeBundle\Form\Model;

use Mcms\EmployeeBundle\Entity\Employee;
use Mcms\UserBundle\Entity\User;

class Registration
{
	/**
	 * @var User $user
	 */
	protected $user;

	/**
	 * @var Employee $employee
	 */
	protected $employee;

	/**
	 * Set the User object
	 * 
	 * @param User $user The User ubject
	 */
	public function setUser(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Get the User object
	 * 
	 * @return User The User object
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Set the Employee object
	 * 
	 * @param Employee $employee The Employee object
	 */
	public function setEmployee(Employee $employee)
	{
		$this->employee = $employee;
	}

	/**
	 * Get the Employee object
	 * 
	 * @return Employee The Employee object
	 */
	public function getEmployee()
	{
		return $this->employee;
	}
}