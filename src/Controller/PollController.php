<?php

namespace App\Controller;

use App\Entity\Choix;
use App\Entity\Poll;
use App\Entity\Resultats;
use App\Form\PollType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
    public function newPoll(Request $request, SessionInterface $session) {
        $defaultData = [];
        $formPoll = $this->createForm(PollType::class, $defaultData);
        $poll = new Poll();
        $choix = new Choix();
        $formPoll->handleRequest($request);

        if ($formPoll->isSubmitted() && $formPoll->isValid()) {
            $data = $formPoll->getData();

            $res = new Resultats();
            $res->setRes1(0);
            $res->setRes2(0);
            $res->setRes3(0);
            $res->setRes4(0);
            $res->setRes5(0);

            $choix->setOption1($data['option1']);
            $choix->setOption2($data['option2']);
            $choix->setOption3($data['option3']);
            $choix->setOption4($data['option4']);
            $choix->setOption5($data['option5']);

            $poll->setQuestion($data['question']);
            $poll->setPublic($data['public']);
            $poll->setDatetime(new \DateTime('now'));
            $url = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',2)),0,10);
            $poll->setUrl($url);
            $pseudo = $session->get('pseudo');
            $poll->setPseudo($pseudo);
            $poll->setChoix($choix);
            $poll->setResultats($res);

            $em = $this->getDoctrine()->getManager();
            $em->persist($poll);
            $em->persist($choix);
            $em->flush();
            return $this->render('poll/addPollSuccess.html.twig');
        }
    
        return $this->render('poll/newPoll.html.twig', [
            'form' => $formPoll->createView(),
        ]);
    }
}
