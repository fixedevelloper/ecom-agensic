<?php


namespace App\Controller\Front;


use App\Entity\Billing;
use App\Entity\Customer;
use App\Entity\Shipping;
use App\Entity\User;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    private EntityManagerInterface $doctrine;
    private SessionInterface $session;
    private CustomerRepository $customerRepository;
    private $passwordEncoder;
    /**
     * AccountController constructor.
     * @param EntityManagerInterface $doctrine
     * @param $session
     * @param CustomerRepository $customerRepository
     */
    public function __construct(EntityManagerInterface $doctrine,SessionInterface $session,UserPasswordHasherInterface $passwordEncoder,
                                CustomerRepository $customerRepository)
    {
        $this->doctrine = $doctrine;
        $this->session = $session;
        $this->customerRepository = $customerRepository;
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     * @Route("/account", name="accountpage")
     * @param Request $request
     * @return Response
     */
    public function account(Request $request): Response
    {
        if (is_null($this->getUser())){
            $this->redirectToRoute('loginpage');
        }
        $customer=$this->customerRepository->findOneBy(['compte'=>$this->getUser()]);

        return $this->render('Front/account/myaccount.html.twig', [
            'home'=>false,
            'customer'=>$customer
        ]);

    }
    public function billinginformation(Customer $customer,Request $request): Response
    {
        return $this->render('Front/account/billinginformation.html.twig', [
            'customer'=>$customer
        ]);
    }
    public function shippinginformation(Customer $customer,Request $request): Response
    {
        $shipping =$customer->getShipping();
        if ($request->getMethod()=="POST"){
            if (is_null($shipping)){
                $shipping=new Shipping();
                $this->doctrine->persist($shipping);
                $customer->setShipping($shipping);
            }
            $shipping->setAddress1($request->get('address'));
            $shipping->setEmail($request->get('email'));
            $shipping->setCity($request->get('city'));
            $shipping->setLastName($request->get('lastname'));
            $shipping->setFirstName($request->get('firstname'));
            $shipping->setCountry($request->get('country_name'));
            $shipping->setState($request->get('state'));
            $shipping->setPostcode($request->get('postal'));
            $shipping->setAddress2($request->get('address2'));
            $shipping->setCompany($request->get('company'));
            $this->doctrine->flush();
        }
        return $this->render('Front/account/shippinginformation.html.twig', [
            'customer'=>$customer
        ]);
    }
    /**
     * @Route("/myloginpage", name="loginpage", methods={"GET","POST"})
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function loginpage(Request $request,AuthenticationUtils $authenticationUtils): Response
    {
        $error=$authenticationUtils->getLastAuthenticationError();
        return $this->render('Front/account/loginpage.html.twig', [
            'home'=>false,
            'error'=>$error,
        ]);

    }
    /**
     * @Route("/registerpage", name="registerpage", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function registerpage(Request $request): Response
    {
        if ($request->getMethod()=="POST"){
            $user = new User();
            $user->setName($request->get('firstname').' '.$request->get('lastname'));
            $user->setEmail($request->get('email'));
            $plainPassword= $request->get('password');
            $user->setUsername($request->get('email'));
            $user->setPhone($request->get('phone'));
            $encodedPassword = $this->passwordEncoder->hashPassword($user, $plainPassword);
            $user->setPassword($encodedPassword);
            $user->setIsactivate(true);
            $user->setRoles(["ROLE_CUSTOMER"]);
            $this->doctrine->persist($user);
            $customer=new Customer();
            $billing=new Billing();
            $billing->setAddress1($request->get('address'));
            $billing->setEmail($request->get('email'));
            $billing->setCity($request->get('city'));
            $billing->setLastName($request->get('lastname'));
            $billing->setFirstName($request->get('firstname'));
            $billing->setCountry($request->get('country_name'));
            $billing->setState($request->get('state'));
            $billing->setPostcode($request->get('postal'));
            $billing->setAddress2($request->get('address2'));
            $billing->setCompany($request->get('company'));
            $this->doctrine->persist($billing);
            $customer->setBilling($billing);
            $customer->setCompte($user);
            $this->doctrine->persist($customer);
            $this->doctrine->flush();
            return $this->redirectToRoute('accountpage');
        }
        return $this->render('Front/account/registerpage.html.twig', [
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
