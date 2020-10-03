<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * return Response
     */

     //Affiche les 4 dernieres maison 
    public function index(PropertyRepository $propertyRepository) :Response
    {
        $properties = $propertyRepository->findLatest();
        //dd($properties);
        return $this->render('home/index.html.twig', compact('properties'));
    }
}
