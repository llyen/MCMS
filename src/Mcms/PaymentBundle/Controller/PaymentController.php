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

		return $this->render('McmsPaymentBundle:Employee:list.html.twig', array(
			'payments' => $payments
		));
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

	/**
	 * Creates a new payment
	 * 
	 * @param Payment $payment
	 * @param Patient $patient
	 */
	public function createAction($payment, $patient)
	{
		$patient=$patient;
		$request = $this->getRequest();
        $form = $this->createForm(new PaymentType(), $payment);
        $form->bindRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($payment);
            $em->flush();

            return $this->redirect($this->generateUrl('employee.medicalHistory', array('patientId' => $patient->getId())));
            
        }
	}

	/**
	 * Finds and display a single payment details
	 * 
	 * @param integer $paymentId
	 */
	public function showAction($paymentId)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$payment = $em->getRepository('McmsPaymentBundle:Payment')->find($paymentId);
		if(!$payment) {
            throw $this->createNotFoundException('Unable to find payment.');
        }

        return $this->render('McmsPaymentBundle:Employee:show.html.twig', array(
            'payment' => $payment
        ));
	}

	/**
	 * Displays a form to edit an existing payment
	 * 
	 * @param integer $paymentId
	 */
	public function editAction($paymentId)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$payment = $em->getRepository('McmsPaymentBundle:Payment')->find($paymentId);

		if(!$payment) {
			throw $this->createNotFoundException('Unable to find payment.');
		}

		$form = $this->createForm(new PaymentType(), $payment);

		return $this->render('McmsPaymentBundle:Employee:edit.html.twig', array(
            'form' => $form->createView(),
            'payment' => $payment
        ));
	}

	/**
	 * Edits an existing payment
	 * 
	 * @param integer $paymentId
	 */
	public function updateAction($paymentId, $patientId)
	{
		$originalProducts = array();
		$em = $this->getDoctrine()->getEntityManager();

		$payment = $em->getRepository('McmsPaymentBundle:Payment')->find($paymentId);

		foreach ($payment->getProducts() as $product) 
			$originalProducts[] = $product;

		if(!$payment) {
			throw $this->createNotFoundException('Unable to find payment.');
		}

		$request = $this->getRequest();

		$form = $this->createForm(new PaymentType(), $payment);
		$form->bindRequest($request);



		if($form->isValid()) {

			foreach ($payment->getProducts() as $product) {
                foreach ($originalProducts as $key => $toDel) {
                    if ($toDel->getId() === $product->getId()) {
                        unset($originalProducts[$key]);
                    }
                }
            }

            foreach ($originalProducts as $product) {
                $em->remove($product);
            }

            //echo count($payment->getProducts()).'<br>';exit();

            if(count($payment->getProducts())==0)
            	$em->remove($payment);
            else
            	$em->persist($payment);

            $em->flush();

            return $this->redirect($this->generateUrl('employee.medicalHistory', array('patientId' => $patientId)));
		}

		return $this->redirect($this->generateUrl('employee.medicalHistoryEdit', array('patientId' => $patientId, 'entryId' => $payment->getEntry())));
	}
}