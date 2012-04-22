<?php

namespace Mcms\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Mcms\ProductBundle\Entity\Product;
use Mcms\ProductBundle\Form\Type\ProductType;

/**
 * Product controller.
 *
 * @Route("/product")
 */
class ManageController extends Controller
{
	/**
	 * List all products.
	 * 
	 * @Route("/", name="products")	 * 
	 * @Template("McmsProductBundle:Manage:listAllProducts.html.twig")
	 */
	public function productIndexAction()
	{
		$em = $this->getDoctrine()->getEntityManager();

		$products = $em->getRepository('McmsProductBundle:Product')->findBy(array('package' => NULL));
		return array('products' => $products);
	}

	/**
	 * Finds and displays a Product
	 * 
	 * @param integer $id Product id.
	 * 
	 * @Route("/{id}/show", name="product_show")
	 * @Template("McmsProductBundle:Manage:showProduct.html.twig")
	 */
	public function productShowAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$product = $em->getRepository('McmsProductBundle:Product')->find($id);

		if(!$product)
		{
			throw $this->createNotFoundException('Unable to find Product.');
		}

		$deleteForm = $this->createDeleteForm($id);

		return array(
			'product' => $product,
			'delete_form' => $deleteForm->createView()
		);
	}

	/**
	 * Displays a form to create new Product
	 * 
	 * @param integer $id Package id.
	 * 
	 * @Route("/new", name="product_new")
	 * @Template("McmsProductBundle:Manage:newProduct.html.twig")
	 */
	public function productNewAction()
	{
		$form = $this->createForm(new ProductType(), new Product());

		return array('form' => $form->createView());
	}

	/**
	 * Creates a new Product.
	 * 
	 * @Route("/create", name="product_create")
	 * @Method("post")
	 * @Template("McmsProductBundle:Manage:newProduct.html.twig")
	 */
	public function productCreateAction()
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

			return $this->redirect($this->generateUrl('product_show', array('id' => $product->getId())));
		}

		return array(
            'form'   => $form->createView()
        );
	}

	/**
	 * Display a form to edit Product
	 * 
	 * @Route("/{id}/edit", name="product_edit")
	 * @Template("McmsProductBundle:Manage:editProduct.html.twig")
	 */
	public function productEditAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$product = $em->getRepository('McmsProductBundle:Product')->find($id);

		if(!$product)
		{
			throw $this->createNotFoundException('Unable to find Product.');
		}

		$form = $this->createForm(new ProductType(), $product);
		$deleteForm = $this->createDeleteForm($id);

		return array(
			'product' => $product,
			'form' => $form->createView(),
			'delete_form' => $deleteForm->createView()
		);
	}

	/**
	 * Edits Product.
	 * 
	 * @Route("/{id}/update", name="product_update")
	 * @Method("post")
	 * @Template("McmsProductBundle:Manage:editProduct.html.twig")
	 */
	public function productUpdateAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();

		$product = $em->getRepository('McmsProductBundle:Product')->find($id);

		if(!$product)
		{
			throw $this->createNotFoundException('Unable to find Product.');
		}

		$request = $this->getRequest();
		$form = $this->createForm(new ProductType(), $product);
		$form->bindRequest($request);

		if($form->isValid())
		{
			$em->persist($product);
			$em->flush();

			return $this->redirect($this->generateUrl('product_show', array('id' => $product->getId())));
		}

		$deleteForm = $this->createDeleteForm($id);

		return array(
			'product' => $product,
			'form' => $form->createView(),
			'delete_form' => $deleteForm->createView()
		);
	}

	/**
	 * Deletes a Product.
	 * 
	 * @Route("/{id}/delete", name="product_delete")
	 * @Method("post")
	 */
	public function productDeleteAction($id)
	{
		$request = $this->getRequest();
		$form = $this->createDeleteForm($id);
		$form->bindRequest($request);

		if($form->isValid())
		{
			$em = $this->getDoctrine()->getEntityManager();
			$product = $em->getRepository('McmsProductBundle:Product')->find($id);

			if(!$product)
			{
				throw $this->createNotFoundException('Unable to find Product.');
			}

			$em->remove($product);
			$em->flush();
		}

		return $this->redirect($this->generateUrl('products'));
	}

	/**
	 * Creates and returns delete form object.
	 * 
	 * @param integer $id Product/Package id.
	 * @return Form The delete form object.
	 */
	private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}