<?php

namespace App\Classe;

use App\Entity\Vinyle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart{

    private $session;
    private $entityManager;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager){

        $this->session = $session;
        $this->entityManager = $entityManager;
    }
        

    //créer une function qui va nous permettre d'ajouter un produit à notre panier : 
    public function add($id){

        //on récupère le panier dans la session
        $cart = $this->session->get('cart', []);

        //si le produit est déjà dans le panier, on ajoute 1 à la quantité
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else { //sinon, on ajoute le produit au panier
            $cart[$id] = 1;
        }



        $this->session->set('cart', $cart);

    }

    public function get(){
        return $this->session->get('cart', []);
    }


    public function remove(){
        return $this->session->remove('cart', []);
    }

    //function delete qui passe en parametre l'ID du produit
    public function delete($id){
        //on récupère le panier dans la session
        $cart = $this->session->get('cart', []);
        //on supprime le produit du panier
        unset($cart[$id]);
        //on met à jour le panier dans la session
        return $this->session->set('cart', $cart);

    }

    //function pour enlever un produit du panier
    public function decrease($id){
        //on verifie que le nombre d'item est pas à 1
        //on récupère le panier dans la session
        $cart = $this->session->get('cart', []);
        if ($cart[$id] > 1) {
            //on décrémente le nombre d'item
            $cart[$id]--;
        } else {
            //on supprime le produit du panier
            unset($cart[$id]);
        }
        //on met à jour le panier dans la session
        return $this->session->set('cart', $cart);
    }



    public function getFull(){
        $cartInfos = [];
        //j'initialise ma variable de details

        if ($this->get()) {
            //si le panier n'est pas vide
            foreach ($this->get() as $id => $quantity) {

                $product_object = $this->entityManager->getRepository(Vinyle::class)->findOneBy(['id' => $id]);

                if (!$product_object){
                    $this->delete($id);
                    continue;
                }

                //je récupère le produit en BDD
                $cartInfos[] = [
                    //je recupere un tableau de données
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }

        return $cartInfos;
    }
    

}