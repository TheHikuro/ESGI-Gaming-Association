<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route(name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
        ]);
    }

    #[Route('/users', name: 'users')]
    public function users(Request $request){
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('admin');
    }

    #[Route('/associations', name: 'associations')]
    public function associations(Request $request){
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('admin');
    }

    #[Route('/sections', name: 'sections')]
    public function sections(Request $request){
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('admin');
    }

    #[Route('/forum', name: 'forum')]
    public function forum(Request $request){
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            return new JsonResponse([
                'code' => 200,
            ]);
        }
        return $this->redirectToRoute('admin');
    }
}
