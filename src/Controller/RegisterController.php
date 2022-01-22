<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {

        //on instancie un nouvel objet User
        $user = new User(); //nouvel objet utilisateur 
        //on crée un formulaire avec l'objet User
        $form = $this->createForm(RegisterType::class, $user); //la class de mon formulaire et 2nd parametre : l'objet User 
        //on recupere la requete
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            //on recupere les données du formulaire
            $user = $form->getData();
            //on encode le mot de passe
            $password = $passwordHasher->hashPassword($user, $user->getPassword());
            //on remplace le mot de passe par le mot de passe hashé
            $user->setPassword($password);


            $this->entityManager->persist($user);
            $this->entityManager->flush();

            //on envoie un message flash
            $this->addFlash('success', 'Votre compte a bien été créé');

            // $data = $form->getData();
            // //on recupere le mot de passe
            // $password = $data->getPassword();
            // //on crypte le mot de passe
            // $encoded = password_hash($password, PASSWORD_BCRYPT);
            // //on remplace le mot de passe par le mot de passe crypté
            // $data->setPassword($encoded);
            // //on recupere l'entity manager
            // $em = $this->getDoctrine()->getManager();
            // //on persiste l'objet User
            // $em->persist($data);
            // //on enregistre en base de données
            // $em->flush();
            // //on redirige vers la page de connexion
            // return $this->redirectToRoute('login');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
