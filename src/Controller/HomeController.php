<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
  public function index() : Response
  {
    return $this->render('pages/home.html.twig', [
      'current_menu' => 'home'
    ]);
  }
}


 ?>
