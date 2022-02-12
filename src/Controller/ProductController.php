<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Vinyle;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/Vinyles", name="products")
     */
    public function index(Request $request): Response
    {        
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            // si la barre de recherche est utilisé par l'utilisateur
            $products = $this->entityManager->getRepository(Vinyle::class)->findWithSearch($search);
        } else { // sinon, afficher tous les vinyles
            $products = $this->entityManager->getRepository(Vinyle::class)->findAllVinylesDESC();
        }


        return $this->render('product/index.html.twig', [
            'products' => $products,
            //on crée le formulaire 
            'recherche' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Vinyles/{slug}", name="show")
     */

    public function show($slug){

        $product = $this->entityManager->getRepository(Vinyle::class)->findOneBy(['slug' => $slug]);

        if(!$product){
            return $this->redirectToRoute('products');
        }


            return $this->render('product/show.html.twig', [
                'product' => $product
            ]);
    }

    /**
     * @Route("derniers-ajouts", name="arrivage")
     */
    public function arrivage(){

        $products = $this->entityManager->getRepository(Vinyle::class)->findLastVinyles();

        return $this->render('product/arrivage.html.twig', [
            'products' => $products
        ]);
    }
}
