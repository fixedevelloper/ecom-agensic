<?php


namespace App\Controller\Admin;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends BaseAdminController
{
    /**
     * @Route("/dashboard/", name="staticdashboard")
     * @param Request $request
     * @return Response
     */
    public function dashboard(Request $request): Response
    {
        return $this->render('Admin/static/dashboard.html.twig', [

        ]);
    }
}
