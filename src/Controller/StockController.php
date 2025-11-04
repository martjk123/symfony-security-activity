<?php

// src/Controller/StockController.php
namespace App\Controller;

use App\Entity\Stock;
use App\Form\StockType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockController extends AbstractController
{
    #[Route('/stock/add', name: 'app_stock_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $stock = new Stock();
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($stock);
            $em->flush();

            $this->addFlash('success', 'Stock added successfully!');
            return $this->redirectToRoute('app_stock_add');
        }

        return $this->render('stock/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
