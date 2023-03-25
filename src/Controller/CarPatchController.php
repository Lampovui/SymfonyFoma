<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Car;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarPatchController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/patchcar/{id}", methods={"PATCH"})
     */
    public function patch(Request $request, int $id): Response
    {
        $car = $this->entityManager->getRepository(Car::class)->find($id);

        if (!$car) {
            return $this->json(['error' => 'Car not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) {
            $car->setAuthor($data['name']);
        }

        if (isset($data['brand'])) {
            $car->setTitle($data['brand']);
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Car updated successfully']);
    }
}