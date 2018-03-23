<?php

namespace App\Controller\Back;

use App\Entity\Question;
use App\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = $this->getDoctrine()->getRepository('App:Question')->findAll();

        return $this->render('back/question/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    public function create(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $entityManager->persist($question);
             $entityManager->flush();

            return $this->redirectToRoute('question');
        }


        return $this->render('back/question/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('question');
        }


        return $this->render('back/question/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request, Question $question)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($question);
        $entityManager->flush();

        return $this->redirectToRoute('question');
    }
}
