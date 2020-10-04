<?php

namespace App\Controller;

use App\Entity\Property;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * ETAPE 0 Créer un objet dans la DB via sont Entity 
     * $property = new Property();
        *$property->setTitle('First House')
        *    ->setPrice(300000)
        *    ->setRooms(5)
        *    ->setBedrooms(3)
        *    ->setDescription('B T H')
        *    ->setSurface(60)
        *    ->setFloor(2)
        *    ->setHeat(1)
        *    ->setCity('NEW YORK')
        *    ->setAdress('Greenfiel Park')
        *    ->setPostalCode(10000);

        *    $em = $this->getDoctrine()->getManager();
        *    $em->persist($property);
        *    $em->flush();
    */

    /**ETAPE 1 Injection de Dépendance des données via PropertyRepository dans le constructeur*/

    private $propertyRepository;
    private $em;

    public function __construct(PropertyRepository $propertyRepository, EntityManagerInterface $em)
    {
       $this->propertyRepository = $propertyRepository;
       $this->em = $em;
    }
        

    /**ETAPE 2 RECUPERER LES DONNÉES DANS LA DB VIA L'OBJET REPOSITORY INJECTER DANS LE CONSTRUCT OU METHODE SELON PERTINANCE */

    /**
     * @Route("/properties", name="property.index")
     */
    public function index(PaginatorInterface $paginator, Request $request) :Response
    {
        /*Dans ce cas ci je récupère les maison non vendu en me servant de findAllUnsoldHomeQuery() dans PropertyRepository*/
        $properties = $paginator->paginate($this->propertyRepository->findAllUnsoldHomeQuery(),
        $request->query->getInt('page', 1), 12);
        

        /*Détécte le changement d'état si je vend la maison par exemple*/
        $this->em->flush();

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties
        ]);
    }

    /**ETAPE 3 Montrer le bien Selectioné avec slug et id */
    /**
     * @Route("/properties/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug): Response //$property = $this->propertyRepository->find($id); Ce fait dans la méhode show grace a l'Injection
    {
        
        if($property->getSlug() !== $slug){
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties',
        ]);
    }
}
