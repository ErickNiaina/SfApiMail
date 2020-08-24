<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $contact = $form->getData();
            
            $message = (new \Swift_Message('Nouveau Contact'))
            ->setFrom($contact->getEmail())
            ->setTo('Gehjaniaina@gmail.com')
            ->setBody(//compact('contact') = 'contact' =>contact
                $this->renderView("emails/contact.html.twig",compact('contact')),
                'text/html'
            );

            $mailer->send($message);


            $this->addFlash('message','Le message a bien été envoyé');

            return $this->redirectToRoute('contact');

        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/list/user", name="user_list")
     */
    public function userList(UserService $userService)
    {
        $list = $userService->listUser();

        return $this->render('user/list.html.twig',compact('list'));
    }

    /**
     * @Route("/d/export", name="d_export")
     */
    public function exportD(UserService $userService)
    {
        $userService->exportDExcel($userService);

    }
}
