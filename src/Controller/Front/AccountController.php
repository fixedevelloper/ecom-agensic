<?php


namespace App\Controller\Front;


use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    private EntityManagerInterface $doctrine;
    private SessionInterface $session;
    private CustomerRepository $customerRepository;

    /**
     * AccountController constructor.
     * @param EntityManagerInterface $doctrine
     * @param $session
     * @param CustomerRepository $customerRepository
     */
    public function __construct(EntityManagerInterface $doctrine,SessionInterface $session, CustomerRepository $customerRepository)
    {
        $this->doctrine = $doctrine;
        $this->session = $session;
        $this->customerRepository = $customerRepository;
    }
    /**
     * @Route("/account", name="accountpage")
     * @param Request $request
     * @return Response
     */
    public function account(Request $request): Response
    {
        return $this->render('Front/account/myaccount.html.twig', [
            'home'=>false
        ]);

    }
    /**
     * @Route("/myloginpage", name="loginpage")
     * @param Request $request
     * @return Response
     */
    public function loginpage(Request $request): Response
    {
        return $this->render('Front/account/loginpage.html.twig', [
            'home'=>false
        ]);

    }
    /**
     * @Route("/contact", name="contactpage")
     * @param Request $request
     * @return Response
     */
    public function contact(Request $request): Response
    {
        return $this->render('Front/account/contact.html.twig', [
            'home'=>false
        ]);

    }
}
