<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
    /**ETAPE 1 j'injecte le PropertyRepository */

    private $propertyRepository;
    private $em;

    public function __construct(PropertyRepository $propertyRepository, EntityManagerInterface $em)
    {
        $this->propertyRepository = $propertyRepository;
        $this->em = $em;
    }


    /**
     * @Route("/admin", name="admin_property.index")
     */
    public function index()
    {
        //ETAPE 2 Je récupère toutes les maison (properties)
        $properties = $this->propertyRepository->findAll();

        return $this->render('admin_property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/property/create", name="admin_property.create")
     */
    public function create(Request $request)
    {
        //On apl un nvl Object de l'entity Property
        $property = new Property();


        //Etape 3 on va utiliser les FormBuilder qui va etre basé sur l'entity Property
        $form = $this->createForm(PropertyType::class, $property);
        //S'occupe de la methode POST
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //On persist l'object Property dans la DB
            $this->em->persist($property);
            //Utilise l'EntityManager pour enregistrer la request POST ds la DB
            $this->em->flush();
            $this->addFlash('success', 'Created successfuly');
            return $this->redirectToRoute('admin_property.index');
        }
        return $this->render('admin_property/create.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin_property.edit", methods="GET|POST")
     */
    public function edit(Property $property, Request $request)
    {
        //Etape 3 on va utiliser les FormBuilder qui va etre basé sur l'entity Property
        $form = $this->createForm(PropertyType::class, $property);
        //S'occupe de la methode POST
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //Utilise l'EntityManager pour enregistrer la request POST ds la DB
            $this->em->flush();
            $this->addFlash('success', 'Edited successfuly');
            return $this->redirectToRoute('admin_property.index');
        }
        return $this->render('admin_property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/delete/{id}", name="admin_property.delete", methods="DELETE")
     */
    public function delete(Property $property, Request $request)
    {

        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            //$property va implicitement chercher le bon id du bien a delete
            //dd('Deleted man');
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Deleted successfuly');
        }

        return $this->redirectToRoute('admin_property.index');
    }
}
