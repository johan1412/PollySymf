<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user_inscription", name="user_inscription")
     */
    public function inscription(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $login = $user->getLogin();
            $loginExist = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['login' => $login]);
            if($loginExist) {
                return $this->render('user/inscription.html.twig', [
                    'form' => $form->createView(),
                    'errorLogin' => 'Ce login existe déjà.',
                ]);
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->render('user/addUserSuccess.html.twig');
            }
        }

        return $this->render('user/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
