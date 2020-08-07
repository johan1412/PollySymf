<?php

namespace App\Controller;

use App\Entity\Choix;
use App\Entity\Poll;
use App\Entity\Resultats;
use App\Form\PollType;
use App\Repository\PollRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PollController extends AbstractController
{
    /**
     * @Route("/poll/pollList", name="pollList")
     */
    public function index(SessionInterface $session)
    {
        $pseudo = $session->get('pseudo');
        if(!$pseudo) {
            return $this->redirectToRoute('home');
        }
        $poll = $this->getDoctrine()
            ->getRepository(Poll::class)
            ->findPublic();
        
        return $this->render('poll/index.html.twig', [
            'pseudo' => $pseudo,
            'sondages' => $poll,
        ]);
    }


    /**
     * @Route("/poll/show/{url}", name="show_poll")
     */
    public function showPoll(Request $request, $url) {
        $em = $this->getDoctrine()->getManager();
        $poll = $em->getRepository(Poll::class)->findOneBy([
            'url' => $url,
        ]);
        $defaultData = [];
        $choix = $em->getRepository(Choix::class)->find($poll->getChoix());
        $res = $em->getRepository(Resultats::class)->find($poll->getResultats());
        $form = $this->createFormBuilder($defaultData)
            ->add('choix', ChoiceType::class, [
                'choices' => [
                    $choix->getOption1() => $choix->getOption1(),
                    $choix->getOption2() => $choix->getOption2(),
                    $choix->getOption3() == null ? "null" : $choix->getOption3() => $choix->getOption3(),
                    $choix->getOption4() == null ? "null" : $choix->getOption3() => $choix->getOption4(),
                    $choix->getOption5() == null ? "null" : $choix->getOption3() => $choix->getOption5(),
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'choice_attr' => function() {
                    return ['class' => 'ml-5 mr-1'];
                },
            ])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if($data['choix'] == $choix->getOption1()) {
                $count1 = $res->getRes1();
                $res->setRes1($count1 + 1);
            } elseif($data['choix'] == $choix->getOption2()) {
                $count2 = $res->getRes2();
                $res->setRes2($count2 + 1);
            } elseif($data['choix'] == $choix->getOption3()) {
                $count3 = $res->getRes3();
                $res->setRes3($count3 + 1);
            } elseif($data['choix'] == $choix->getOption4()) {
                $count4 = $res->getRes4();
                $res->setRes4($count4 + 1);
            } elseif($data['choix'] == $choix->getOption5()) {
                $count5 = $res->getRes5();
                $res->setRes5($count5 + 1);
            }
            $em->flush();
            $this->addFlash('success', 'Votre vote a bien été prit en compte');
            return $this->redirectToRoute('pollList');
        }

        $tabRes = [$res->getRes1(), $res->getRes2(), $res->getRes3(), $res->getRes4(), $res->getRes5()];
        return $this->render('poll/show.html.twig', [
            'poll' => $poll,
            'form' => $form->createView(),
            'res' => $tabRes,
        ]);
    }


    /**
     * @Route("/poll/new", name="new_poll")
     */
    public function newPoll(Request $request, SessionInterface $session, PollRepository $pollRepo) {
        $pseudo = $session->get('pseudo');
        if(!$pseudo) {
            return $this->redirectToRoute('home');
        }
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
            $url = "";
            while(($pollRepo->findOneBy(['url' => $url])) || ($url == "")) {
                $url = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',2)),0,10);
            }
            $poll->setUrl($url);
            $pseudo = $session->get('pseudo');
            $poll->setPseudo($pseudo);
            $poll->setChoix($choix);
            $poll->setResultats($res);

            $em = $this->getDoctrine()->getManager();
            $em->persist($poll);
            $em->persist($choix);
            $em->flush();
            return $this->render('poll/addPollSuccess.html.twig', [
                'url' => $poll->getUrl(),
            ]);
        }
    
        return $this->render('poll/newPoll.html.twig', [
            'form' => $formPoll->createView(),
        ]);
    }
}
