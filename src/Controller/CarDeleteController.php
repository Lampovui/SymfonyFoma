<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Car;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarDeleteController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/deletecar/{id}", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        // Search
        $car = $this->entityManager->getRepository(Car::class)->find($id);

        if (!$car) {
            throw $this->createNotFoundException('Car not found');
        }

        $this->entityManager->remove($car);
        $this->entityManager->flush();

        return $this->json(['message' => 'Car deleted']);
    }
}