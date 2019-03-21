<?php

namespace App\Controller;
use App\Entity\Eleve;
use App\Repository\EleveRepository;
use App\Form\EleveType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EleveController extends AbstractController
{


    public function index(EleveRepository $repository,  Request $request): Response
    {
      $query = $repository->findAll();
      foreach ($query as $value) {
        $classes[$value->getClasse()] = $value->getClasse();
      }
      $listClasses = array_unique($classes);
      $eleve = new Eleve();
      $form = $this->createFormBuilder($eleve)
        ->add('classe', ChoiceType::class, [ 'choices' => $listClasses])
        ->add('filter', SubmitType::class, ['label' => 'Filtrer'])
        ->getForm();
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $classe = $form->getData()->getClasse();
        $eleves = $repository->findBy(
          ['classe'=> $classe],
          ['login' => 'ASC']
        );
      } else {
        $eleves = $repository->findBy(
          [],
          ['login' => 'ASC']
        );
      }


      return $this->render('eleve/index.html.twig', [
        'current_menu' => 'eleves',
        'eleves'       => $eleves,
        'form'         => $form->createView()
      ]);
    }

    public function show(Eleve $eleve): Response
    {
      return $this->render('eleve/show.html.twig', [
        'current_menu' => 'eleves',
        'eleve'        => $eleve
      ]);
    }

    public function edit(Eleve $eleve, Request $request, ObjectManager $em): Response
    {
      $form = $this->createForm(EleveType::class, $eleve);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();
        return $this->redirectToRoute('eleves');
      }

      return $this->render('eleve/edit.html.twig', [
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
