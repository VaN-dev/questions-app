<?php

namespace App\Controller\Back;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = $this->getDoctrine()->getRepository('App:Category')->findAll();

        return $this->render('back/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    public function create(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $entityManager->persist($category);
             $entityManager->flush();

            return $this->redirectToRoute('category');
        }


        return $this->render('back/category/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category');
        }


        return $this->render('back/category/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request, Category $category)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('category');
    }
}
