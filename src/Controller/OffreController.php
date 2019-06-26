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
use App\Repository\CategorieOffreRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OffreController extends AbstractController
{
    /**
     * @Route("/offres", name="offres")
     */
    public function index(ObjectManager $manager, OffreRepository $repo)
    {
    	$offres = $repo->findAll();

        return $this->render('offre/index.html.twig', [
            'offres'  => $offres,
        ]);
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

                    $comp_off = new CompetenceOffre();
                    $comp_off->setNiveau($niveau);
                    $comp_off->setCompetence($competence);
                    $manager->persist($comp_off);
                    $offre->addCompetenceOffre($comp_off);

                }
            }
            $manager->persist($offre);
            $manager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('offre/add.html.twig', [
            'form'          =>   $form->createView(),
            'type'          =>   $type,
            'competences'   =>   $competences,
        ]);
    }
}
