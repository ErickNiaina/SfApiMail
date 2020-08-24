<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/restaurant")
 */
class RestaurantController extends AbstractController
{
    /**
     * @Route("/", name="restaurant_index", methods={"GET"})
     */
    public function getRestaurantsAction(RestaurantRepository $restaurantRepository): Response
    {
        $restaurants = $restaurantRepository->findAll();
        $_restau = [];
        $_restaurants = [];
        foreach($restaurants as $restaurant)
        {
            $_restau['name'] = $restaurant->getName();
            $_restau['adresse'] = $restaurant->getAdresse();
            $_restau['phone'] = $restaurant->getPhone();
            $_restau['id'] = $restaurant->getId();

            $_restaurants[] = $_restau;
        }
        return new JsonResponse($_restaurants,200);

        // return $this->render('restaurant/index.html.twig', [
        //     'restaurants' => $restaurantRepository->findAll()
        // ]);
    }

    /**
     * @Route("/", name="restaurant_new", methods="POST")
     */
    public function postRestaurantAction(Request $request,ValidatorInterface $validator): Response
    {
        $restaurant = new Restaurant();
        $body = $request->getContent();
        $data = json_decode($body,true);
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->submit($data);
        $error = $validator->validate($restaurant);

        if(count($error) > 0){
            $errorString = (string) $error;
            return new JsonResponse($errorString);
        }

        //if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('restaurant_index');
            //return $this->redirectToRoute('restaurant_index');
        //}

        // return $this->render('restaurant/new.html.twig', [
        //     'restaurant' => $restaurant,
        //     'form' => $form->createView(),
        // ]);
    }

    /**
     * @Route("/{id}", name="restaurant_show", methods="GET")
     */
    public function getRestaurantAction(Restaurant $restaurant): Response
    {
            $_restau['name'] = $restaurant->getName();
            $_restau['adresse'] = $restaurant->getAdresse();
            $_restau['phone'] = $restaurant->getPhone();
            $_restau['id'] = $restaurant->getId();

            return new JsonResponse($_restau,200);
        // return $this->render('restaurant/show.html.twig', [
        //     'restaurant' => $restaurant,
        // ]);
    }

    /**
     * @Route("/{id}", name="restaurant_edit", methods="PUT")
     */
    public function putRestaurantAction(Request $request, Restaurant $restaurant,ValidatorInterface $validator): Response
    {
        $body = $request->getContent();
        $data = json_decode($body,true);
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->submit($data);
        $error = $validator->validate($restaurant);

        if(count($error) > 0){
            $errorString = (string) $error;
            return new JsonResponse($errorString);
        }

        //if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            //$entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('restaurant_index');
    }

    /**
     * @Route("/{id}", name="restaurant_delete", methods="DELETE")
     */
    public function deleteRestaurantAction(Request $request, Restaurant $restaurant): Response
    {
        //if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($restaurant);
            $entityManager->flush();
        //}

        return $this->redirectToRoute('restaurant_index');
    }
}
