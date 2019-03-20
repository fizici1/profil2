<?php

namespace App\Controller;
use App\Entity\Eleve;
use App\Repository\EleveRepository;
use App\Form\EleveType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;

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

    public function show(Eleve $eleve, Request $request, ObjectManager $em): Response
    {
      $form = $this->createForm(EleveType::class, $eleve);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
      }

      return $this->render('eleve/show.html.twig', [
        'current_menu' => 'eleves',
        'eleve'        => $eleve,
        'form'         => $form->createView()
      ]);
    }

    public function new(Request $request, ObjectManager $em)
    {
      $eleve = new Eleve();
      $form = $this->createForm(EleveType::class, $eleve);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($eleve);
        $em->flush();
        return $this->redirectToRoute('eleves');
      }

      return $this->render('eleve/new.html.twig', [
        'current_menu' => 'eleves',
        'eleve'        => $eleve,
        'form'         => $form->createView()
      ]);
    }

    public function delete(Eleve $eleve, Request $request, ObjectManager $em)
    {
      if ($this->isCsrfTokenValid('delete' . $eleve->getId(), $request->get('_token'))) {
            $em->remove($eleve);
            $em->flush();
        }
        return $this->redirectToRoute('eleves');
      }
}
 ?>
