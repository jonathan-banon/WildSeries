<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
