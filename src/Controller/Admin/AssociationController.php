<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/associations', name: 'associations_')]
class AssociationController extends AdminBaseController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->redirectToRoute('admin_');
    }

    #[Route('/find', name: 'find', methods: 'GET')]
    public function findAssociation(Request $request){
        if($this->isValidRequest($request)){
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('associations_');
    }

    #[Route('/update', name: 'update', methods: 'PATCH')]
    public function updateAssociation(Request $request){
        if($this->isValidRequest($request)){
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('associations_');
    }

    #[Route('/delete', name: 'delete', methods: 'DELETE')]
    public function deleteAssociation(Request $request){
        if($this->isValidRequest($request)){
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('associations_');
    }
}