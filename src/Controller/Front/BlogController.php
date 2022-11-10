<?php


namespace App\Controller\Front;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController
{

    public function homeblog(): Response
    {

        return $this->render('Front/blog/homeblog.html.twig', [
            'blogs'=>[]
        ]);
    }
}
