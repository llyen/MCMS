<?php

namespace Mcms\UserBundle\Form\Model;


use Mcms\UserBundle\Validator\Constraint as Validator;
use Mcms\UserBundle\Entity\User;

class ChangePassword
{
	/**
	 * @var String $newPassword
	 */
	protected $newPassword;

	/**
	 * @Validator\UserPassword()
	 */
	protected $oldPassword;

	/**
	 * Set new password
	 * 
	 * @param String $value The new password
	 */
	public function setNewPassword($value)
	{
		$this->newPassword = $value;
	}

	/**
	 * Get new password
	 * 
	 * @return String The new password
	 */
	public function getNewPassword()
	{
		return $this->newPassword;
	}

	/**
	 * Set current password
	 * 
	 * @param String $value The current password
	 */
	public function setOldPassword($value)
	{
		$this->oldPassword = $value;
	}

	/**
	 * Get the current password
	 * 
	 * @return String The current password
	 */
	public function getOldPassword()
	{
		return $this->oldPassword;
	}
}