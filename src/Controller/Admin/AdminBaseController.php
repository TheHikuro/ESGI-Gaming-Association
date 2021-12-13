<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBaseController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    protected function isValidRequest(Request $request){
        return ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) ? true : false;
    }
}
