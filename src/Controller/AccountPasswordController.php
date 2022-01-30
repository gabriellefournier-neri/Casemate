<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/compte/modifier-mon-mot-de-passe", name="account_password")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $notif = null;

        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        //preparer le formulaire à ecouter la requete
        $form->handleRequest($request);

        //si le formulaire est soumis et valide
        if ($form ->isSubmitted() && $form->isValid()) {
            //recuperer les données du formulaire
            $oldPass = $form->get('old_password')->getData();

            //verifier si le mot de passe actuel est bon
            if ($encoder->isPasswordValid($user, $oldPass)){
                //recuperer le nouveau mot de passe
                $newPass = $form->get('new_password')->getData();
                //encoder le nouveau mot de passe
                $password = $encoder->hashPassword($user, $newPass);

                //modifier le mot de passe
                $user->setPassword($password);
                //sauvegarder en base de données
                $this->entityManager->flush();
                $notif = 'Votre mot de passe a bien été modifié'; 
            } else {
                $notif = 'Votre mot de passe actuel renseigné est incorrect';
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notif' => $notif,
        ]);
    }
}
