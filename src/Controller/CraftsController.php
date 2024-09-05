<?php

namespace App\Controller;

use App\Entity\Crafts;
use App\Form\CraftsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/crafts')]
class CraftsController extends AbstractController
{
    #[Route('/', name: 'app_crafts_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $crafts = $entityManager
            ->getRepository(Crafts::class)
            ->findAll();

        return $this->render('crafts/index.html.twig', [
            'crafts' => $crafts,
        ]);
    }

    #[Route('/new', name: 'app_crafts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $craft = new Crafts();
        $form = $this->createForm(CraftsType::class, $craft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//Handling PHOTO UPLOAD
$pictureFile = $form->get('picture')->getData();
if ($pictureFile) {
    $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
    $safeFilename = $slugger->slug($originalFilename);
    $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();

    try {
        $pictureFile->move(
            $this->getParameter('pictures_directory'),
            $newFilename
        );
        $craft->setPicture($newFilename);
    } catch (FileException $e) {
       
    }
}
//Handling VIDEOUPLOAD

$videoFile = $form->get('video')->getData();
        if ($videoFile) {
            $originalFilename = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $videoFile->guessExtension();

            try {
                $videoFile->move(
                    $this->getParameter('videos_directory'),
                    $newFilename
                );
                $craft->setVideo($newFilename);
            } catch (FileException $e) {
                // Handle exception
            }
        }
            $entityManager->persist($craft);
            $entityManager->flush();

            return $this->redirectToRoute('app_crafts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crafts/new.html.twig', [
            'craft' => $craft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crafts_show', methods: ['GET'])]
    public function show(Crafts $craft): Response
    {
        return $this->render('crafts/show.html.twig', [
            'craft' => $craft,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_crafts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Crafts $craft, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CraftsType::class, $craft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                // Handle picture upload
                $pictureFile = $form->get('picture')->getData();
                if ($pictureFile) {
                    $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();
        
                    try {
                        $pictureFile->move(
                            $this->getParameter('pictures_directory'),
                            $newFilename
                        );
                        $craft->setPicture($newFilename);
                    } catch (FileException $e) {
                        // Handle exception
                    }
                }

                        // Handle Video upload
                        $videoFile = $form->get('video')->getData();
        if ($videoFile) {
            $originalFilename = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $videoFile->guessExtension();

            try {
                $videoFile->move(
                    $this->getParameter('videos_directory'),
                    $newFilename
                );
                $craft->setVideo($newFilename);
            } catch (FileException $e) {
                // Handle exception
            }
        }

            $entityManager->flush();

            return $this->redirectToRoute('app_crafts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crafts/edit.html.twig', [
            'craft' => $craft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_crafts_delete', methods: ['POST'])]
    public function delete(Request $request, Crafts $craft, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$craft->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($craft);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_crafts_index', [], Response::HTTP_SEE_OTHER);
    }
}
