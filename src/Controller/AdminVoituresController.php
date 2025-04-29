<?php

namespace App\Controller;

use App\Entity\Voitures;
use App\Form\VoituresType;
use App\Repository\VoituresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/voitures')]
class AdminVoituresController extends AbstractController
{
    #[Route('/', name: 'app_admin_voitures_index', methods: ['GET'])]
    public function index(VoituresRepository $voituresRepository): Response
    {
        return $this->render('admin_voitures/index.html.twig', [
            'voitures' => $voituresRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_voitures_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VoituresRepository $voituresRepository, SluggerInterface $slugger): Response
    {
        $voiture = new Voitures();
        $form = $this->createForm(VoituresType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            $imageFile2 = $form->get('image2')->getData();
            $imageFile3 = $form->get('image3')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/css/images/photoVoit',
                        $newFilename
                    );
                    
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $voiture->setImage($newFilename);
            }
            ///////////////////////////

            if ($imageFile2) {
                $originalFilename = pathinfo($imageFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile2->guessExtension();

                try {
                    $imageFile2->move(
                        $this->getParameter('kernel.project_dir') . '/public/css/images/photoVoit',
                        $newFilename
                    );
                    
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $voiture->setImage2($newFilename);
            }

            ///////////////////////////

            if ($imageFile3) {
                $originalFilename = pathinfo($imageFile3->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile3->guessExtension();

                try {
                    $imageFile3->move(
                        $this->getParameter('kernel.project_dir') . '/public/css/images/photoVoit',
                        $newFilename
                    );
                    
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $voiture->setImage3($newFilename);
            }

            $voituresRepository->add($voiture, true);

            return $this->redirectToRoute('app_admin_voitures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_voitures/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_voitures_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Voitures $voiture): Response
    {
        return $this->render('admin_voitures/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_voitures_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Voitures $voiture, VoituresRepository $voituresRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(VoituresType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/voitures',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $voiture->setImage($newFilename);
            }

            $voituresRepository->add($voiture, true);

            return $this->redirectToRoute('app_admin_voitures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_voitures/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_voitures_delete', methods: ['POST'])]
    public function delete(Request $request, Voitures $voiture, VoituresRepository $voituresRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getId(), $request->request->get('_token'))) {
            $voituresRepository->remove($voiture, true);
        }

        return $this->redirectToRoute('app_admin_voitures_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/etats', name: 'admin_voitures_etats')]
    public function countByEtat(VoituresRepository $voitureRepository): Response
    {
    $countByEtat = $voitureRepository->countByEtat();

    return $this->render('admin_voitures/etats.html.twig', [
        'countByEtat' => $countByEtat,
    ]);
}
}
