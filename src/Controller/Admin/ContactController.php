<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/contact', name: 'admin_contact')]
class ContactController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(): Response
    {
        return $this->render('admin/contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    #[Route('/view/{id}', name: '_view')]
    public function view(Contact $contact): Response
    {
        return $this->render('admin/contact/view.html.twig', [
            'contact' => $contact
        ]);
    }
}
