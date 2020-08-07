<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user/inscription", name="user_inscription")
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->render('user/addUserSuccess.html.twig');
        }

        return $this->render('user/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/login", name="user_login")
     */
    public function login(Request $request) {
        return $this->render('user/login.html.twig');
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout() {}
}
