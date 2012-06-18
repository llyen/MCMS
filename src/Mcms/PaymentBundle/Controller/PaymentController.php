<?php

namespace Mcms\PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mcms\PaymentBundle\Entity\Payment;
use Mcms\PaymentBundle\Form\Type\PaymentType;

/**
 * Payment controller
 */
class PaymentController extends Controller
{
	/**
	 * List all Payments
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getEntityManager();

		$payments = $em->getRepository('McmsPaymentBundle:Payment')->findAll();
	}

	/**
	 * Displays a form to create new Payment
	 */
	public function newAction()
	{
		$payment = new Payment();

		$form = $this->createForm(new PaymentType(), $payment);

		return $this->render('McmsPaymentBundle:Employee:new.html.twig', array(
			'form' => $form->createView()
		));
	}

	public function createAction()
	{
		$payment = new Payment();
		$request = $this->getRequest();
        $form = $this->createForm(new PaymentType(), $payment);
        $form->bindRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($payment);
            $em->flush();

            return $this->redirect($this->generateUrl('employee.paymentNew'));
            
        }

        return $this->render('McmsPaymentBundle:Employee:new.html.twig', array(
			'form' => $form->createView()
		));
	}
}