<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    #[Route('/homepage', name: 'app_homepage')]
    public function index(PostRepository $postRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $viewMode = $request->query->get('view', 'table');
        $searchTerm = $request->query->get('search');

        // Utilizza una condizione per determinare quale query utilizzare
        if ($searchTerm) {
            // Se è presente un termine di ricerca, crea una query con il filtro
            $query = $postRepository->createQueryBuilder('i')
                ->where('i.title LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%')
                ->orderBy('i.id')
                ->getQuery();
        } else {
            // Altrimenti, utilizza la query senza filtri
            $query = $postRepository->createQueryBuilder('i')
                ->orderBy('i.id')
                ->getQuery();
        }

        $posts = $paginator->paginate(
            $query, // Query da paginare
            $request->query->getInt('page', 1), // Parametro opzionale per il numero di pagina, predefinito a 1
            10 // Numero di elementi per pagina
        );

        return $this->render('homepage/index.html.twig', [
            'posts' => $posts,
            'viewMode' => $viewMode
        ]);
    }

    #[Route('/random_images', name: 'random_images')]
    public function showRandomImages(PostRepository $postRepository): Response
    {
        $randomImages = $postRepository->getRandomImages(10); // Sostituisci con il tuo metodo per ottenere immagini random

        return $this->render('homepage/random_images.html.twig', [
            'randomImages' => $randomImages,
        ]);
    }
}
