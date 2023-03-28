<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Car;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarPostController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/postcar", methods={"POST"})
     */
    public function post(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $car = new Car();
        $car->setName($data['name']);
        $car->setBrand($data['brand']);

        $this->entityManager->persist($car);

        $this->entityManager->flush();

        return $this->json(['id' => $car->getId()]);
    }

}