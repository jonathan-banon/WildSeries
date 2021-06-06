<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route ("/categories", name="category_")
 */

class CategoryController extends AbstractController
{
    /**
     * @Route ("/", name="index")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository
            ->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     *The controller for the category add form
     *
     *@Route("/new", name="new")
     *@return Response
     */
    public function new(Request $request):  Response
    {
        $category = new Category();
        // Create associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Create data from HTTP request
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('category_index');
        }
        return $this->render('category/new.html.twig', [
           "form" => $form->createView(),
        ]);
    }

    /**
     * @Route ("/show/{categoryName}", name="show")
     */
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $nbProgramByCategoryMax = 3;
        $category = $categoryRepository
            ->findOneBy(['name' => $categoryName]);
        if (!$category) {
            throw $this->createNotFoundException(
                '404 : Aucune catégorie ne correspond à ' . $categoryName
            );
        } else {
            $programs = $programRepository
                ->findBy(
                    ['category' => $category],
                    ['id' => 'DESC'],
                    $nbProgramByCategoryMax
                );
        }

        return $this->render('category/show.html.twig', [
            'programs' => $programs,
            'category' => $category,
        ]);
    }
}
