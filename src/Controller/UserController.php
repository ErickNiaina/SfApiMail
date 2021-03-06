<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;


class UserController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     * path = "/user",
     * name = "liste_users")
     */
    public function cgetUserAction(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->view(['data' => $users], 200);
    }

    /**
     * @Rest\Post(
     * path = "/user",
     * name = "add_user")
     */
    public function postUserAction(Request $request,ValidatorInterface $validator)
    {
        $user = new User();
        $body = $request->getContent();
        $data = json_decode($body, true);
        $form = $this->createForm(UserType::class, $user);
        $form->submit($data);
        
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new JsonResponse($errorsString);
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('liste_users');
    }

    /**
     * @Rest\Get(
     * path = "/user/{id}",
     * name = "show_user")
     */
    public function getUserAction(User $user)
    {
        return $this->view(['data' => $user], 200);
    }

    /**
     * @Rest\Put(
     * path = "/user/{id}",
     * name = "get_user")
     */
    public function putUserAction(Request $request,User $user,ValidatorInterface $validator)
    {
        $body = $request->getContent();
        $data = json_decode($body, true);
        $form = $this->createForm(UserType::class, $user);
        $form->submit($data);
        
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new JsonResponse($errorsString);
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->view(['data' => $user], 200);
    }

    /**
     * @Rest\Delete(
     * path = "/user/{id}",
     * name = "remove_remove")
     */
    public function deleteUserAction(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('liste_users');
    }


    /**
     * @Rest\Post(
     * path = "/api/login",
     * name = "log_user")
     */
    public function postLoginUserAction(Request $request, UserRepository $userRepository,JWTEncoderInterface $JWTEncoder)
    {
        $data = json_decode($request->getContent(), true) ?: [];
        $user = $userRepository->findOneByEmail($data['email']);

        $token = $JWTEncoder->encode(['email' => $data['email']]);

        return $this->view(['data' => ['token' => $token, 'user' => $user]], 200);
    }
}
