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
        $query = $postRepository->createQueryBuilder('i')
            ->orderBy('i.id', 'DESC')
            ->getQuery();

        $posts = $paginator->paginate(
            $query, // Query da paginare
            $request->query->getInt('page', 1), // Parametro opzionale per il numero di pagina, predefinito a 1
            10 // Numero di elementi per pagina
        );

        return $this->render('homepage/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
