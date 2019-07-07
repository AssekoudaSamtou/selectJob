<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\Competence;
use App\Entity\CompetenceOffre;
use App\Form\OffreStageType;
use App\Form\OffreEmploiType;
use App\Repository\OffreRepository;
use App\Repository\NiveauRepository;
use App\Repository\CompetenceRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\ParticulierRepository;
use App\Repository\CategorieOffreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OffreController extends AbstractController
{
    /**
     * @Route("/offres", name="offres")
     */
    public function index(Request $request, OffreRepository $repo)
    {
        $categorie = (int) $request->query->get("type");
    	$offres = $repo->findAllByCategorie($categorie);

        return $this->render('offre/index.html.twig', [
            'offres'  => $offres,
        ]);
    }

    /**
     * @Route("/offres/suscribe", name="offres_suscribe")
     */
    public function suscribe(Request $request, ObjectManager $manager, OffreRepository $offreRepo, ParticulierRepository $particulierRepo)
    {
        if(($request->isXmlHttpRequest()) && ($request->getMethod() == 'POST'))
        {
            $offre_id = (int) $request->request->get("offre");
            $particulier_id = (int) $request->request->get("particulier");
            $offre = $offreRepo->find($offre_id);
            $particulier = $particulierRepo->find($particulier_id);

            $offre->addPostulant($particulier);
            $manager->persist($offre);
            $manager->flush();
            return new Response(json_encode(["zaza" => $particulier->getNom()]));
        }
    }

    /**
     * @Route("/offres/unsuscribe", name="offres_unsuscribe")
     */
    public function unsuscribe(Request $request, ObjectManager $manager, OffreRepository $offreRepo, ParticulierRepository $particulierRepo)
    {
        if(($request->isXmlHttpRequest()) && ($request->getMethod() == 'POST'))
        {
            $offre_id = (int) $request->request->get("offre");
            $particulier_id = (int) $request->request->get("particulier");
            $offre = $offreRepo->find($offre_id);
            $particulier = $particulierRepo->find($particulier_id);

            $offre->removePostulant($particulier);
            $manager->persist($offre);
            $manager->flush();
            return new Response(json_encode(["zaza" => $particulier->getNom()]));
        }
    }

    /**
     * @Route("/offres/delete", name="offres_delete")
     */
    public function delete(Request $request, ObjectManager $manager, OffreRepository $offreRepo)
    {
        if(($request->isXmlHttpRequest()) && ($request->getMethod() == 'POST'))
        {
            $offre_id = (int) $request->request->get("offre");
            $offre = $offreRepo->find($offre_id);

            $manager->remove($offre);
            $manager->flush();
            return new Response(json_encode(["zaza"]));
        }
    }

    /**
     * @Route("/offres/add/{type}", name="offres_add")
     */
    public function add(string $type, Request $request, ObjectManager $manager, OffreRepository $repo, CategorieOffreRepository $cateRepo, CompetenceRepository $competenceRepo, EntrepriseRepository $entrepriseRepo, NiveauRepository $niveauRepo)
    {
        $offre = new Offre();
        $competences = $competenceRepo->findAll();

        if ($type == "emploi"){
            $form = $this->createForm(OffreEmploiType::class, $offre);
        }
        elseif ($type == "stage") {
            $form = $this->createForm(OffreStageType::class, $offre);
        }
        
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $user = $this->getUser();
            $auteur = $entrepriseRepo->findOneByUser($user->getId())[0];
            $offre->setAuteur($auteur);
            $categorie = $cateRepo->findOneByLibelle($request->request->get('type'))[0];
            $offre->setCategorie($categorie);

            $competences_arr = explode("___", $request->request->get('competences'));
            $niveaux_arr = explode("___", $request->request->get('niveaux'));
            $i = 1;
            foreach ($competences_arr as $element) { 
                if ($element != "") {
                    $niveau = $niveauRepo->find((int)$niveaux_arr[$i]);
                    $i++;
                    $id = (int)$element;
                    if(strlen($element) < 3) {
                        $competence = $competenceRepo->find($id);

                    }else{
                        $competence = new Competence();
                        $competence->setLibelle($element);
                        $manager->persist($competence);

                    }

                    $comp_offr = new CompetenceOffre();
                    $comp_offr->setNiveau($niveau);
                    $comp_offr->setCompetence($competence);
                    $manager->persist($comp_offr);
                    $offre->addCompetenceOffre($comp_offr);

                }
            }
            $manager->persist($offre);
            $manager->flush();
            return $this->redirectToRoute('user_annonces');
        }
        return $this->render('offre/add.html.twig', [
            'form'          =>   $form->createView(),
            'type'          =>   $type,
            'competences'   =>   $competences,
        ]);
    }

    /**
     * @Route("/offres/update", name="offres_update")
     */
    public function update(Request $request, ObjectManager $manager, OffreRepository $repo, CategorieOffreRepository $cateRepo, CompetenceRepository $competenceRepo, EntrepriseRepository $entrepriseRepo, NiveauRepository $niveauRepo)
    {
        $offre_id = $request->query->get("id");
        $offre = $repo->find($offre_id);
        // dump();
        $competences = $competenceRepo->findAll();
        $competenceOffres = $offre->getCompetenceOffres();

        if ($offre->getCategorie()->getLibelle() == "emploi"){
            $form = $this->createForm(OffreEmploiType::class, $offre);
        }
        elseif ($offre->getCategorie()->getLibelle() == "stage") {
            $form = $this->createForm(OffreStageType::class, $offre);
        }
        
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {

            $offre->emptyCompetenceOffres();
            $competences_arr = explode("___", $request->request->get('competences'));
            $niveaux_arr = explode("___", $request->request->get('niveaux'));
            $i = 1;
            foreach ($competences_arr as $element) { 
                if ($element != "") {
                    $niveau = $niveauRepo->find((int)$niveaux_arr[$i]);
                    $i++;
                    $id = (int)$element;
                    if(strlen($element) < 3) {
                        $competence = $competenceRepo->find($id);

                    }else{
                        $competence = new Competence();
                        $competence->setLibelle($element);
                        $manager->persist($competence);

                    }

                    $comp_offr = new CompetenceOffre();
                    $comp_offr->setNiveau($niveau);
                    $comp_offr->setCompetence($competence);
                    $manager->persist($comp_offr);
                    $offre->addCompetenceOffre($comp_offr);

                }
            }
            $manager->persist($offre);
            $manager->flush();
            return $this->redirectToRoute('user_annonces');
        }
        return $this->render('offre/update.html.twig', [
            'form'          =>   $form->createView(),
            'competences'   =>   $competences,
            'competenceOffres' =>   $competenceOffres,
        ]);
    }
}
