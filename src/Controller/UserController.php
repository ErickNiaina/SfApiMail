<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="User")
     */
    public function index()
    {

        return new JsonResponse(['hearts' => rand(5, 100)]);
    }


    /**
     * @Route("/userapi", name="apilistUser")
     */
    public function apiUserList(UserService $user){
        $users = $user->listUser();
        return $this->json($users);
    }
}
