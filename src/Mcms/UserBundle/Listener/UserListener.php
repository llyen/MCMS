<?php

namespace Mcms\UserBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

use Mcms\UserBundle\Entity\Sequence;

class UserListener
{
	private $encoderFactory;

	public function __construct(EncoderFactoryInterface $encoderFactory)
	{
		$this->encoderFactory = $encoderFactory;
	}

	public function prePersist(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();
		$em = $args->getEntityManager();

		if($entity instanceof \Mcms\UserBundle\Entity\User)
		{	
			$user = $entity;

			$sequence = $em->getRepository('McmsUserBundle:Sequence')->findAll();
			if(!is_null($sequence))
			{
				$sequence = new Sequence();

				$em->persist($sequence);
				$em->flush();
			}
			else
			{
				$sequence = $sequence[0];
			}

        	$user->setUsername($sequence->nextVal());
        	$user->setSalt();

        	$encoder = $this->encoderFactory->getEncoder($user);
        	$user->setPassword($encoder->encodePassword($sequence->getSeqValue(), $user->getSalt()));
		}
	}
}