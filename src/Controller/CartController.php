<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Vinyle;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart)
    {
        
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull(),
        ]);
    }



    /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, $id)
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }



    /**
     * @Route("/cart/delete{id}", name="deleteCart")
     */
    public function delete(Cart $cart, $id)
    {
        $cart->delete($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/decrease{id}", name="decrease")
     */
    public function decrease(Cart $cart, $id)
    {
        //ici j'appelle la fonction associé (decrease) dans ma Class Cart
        $cart->decrease($id);
        return $this->redirectToRoute('cart');
    }
}
