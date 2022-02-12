<?php

namespace App\Controller;

use App\Entity\Vinyle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {

        //afficher les 8 derniers vinyles ajouté

        $products = $this->entityManager->getRepository(Vinyle::class)->findVinylesForHome();

        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }
}
