<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route("/products", name: "products")]
    public function showProducts(): Response
    {
        $products = ["Produit 1", "Produit 2", "Produit 3"];
        
        return $this->render("product/list.html.twig", [
            "message" => "Ici sera affichée la liste des produits",
            "products" => $products,
        ]);
    }
}
