<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Car;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarPutController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/updatecar/{id}", methods={"PUT"})
     */
    public function put(Request $request, $id): Response
    {
        $car = $this->entityManager->getRepository(Car::class)->find($id);

        if (!$car) {
            throw $this->createNotFoundException('No car found for id ' . $id);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) {
            $car->setAuthor($data['name']);
        }

        if (isset($data['brand'])) {
            $car->setTitle($data['brand']);
        }

        $this->entityManager->flush();

        return $this->json(['id' => $car->getId()]);
    }

}