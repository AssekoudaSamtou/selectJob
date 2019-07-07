<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Message;
use App\Entity\Discussion;
use App\Repository\UserRepository;
use App\Repository\DiscussionRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DiscussionController extends AbstractController
{
    /**
     * @Route("/__discussions", name="discussion")
     */
    public function getDiscussions(Request $request, ObjectManager $manager, DiscussionRepository $discussionRepo, UserRepository $userRepo)
    {

    	if(($request->getMethod() == 'GET'))
        {
            $expediteur_id = (int) $request->query->get("expediteur");
            $destinataire_id = (int) $request->query->get("destinataire");
            $discussions = $discussionRepo->findByCouple($expediteur_id, $destinataire_id);
            
            $expediteur = $userRepo->find($expediteur_id);
            if ( $expediteur->getParticulier() ) {
            	$utilisateur = "P";
            }else{
            	$utilisateur = "E";
            }
	        return $this->render('discussion/discussions.html.twig', [
	            'discussions' => $discussions,
	            'utilisateur' => $utilisateur,
	        ]);
        }
    }

    /**
     * @Route("/__discussions/new_msg", name="new_discussion")
     */
    public function newMessage(Request $request, ObjectManager $manager, DiscussionRepository $discussionRepo, UserRepository $userRepo)
    {

    	if(($request->getMethod() == 'POST'))
        {
            $expediteur_id = (int) $request->request->get("expediteur");
            $destinataire_id = (int) $request->request->get("destinataire");
            $msg = new Message();
            $msg->setContenu($request->request->get("msg"));

            $discussion = new Discussion();
            $discussion->setExpediteur($userRepo->find($expediteur_id));
            $discussion->setDestinataire($userRepo->find($destinataire_id));
            $discussion->setMessage($msg);
            dump($discussion);
            
            $manager->persist($msg);
            $manager->persist($discussion);
            $manager->flush();

            $discussions = $discussionRepo->findByCouple($expediteur_id, $destinataire_id);
            
            $expediteur = $userRepo->find($expediteur_id);
            if ( $expediteur->getParticulier() ) {
            	$utilisateur = "P";
            }else{
            	$utilisateur = "E";
            }
	        return $this->render('discussion/discussions.html.twig', [
	            'discussions' => $discussions,
	            'utilisateur' => $utilisateur,
	        ]);
        }
    }
}
