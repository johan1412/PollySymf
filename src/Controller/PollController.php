<?php

namespace App\Controller;

use App\Entity\Poll;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PollController extends AbstractController
{
    /**
     * @Route("/pollList", name="pollList")
     */
    public function index(SessionInterface $session)
    {
        $pseudo = $session->get('pseudo');
        $poll = $this->getDoctrine()
            ->getRepository(Poll::class)
            ->findPublic();
        
        return $this->render('poll/index.html.twig', [
            'pseudo' => $pseudo,
            'sondages' => $poll,
        ]);
    }


    /**
     * @Route("/newPoll", name="new_poll")
     */
    public function newPoll(Request $request) {
        $poll = new Poll();
        $form = $this->createFormBuilder($poll)
            ->add('question', TextType::class)
            ->add('public', ChoiceType::class)
            ->add('')
            ->getForm();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $poll->setDatetime(new \DateTime('now'));
            $url = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',2)),0,10);
            $poll->setUrl($url);
            $pseudo = 
            $poll->setPseudo($pseudo);
            
        }
    }
}
