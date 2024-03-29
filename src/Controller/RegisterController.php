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
        $notif = null;
        $notifBad = null;

        //on instancie un nouvel objet User
        $user = new User(); //nouvel objet utilisateur 
        //on crée un formulaire avec l'objet User
        $form = $this->createForm(RegisterType::class, $user); //la class de mon formulaire et 2nd parametre : l'objet User 
        //on recupere la requete
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            //on verifie que l'email renseigné n'existe pas déjà dans la base de données
            $email = $user->getEmail();
            $userRepository = $this->entityManager->getRepository(User::class);
            $userExist = $userRepository->findOneBy(['email' => $email]);
            // si il existe on affiche une notification
            if ($userExist) {
                $notifBad = 'Attention, cette adresse email est déjà utilisée...';
            } else {
                //on récupère les données
                $user = $form->getData();
                //on crypte le mot de passe
                $password = $passwordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($password);
                //on enregistre l'utilisateur en base de données
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                //on redirige vers la page de connexion
                return $this->redirectToRoute('account');
            }
            
            // BEFORE
            // $user = $form->getData();
            // //on encode le mot de passe
            // $password = $passwordHasher->hashPassword($user, $user->getPassword());
            // //on remplace le mot de passe par le mot de passe hashé
            // $user->setPassword($password);

            // $this->entityManager->persist($user);
            // $this->entityManager->flush();
            // $notif = 'Votre compte a bien été créé, vous pouvez vous connecter"';

            //on envoie un message flash
            // $this->addFlash('success', 'Votre compte a bien été créé');
            // END BEFORE

            // TEST ICI
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
            // END TEST
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notif' => $notif,
            'notifBad' => $notifBad,
        ]);
    }
}
