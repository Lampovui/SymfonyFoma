<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Car;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarGetCollectionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/getcollectioncars", methods={"GET"})
     */
    public function getCollection(Request $request): Response
    {
        $cars = $this->entityManager->getRepository(Car::class)->findAll();

        $data = [];
        foreach ($cars as $car) {
            $data[] = [
                'id' => $car->getId(),
                'name' => $car->getName(),
                'brand' => $car->getBrand(),
            ];
        }

        return $this->json($data);
    }

}