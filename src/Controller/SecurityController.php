<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Entreprise;
use App\Entity\Experience;
use App\Entity\Particulier;
use App\Form\EntrepriseType;
use App\Form\ParticulierType;
use App\Form\RegistrationType;
use App\Repository\SecteurRepository;
use App\Repository\ExperienceRepository;
use App\Repository\ProfessionRepository;
use App\Repository\LangueParleRepository;
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
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, SecteurRepository $secteurRepo, LocalisationRepository $localisationRepo, ExperienceRepository $expRepo, LangueParleRepository $langueRepo, ProfessionRepository $professionRepo)
    {
        $experiences = $expRepo->findAll();
        $langues = $langueRepo->findAll();

        $user = new User();
        $entreprise = new Entreprise();
        $particulier = new Particulier();
    
        $form = $this->createForm(RegistrationType::class, $user);
        $entrepriseForm = $this->createForm(EntrepriseType::class, $entreprise);
        $particulierForm = $this->createForm(ParticulierType::class, $particulier);

        $form->handleRequest($request);
        if ($form->isSubmitted() ) {//&& $form->isValid()
            
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user = $user->setPassword($hash);
            $user = $user->setUsername($request->request->get('registration')["username"]);

            if ($request->request->get('type_compte') == "E") {
                $entrepriseForm ->handleRequest($request);
                $entreprise->setUser($user);
                $secteur = $secteurRepo->find($request->request->get('entreprise')["secteur"]);
                $entreprise->setSecteur($secteur);
                $manager->persist($entreprise);
            }
            else if ($request->request->get('type_compte') == "P") {
                // $particulierForm->handleRequest($request);
                $particulier->setNom($request->request->get('particulier')["nom"]);
                $particulier->setPrenom($request->request->get('particulier')["prenom"]);
                $particulier->setSexe($request->request->get('particulier')["sexe"]);
                $particulier->setTelephone($request->request->get('particulier')["telephone"]);
                $profession = $professionRepo->find($request->request->get('particulier')["profession"]);
                $particulier->setProfession($profession);
                $particulier->setUser($user);
                $experiences_arr = explode("___", $request->request->get('experiences'));
                foreach ($experiences_arr as $element) { 
                    if ($element != "") {
                        $id = (int)$element;
                        if(strlen($element) < 3) {
                            $experience = $expRepo->find($id);
                            $particulier->addExperience($experience);
                            $manager->persist($experience);
                            $manager->flush();
                        }else{
                            $experience = new Experience();
                            $experience->setDescription($element);
                            $particulier->addExperience($experience);
                            $manager->persist($experience);
                        }

                    }
                }

                $langues_arr = explode("___", $request->request->get('langues'));
                foreach ($langues_arr as $element) { 
                    if ($element != "") {
                        $id = (int)$element;
                        $langue = $langueRepo->find($id);
                        $langue->addParticulier($particulier);
                        $manager->persist($langue);

                    }
                }
                dump($particulier);
                $manager->persist($particulier);
            }

            // $manager->persist($user);
            dump($user);
            $manager->flush();


            // return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
        	'form'            => $form->createView(),
            'entrepriseForm'  => $entrepriseForm->createView(),
            'particulierForm' => $particulierForm->createView(),
            'experiences'     => $experiences,
            'langues'     => $langues,
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
