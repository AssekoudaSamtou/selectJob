<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Entreprise;
use App\Entity\Particulier;
use App\Form\EntrepriseType;
use App\Form\ParticulierType;

use App\Form\RegistrationType;
use App\Repository\SecteurRepository;
use App\Repository\LocalisationRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, SecteurRepository $secteurRepo, LocalisationRepository $localisationRepo)
    {
        // dump($secteurRepo->find($request->request->get('entreprise')["secteur"]));

        $user = new User();
        $entreprise = new Entreprise();
        $particulier = new Particulier();
    
        $form = $this->createForm(RegistrationType::class, $user);
        $entrepriseForm = $this->createForm(EntrepriseType::class, $entreprise);
        $particulierForm = $this->createForm(ParticulierType::class, $particulier);

        $form->handleRequest($request);
        if ($form->isSubmitted() ) {//&& $form->isValid()
            
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            if ($request->request->get('type_compte') == "E") {
                $entrepriseForm ->handleRequest($request);
                $entreprise->setNom($request->request->get('entreprise')["nom"]);
                $entreprise->setSecteur($secteurRepo->find($request->request->get('entreprise')["secteur"]));
                $entreprise->setLocalisation($localisationRepo->find($request->request->get('entreprise')["localisation"]));
                $entreprise->setUser($user);
                $manager->persist($entreprise);
                $manager->flush();
            }
            else if ($request->request->get('type_compte') == "P") {
                $particulierForm->handleRequest($request);
                // $particulier->setNom($request->request->get('particulier')["nom"]);
                // $particulier->setPrenom($request->request->get('particulier')["prenom"]);
                // $particulier->setTelephone($request->request->get('particulier')["telephone"]);
                // $particulier->setSexe($request->request->get('particulier')["sexe"]);
                // $particulier->setProfession($request->request->get('particulier')["profession"]);
                $particulier->setUser($user);
                $manager->persist($particulier);
                $manager->flush();
            }

            $manager->persist($user);
            $manager->flush();

            dump($user->getUsername());

            // return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
        	'form'            => $form->createView(),
            'entrepriseForm'  => $entrepriseForm->createView(),
            'particulierForm' => $particulierForm->createView(),
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login() {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout() {}

}
