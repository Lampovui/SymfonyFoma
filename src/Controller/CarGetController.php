<?php

// Namespace Class Controller
namespace App\Controller;

// Import Classes
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Car;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Class Controller
class CarGetController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/getcar/{id}", methods={"GET"})
     */
    public function getItem(int $id): Response
    {
        // Get Data
        $car = $this->entityManager->getRepository(Car::class)->find($id);

        if (!$car) {
            throw $this->createNotFoundException('Car not found');
        }
        // arr
        $data = [
            'id' => $car->getId(),
            'name' => $car->getName(),
            'brand' => $car->getBrand(),
        ];

        return $this->json($data);
    }
}