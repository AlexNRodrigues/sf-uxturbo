<?php

namespace App\Controller\Admin;

use App\Entity\Posts;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/admin/post', name: 'admin_post')]
class PostController extends AbstractController
{

    #[Route('/', name: '_index', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('admin/post/index.html.twig', []);
    }

    #[Route('/new', name: '_new', methods:['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, new Posts());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            // dd($post);

            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($post->getTitle());

            $post->setSlug($slug);
            $post->setLikes(0);
            $post->setDislike(0);
            $post->setViews(0);
            $post->setAuthor($this->getUser());
            $post->setPublicationAt(new \DateTimeImmutable());

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('admin_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/post/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/view/{slug}', name:'_view', methods:['GET'])]
    public function view(Posts $post): Response
    {
        return $this->render('admin/post/view.html.twig', [
            'post' => $post
        ]);
    }

    #[Route('/edit/{slug}', name:'_edit', methods:['GET', 'POST'])]
    public function edit(Posts $post, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($post->getTitle());

            if($post->getSlug() != $slug) {
                $post->setSlug($slug);
            }
            $entityManager->flush();

            return $this->redirectToRoute('admin_post_view', ['slug' => $post->getSlug()]);
        }

        return $this->render('admin/post/edit.html.twig', [
            'form' => $form,
            'post' => $post
        ]);
    }
}
