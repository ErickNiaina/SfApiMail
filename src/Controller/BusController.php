<?php

namespace App\Controller;

use App\Entity\Bus;
use App\Form\BusType;
use App\Repository\BusRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class BusController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     * path = "/bus",
     * name = "bus_index")
     */
    public function index(BusRepository $busRepository)
    {
        $busAll = $busRepository->findAll();
        return $this->view(['data' => $busAll],200);
    }

    /**
     * @Rest\Post(
     * path = "/bus/new",
     * name = "bus_new")
     */
    public function new(Request $request,ValidatorInterface $validator)
    {
        $bus = new Bus();
        $body = $request->getContent();
        $data = json_decode($body,true);
        $form = $this->createForm(BusType::class, $bus);
        $form->submit($data);
        $error = $validator->validate($bus);

        if(count($error) > 0){
            $errorString = (string) $error;
            return new JsonResponse($errorString);
        }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bus);
            $entityManager->flush();

            return $this->view(['data' => $bus], 200);
            //return $this->redirectToRoute('bus_index');
    }

    /**
     * @Rest\Get(
     * path = "/bus/{id}/show",
     * name = "bus_show")
     */
    public function show(Bus $bus)
    {
        return $this->view(['data' => $bus], 200);
    }

    /**
     * @Rest\Put(
     * path = "/bus/{id}",
     * name = "bus_edit")
     */
    public function edit(Request $request, Bus $bus,ValidatorInterface $validator)
    {
        $body = $request->getContent();
        $data = json_decode($body,true);
        $form = $this->createForm(BusType::class, $bus);
        $form->submit($data);
        $error = $validator->validate($bus);

        if(count($error) > 0){
            $errorString = (string) $error;
            return new JsonResponse($errorString);
        }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->view(['data' => $bus], 200);
    }


    /**
     * @Rest\Delete(
     * path = "/bus/{id}",
     * name = "bus_delete")
     */
    public function delete(Request $request, Bus $bus): Response
    {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bus);
            $entityManager->flush();

        return new JsonResponse(['message' => 'L\'objet a été supprimer avec success!'],200);
    }
}
