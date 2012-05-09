<?php

namespace Mcms\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Mcms\ProductBundle\Entity\Product;
use Mcms\ProductBundle\Form\Type\ProductType;
/**
 * Product controller
 */
class ProductController extends Controller
{
	/**
	 * List products
	 * 
	 * @param String $roleTheme Role theme name.
	 */
	public function listAction($roleTheme)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$products = $em->getRepository('McmsProductBundle:Product')->findAll();

		return $this->render('McmsProductBundle:'.$roleTheme.':list.html.twig',array(
			'products' => $products
		));
	}

	/**
	 * Finds and displays single product
	 * 
	 * @param String $roleTheme Role theme name.
	 * @param integer $id Product id.
	 */
	public function showAction($roleTheme, $id)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$product = $em->getRepository('McmsProductBundle:Product')->find($id);

		if(!$product) {
			throw $this->createNotFoundException('Unable to find Product.');
		}

		$deleteForm = $this->createHiddenFieldForm($id);

		return $this->render('McmsProductBundle:'.$roleTheme.':show.html.twig',array(
			'product' => $product,
			'deleteForm' => $deleteForm->createView()
		));
	}

	/**
	 * Displays a form to create new product
	 */
	public function newAction()
	{
		$product = new Product();

		$form = $this->createForm(new ProductType(), $product);

		return $this->render('McmsProductBundle:Admin:new.html.twig',array(
			'form' => $form->createView()
		));
	}

	/**
	 * Creates new product
	 */
	public function createAction()
	{
		$product = new Product();

		$request = $this->getRequest();

		$form = $this->createForm(new ProductType(), $product);
		$form->bindRequest($request);

		if($form->isValid())
		{
			$em = $this->getDoctrine()->getEntityManager();
			$em->persist($product);
			$em->flush();

			return $this->redirect($this->generateUrl('admin.productShow', array('id' => $product->getId())));
		}

		return $this->render('McmsProductBundle:Admin:new.html.twig',array(
			'form' => $form->createView()
		));
	}

	/**
	 * Displays a form to edit product
	 * 
	 * @param integer $id Product id.
	 */
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$product = $em->getRepository('McmsProductBundle:Product')->find($id);

		if(!$product) {
			throw $this->createNotFoundException('Unable to find Product.');
		}

		$form = $this->createForm(new ProductType(), $product);
		$deleteForm = $this->createHiddenFieldForm($id);

		return $this->render('McmsProductBundle:Admin:edit.html.twig',array(
			'product' => $product,
			'form' => $form->createView(),
			'deleteForm' => $deleteForm->createView()
		));
	}

	/**
	 * Updates product details
	 * 
	 * @param integer $id Product id.
	 */
	public function updateAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$product = $em->getRepository('McmsProductBundle:Product')->find($id);

		if(!$product) {
			throw $this->createNotFoundException('Unable to find Product.');
		}

		$request = $this->getRequest();

		$form = $this->createForm(new ProductType(), $product);
		$form->bindRequest($request);

		if($form->isValid())
		{
			$em->persist($product);
			$em->flush();

			return $this->redirect($this->generateUrl('admin.productShow', array('id' => $id)));
		}

		$deleteForm = $this->createHiddenFieldForm($id);

		return $this->render('McmsProductBundle:Admin:edit.html.twig',array(
			'product' => $product,
			'form' => $form->createView(),
			'deleteForm' => $deleteForm->createView()
		));
	}

	/**
	 * Deletes product
	 * 
	 * @param integer $id Product id.
	 */
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$product = $em->getRepository('McmsProductBundle:Product')->find($id);

		if(!$product) {
			throw $this->createNotFoundException('Unable to find Product.');
		}

		$request = $this->getRequest();

		$form = $this->createHiddenFieldForm($id);
		$form->bindRequest();

		if($form->isValid())
		{
			$em->remove($product);
			$em->flush();
		}

		return $this->redirect($this->generateUrl('admin.productList'));
	}

	/**
	 * Creates and returns form with one hidden ID field
	 * 
	 * @param integer $id Hidden field value
	 * @return Form Form with on hidden ID field.
	 */
	private function createHiddenFieldForm($id)
	{
		$form = $this->createFormBuilder(array('id' => $id))
			->add('id', 'hidden')
			->getForm();

		return $form;
	}
}