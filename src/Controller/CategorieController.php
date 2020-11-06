<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieRepository;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;



class CategorieController
{
    /**
     * @Route("/categories", name="categories", methods={"GET"})
     */
    public function categories(CategorieRepository $CategorieRepository, XmlEncoder $XmlEncoder, JsonEncoder $JsonEncoder, ObjectNormalizer $ObjectNormalizer, Serializer $Serializer )
    {   
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);


        $jsonContent = $serializer->serialize($data, 'json');
        return new JsonResponse(["data" => $CategorieRepository->findAll()]);
    }
    /**
     * @Route("/categories/new", name="categories_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $EntityManager)
    {   
        $categorie = new Categorie();
        $categorie->setName($request->request->get("name"));
        $EntityManager->persist($categorie);
        $EntityManager->flush();
        return new JsonResponse(["data" => $categorie]);
    }
}