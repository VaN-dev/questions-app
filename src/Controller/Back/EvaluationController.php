<?php

namespace App\Controller\Back;

use App\Entity\Answer;
use App\Entity\Evaluation;
use App\Form\EvaluationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = $this->getDoctrine()->getRepository('App:Evaluation')->findAll();

        return $this->render('back/evaluation/index.html.twig', [
            'evaluations' => $evaluations,
        ]);
    }

    public function create(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $evaluation = new Evaluation();
        $form = $this->createForm(EvaluationType::class, $evaluation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evaluation);
            $entityManager->flush();

            return $this->redirectToRoute('evaluation');
        }


        return $this->render('back/evaluation/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(EvaluationType::class, $evaluation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evaluation);
            $entityManager->flush();

            return $this->redirectToRoute('evaluation');
        }


        return $this->render('back/evaluation/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request, Evaluation $evaluation)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($evaluation);
        $entityManager->flush();

        return $this->redirectToRoute('evaluation');
    }

    public function print(Evaluation $evaluation)
    {
        return $this->render('back/evaluation/print.html.twig', [
            'evaluation' => $evaluation,
        ]);
    }
}