<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/profil", name="user_profil")
     */
    public function profil(Request $request, ObjectManager $manager, UserRepository $repo)
    {
    	$user_id = $request->query->get("user");
    	if ( $user_id == null ){
    		$user = $this->getUser();
    	}else{
    		$user = $repo->find($user_id);
    	}
    	$tmp = $user->getParticulier();
    	$type = "P";
    	if ( $tmp == null ){
    		$tmp = $user->getEntreprise();
    		$type = "E";
    	}
    	dump($tmp);
        return $this->render('user/profil.html.twig', [
            'compte' => $tmp,
            'type' => $type,
        ]);
    }

    /**
     * @Route("/annonces", name="user_annonces")
     */
    public function annonces_index(Request $request, ObjectManager $manager, UserRepository $repo)
    {
        $user = $this->getUser();
        
        $particulier = $user->getParticulier();
        $entreprise = $user->getEntreprise();
        $type = "P";
        if ( $particulier == null ){
            $type = "E";
        }
        dump($particulier);
        return $this->render('user/annonces.html.twig', [
            'particulier' => $particulier,
            'entreprise' => $entreprise,
            'type' => $type,
        ]);
    }
}
