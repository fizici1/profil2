<?php

namespace App\Controller;
use App\Entity\Eleve;
use App\Repository\EleveRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EleveController extends AbstractController
{


    public function index(EleveRepository $repository): Response
    {
      $eleves = $repository->findAll();

      return $this->render('eleve/index.html.twig', [
        'current_menu' => 'eleves',
        'eleves'       => $eleves
      ]);
    }

    public function show(EleveRepository $repository, Eleve $eleve): Response
    {
      return $this->render('eleve/show.html.twig', [
        'current_menu' => 'eleves',
        'eleve'        => $eleve
      ]);
    }
}
 ?>
