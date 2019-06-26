<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Prerequis;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Repository\PrerequisRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\LocalisationRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    /**
     * @Route("/formations", name="formations")
     */
    public function index(ObjectManager $manager, FormationRepository $repo)
    {
    	$formations = $repo->findAll();
    	
        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/formations/add", name="formations_add")
     */
    public function add(Request $request, ObjectManager $manager, FormationRepository $repo, PrerequisRepository $prerequisRepo, LocalisationRepository $localisationRepo, EntrepriseRepository $entrepriseRepo)
    {
        $formation = new Formation();
        $prerequisChoice = $prerequisRepo->findAll();

        $form = $this->createForm(FormationType::class, $formation);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $user = $this->getUser();
            $auteur = $entrepriseRepo->findOneByUser($user->getId())[0];
            $formation->setAuteur($auteur);
            // $lieu = $localisationRepo->find();
            // $formation->setLieu($lieu);

            $prerequis_arr = explode("___", $request->request->get('prerequis'));
            dump($prerequis_arr);
            foreach ($prerequis_arr as $element) { 
                if ($element != "") {
                    $id = (int)$element;
                    if(strlen($element) < 3) {
                        $prerequis = $prerequisRepo->find($id);
                        $formation->addPrerequi($prerequis);
                        $manager->persist($prerequis);
                        $manager->flush();
                    }else{
                        $prerequis = new Prerequis();
                        $prerequis->setDescription($element);
                        $manager->persist($prerequis);
                        $formation->addPrerequi($prerequis);
                        $manager->flush();
                    }

                }
            }

            $manager->persist($formation);
            $manager->flush();
            // return $this->redirectToRoute('home');
        }
        return $this->render('formation/add.html.twig', [
            'form'          =>   $form->createView(),
            'prerequis'     =>   $prerequisChoice,
        ]);
    }
}
