<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Prerequis;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Repository\PrerequisRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\ParticulierRepository;
use App\Repository\LocalisationRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    /**
     * @Route("/formations", name="formations")
     */
    public function index(ObjectManager $manager, FormationRepository $repo)
    {
        $user = $this->getUser();
        if ($user == null){
            return $this->redirectToRoute('security_login');
        }
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
            return $this->redirectToRoute('user_annonces');
        }
        return $this->render('formation/add.html.twig', [
            'form'          =>   $form->createView(),
            'prerequis'     =>   $prerequisChoice,
        ]);
    }

    /**
     * @Route("/formations/suscribe", name="formations_suscribe")
     */
    public function suscribe(Request $request, ObjectManager $manager, FormationRepository $formationRepo, ParticulierRepository $particulierRepo)
    {
        if(($request->isXmlHttpRequest()) && ($request->getMethod() == 'POST'))
        {
            $formation_id = (int) $request->request->get("formation");
            $particulier_id = (int) $request->request->get("particulier");
            $formation = $formationRepo->find($formation_id);
            $particulier = $particulierRepo->find($particulier_id);

            $formation->addPostulant($particulier);
            $manager->persist($formation);
            $manager->flush();
            return new Response(json_encode(["zaza" => $particulier->getNom()]));
        }
    }

    /**
     * @Route("/formations/unsuscribe", name="formations_unsuscribe")
     */
    public function unsuscribe(Request $request, ObjectManager $manager, FormationRepository $formationRepo, ParticulierRepository $particulierRepo)
    {
        if(($request->isXmlHttpRequest()) && ($request->getMethod() == 'POST'))
        {
            $formation_id = (int) $request->request->get("formation");
            $particulier_id = (int) $request->request->get("particulier");
            $formation = $formationRepo->find($formation_id);
            $particulier = $particulierRepo->find($particulier_id);

            $formation->removePostulant($particulier);
            $manager->persist($formation);
            $manager->flush();
            return new Response(json_encode(["zaza" => $particulier->getNom()]));
        }
    }

    /**
     * @Route("/formations/delete", name="formations_delete")
     */
    public function delete(Request $request, ObjectManager $manager, FormationRepository $formationRepo)
    {
        if(($request->isXmlHttpRequest()) && ($request->getMethod() == 'POST'))
        {
            $formation_id = (int) $request->request->get("formation");
            $formation = $formationRepo->find($formation_id);

            $manager->remove($formation);
            $manager->flush();
            return new Response(json_encode(["zaza"]));
        }
    }

    /**
     * @Route("/formations/update", name="formations_update")
     */
    public function update(Request $request, ObjectManager $manager, FormationRepository $repo, PrerequisRepository $prerequisRepo, LocalisationRepository $localisationRepo, EntrepriseRepository $entrepriseRepo)
    {
        $formation = $repo->find($request->query->get("id"));
        $prerequisChoice = $prerequisRepo->findAll();
        $formationPrerequis = $formation->getPrerequis();

        $form = $this->createForm(FormationType::class, $formation);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            // $user = $this->getUser();
            // $auteur = $entrepriseRepo->findOneByUser($user->getId())[0];
            // $formation->setAuteur($auteur);

            $formation->emptyPrerequis();
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
            return $this->redirectToRoute('user_annonces');
        }
        return $this->render('formation/update.html.twig', [
            'form'               =>   $form->createView(),
            'prerequis'          =>   $prerequisChoice,
            'formationPrerequis' =>   $formationPrerequis,
        ]);
    }
}
