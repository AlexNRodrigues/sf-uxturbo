<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

class MessagesController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $contact = new Contact();
            $contact->setName($formData['name'])
                ->setEmail($formData['email'])
                ->setMessage($formData['message'])
                ->setStatus('new')
                ->setStar(0);

            $entityManager->persist($contact);
            $entityManager->flush();


            if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

                return $this->render('messages/success.stream.html.twig', [
                    'formData' => $formData,
                ]);
            }

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('messages/new.html.twig', [
            'form' => $form
        ]);
    }
}
