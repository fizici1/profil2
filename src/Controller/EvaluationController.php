<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EvaluationController extends AbstractController
{
  public function index() : Response
  {
    return $this->render('evaluation/index.html.twig', [
      'current_menu' => 'evaluations'
    ]);
  }
}


 ?>
