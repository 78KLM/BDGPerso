<?php
namespace App\Controller;
use App\Entity\Voitures;
use App\Repository\VoituresRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

class VoituresController extends AbstractController
{
    #[Route('/voitures', name: 'app_voitures')]
    public function index(Request $request, VoituresRepository $voitureRepository, PaginatorInterface $paginator): Response
    {
        // Récupérer les filtres depuis la requête
        $filters = [
            'carburant' => $request->query->get('carburant'),
            'annee' => $request->query->get('annee'),
            'etat' => $request->query->get('etat'),
        ];
    
        // Pagination
        $page = $request->query->getInt('page', 1);
        $limit = 8; // Nombre d'éléments par page
    
        // Récupérer les voitures filtrées et paginées
        $voitures = $voitureRepository->findPaginatedAndFiltered($page, $limit, $filters);
    
        // Calculer le nombre total de pages
        $totalVoitures = $voitureRepository->countFiltered($filters);
        $totalPages = ceil($totalVoitures / $limit);
    
        return $this->render('voitures/index.html.twig', [
            'voitures' => $voitures,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'limit' => $limit,
        ]);
    }

    #[Route('/detailVoiture/{id}', name: 'detailVoit')]
    public function details(Voitures $voiture)
    {
        // Rendu du template avec les données des voitures
        return $this->render('voitures/detailVoiture.html.twig', [
            'voiture' => $voiture
        ]);
    }

    
}


