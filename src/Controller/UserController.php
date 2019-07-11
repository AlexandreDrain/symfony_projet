<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    /**
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('contact/contact.html.twig', [
            'users' => $userRepository->findByRole('ROLE_GARAGISTE'),
        ]);
    }

//    /**
//     * @param User $user
//     * @return Response
//     */
//    public function show(User $user): Response
//    {
//        return $this->render('contact/show.html.twig', [
//            'user' => $user,
//        ]);
//    }
}
