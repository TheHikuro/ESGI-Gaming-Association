<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sections', name: 'sections_')]
class SectionController extends AdminBaseController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->redirectToRoute('admin_');
    }

    #[Route('/find', name: 'find', methods: 'GET')]
    public function findSection(Request $request){
        if($this->isValidRequest($request)){
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('sections_');
    }

    #[Route('/add', name: 'add', methods: 'POST')]
    public function addSection(Request $request){
        if($this->isValidRequest($request)){
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('sections_');
    }

    #[Route('/update', name: 'update', methods: 'PATCH')]
    public function updateSection(Request $request){
        if($this->isValidRequest($request)){
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('sections_');
    }

    #[Route('/delete', name: 'delete', methods: 'DELETE')]
    public function deleteSection(Request $request){
        if($this->isValidRequest($request)){
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('sections_');
    }
}