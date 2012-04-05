<?php

namespace Mcms\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mcms\UserBundle\Entity\UserRole
 *
 * @ORM\Table(name="user_roles")
 * @ORM\Entity(repositoryClass="Mcms\UserBundle\Entity\UserRoleRepository")
 */
class UserRole
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
     * @var integer $userId
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $userId;

    /**
     * @var integer $roleId
     *
     * @ORM\ManyToOne(targetEntity="Role")
     */
    private $roleId;


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
     * Set userId
     *
     * @param integer $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set roleId
     *
     * @param integer $roleId
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * Get roleId
     *
     * @return integer 
     */
    public function getRoleId()
    {
        return $this->roleId;
    }
}