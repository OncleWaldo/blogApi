<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ArticleController
{
    /**
     * @Route("/articles", name="articles", methods={"GET"})
     */
    public function index(ArticleRepository $ArticleRepository)
    {   
        return new JsonResponse(["data" => $ArticleRepository->findAll()]);
    }

    /**
     * @Route("/articles/new", name="articles_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $EntityManager)
    {   

        $categorieId = $request->request->get("categorieId");
        $article = new Article();
        $categorie = new Categorie();
        $categorie = $EntityManager->getRepository(Categorie::class)->find((int) $categorieId);
        $article->setName($request->request->get("name"));
        $article->setCategorie($categorie);
        $article->setContent($request->request->get("name"));
        $article->setCreatedAt(new \DateTime() );
        $EntityManager->persist($article);
        $EntityManager->flush();
        return new JsonResponse(["data" => $article]);
    }
}