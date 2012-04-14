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

<<<<<<< HEAD

    /**
     * Get roleId
     *
     * @return Mcms\UserBundle\Entity\Role 
=======
    /**
     * Get roleId
     *
     * @return integer 
>>>>>>> 554be3d2ef3a9b83c56ec8975e45d2c96a15b8f4
     */
    public function getRoleId()
    {
        return $this->roleId;
    }
}