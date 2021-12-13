<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users', name: 'users_')]
class UserController extends AdminBaseController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->redirectToRoute('admin_');
    }

    #[Route('/find', name: 'find', methods: 'GET')]
    public function findUser(Request $request){
        if($this->isValidRequest($request)){
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('users_');
    }

    #[Route('/update', name: 'update', methods: 'PATCH')]
    public function updateUser(Request $request){
        if($this->isValidRequest($request)){
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('users_');
    }

    #[Route('/delete', name: 'delete', methods: 'DELETE')]
    public function deleteUser(Request $request){
        if($this->isValidRequest($request)){
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('users_');
    }
}