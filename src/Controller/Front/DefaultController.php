<?php

namespace App\Controller\Front;


use App\Repository\AttributeRepository;
use App\Repository\CategoryRepository;
use App\Repository\CustomerRepository;
use App\Repository\ProductRepository;
use App\Service\EndpointService;
use App\Service\paiement\TransferzeroService;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\DataTableFactory;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private ProductRepository $productRepository;
    private CustomerRepository $customerRepository;
    private CategoryRepository $categoryRepository;
    private AttributeRepository $attriburRepository;
    private EntityManagerInterface $doctrine;

    /**
     * StaticApiController constructor.
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $productRepository
     * @param CustomerRepository $customerRepository
     * @param CategoryRepository $categoryRepository
     * @param AttributeRepository $attriburRepository
     */
    public function __construct(EntityManagerInterface $entityManager,ProductRepository $productRepository, CustomerRepository $customerRepository,
                                CategoryRepository $categoryRepository, AttributeRepository $attriburRepository)
    {
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->categoryRepository = $categoryRepository;
        $this->attriburRepository = $attriburRepository;
        $this->doctrine=$entityManager;
    }

    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $products=$this->productRepository->findAll();
        $categories=$this->categoryRepository->findAll();
        return $this->render('Front/home/homepage.html.twig', [
            'products'=>$products,
            'categories'=>$categories
        ]);

    }
    /**
     * @Route("/product_detail/{slug}", name="product_detail", options={"expose"=true})
     * @param Request $request
     * @return Response
     */
    public function product_detail(Request $request,$slug): Response
    {
        $product=$this->productRepository->findOneBy(['slug'=>$slug]);

        $image = $product->getImages()[0];
        $categories=$this->categoryRepository->findAll();

        return $this->render('Front/home/productdetailpage.html.twig', [
            'categories'=>$categories,
            'product'=>$product,
            'image'=>is_null($image) ? "" :  $image->getSrc(),
        ]);
    }
    public function bestseller(): Response
    {
        $bestsellers_=$this->productRepository->findBy([]);
        $bestsellers=[];
        foreach ($bestsellers_ as $product){
            $image = $product->getImages()[0];
            $bestsellers[]=[
                'name'=>$product->getName(),
                'id'=>$product->getId(),
                'slug'=>$product->getSlug(),
                'price' => $product->getPrice(),
                'managestock' => $product->getId(),
                'width' => $product->getWidth(),
                'stockquantity' => $product->getStockQuantity(),
                'weight' => $product->getWeight(),
                'length' => $product->getLength(),
                'height' => $product->getHeight(),
                'image' => is_null($image) ? "" :  $image->getSrc(),
                'type' => $product->getType(),
                'saleprice' => $product->getSalePrice(),
                'images'=>$product->getImages(),
                'regularprice' => $product->getRegularPrice(),
            ];
        }
        return $this->render('Front/home/bestseller.html.twig', [
            'bestsellers'=>$bestsellers
        ]);
    }
    public function categorielist(): Response
    {
        return $this->render('Front/home/categorielist.html.twig', [
            'categories'=>$this->categoryRepository->findBy([])
        ]);
    }
    public function featureproducts(): Response
    {
        $products_=$this->productRepository->findBy([]);
        $products=[];
        foreach ($products_ as $product){
            $image = $product->getImages()[0];
            $products[]=[
                'name'=>$product->getName(),
                'id'=>$product->getId(),
                'slug'=>$product->getSlug(),
                'price' => $product->getPrice(),
                'managestock' => $product->getId(),
                'width' => $product->getWidth(),
                'stockquantity' => $product->getStockQuantity(),
                'weight' => $product->getWeight(),
                'length' => $product->getLength(),
                'height' => $product->getHeight(),
                'image' => is_null($image) ? "" :  $image->getSrc(),
                'type' => $product->getType(),
                'saleprice' => $product->getSalePrice(),
                'images'=>$product->getImages(),
                'regularprice' => $product->getRegularPrice(),
            ];
        }
        return $this->render('Front/home/featureproducts.html.twig', [
            'products'=>$products
        ]);
    }
    public function newarrivalsproducts(): Response
    {
        $products_=$this->productRepository->findBy([]);
        $products=[];
        foreach ($products_ as $product){
            $image = $product->getImages()[0];
            $products[]=[
                'name'=>$product->getName(),
                'id'=>$product->getId(),
                'slug'=>$product->getSlug(),
                'price' => $product->getPrice(),
                'managestock' => $product->getId(),
                'width' => $product->getWidth(),
                'stockquantity' => $product->getStockQuantity(),
                'weight' => $product->getWeight(),
                'length' => $product->getLength(),
                'height' => $product->getHeight(),
                'image' => is_null($image) ? "" :  $image->getSrc(),
                'type' => $product->getType(),
                'saleprice' => $product->getSalePrice(),
                'images'=>$product->getImages(),
                'regularprice' => $product->getRegularPrice(),
            ];
        }
        return $this->render('Front/home/newarrivalsproducts.html.twig', [
            'products'=>$products
        ]);
    }
    public function popularproduct(): Response
    {
        $products_=$this->productRepository->findBy([]);
        $products=[];
        foreach ($products_ as $product){
            $image = $product->getImages()[0];
            $products[]=[
                'name'=>$product->getName(),
                'id'=>$product->getId(),
                'slug'=>$product->getSlug(),
                'price' => $product->getPrice(),
                'managestock' => $product->getId(),
                'width' => $product->getWidth(),
                'stockquantity' => $product->getStockQuantity(),
                'weight' => $product->getWeight(),
                'length' => $product->getLength(),
                'height' => $product->getHeight(),
                'image' => is_null($image) ? "" :  $image->getSrc(),
                'type' => $product->getType(),
                'saleprice' => $product->getSalePrice(),
                'images'=>$product->getImages(),
                'regularprice' => $product->getRegularPrice(),
            ];
        }
        return $this->render('Front/home/popularproduct.html.twig', [
            'products'=>$products
        ]);
    }
    /**
     * @Route("/product_shop", name="product_shop")
     * @param Request $request
     * @return Response
     */
    public function product_shop(Request $request): Response
    {
        $products=[];
        $categorie=null;
        if (!is_null($request->get('t'))){
            $categorie=$this->categoryRepository->findOneBy(['slug'=>$request->get('t')]);
            foreach ($categorie->getProducts() as $product){
                $image = $product->getImages()[0];
                $products[]=[
                  'name'=>$product->getName(),
                    'id'=>$product->getId(),
                    'slug'=>$product->getSlug(),
                    'price' => $product->getPrice(),
                    'managestock' => $product->getId(),
                    'width' => $product->getWidth(),
                    'stockquantity' => $product->getStockQuantity(),
                    'weight' => $product->getWeight(),
                    'length' => $product->getLength(),
                    'height' => $product->getHeight(),
                    'image' => is_null($image) ? "" :  $image->getSrc(),
                    'type' => $product->getType(),
                    'saleprice' => $product->getSalePrice(),
                    'regularprice' => $product->getRegularPrice(),
                ];
            }
        }
        $categories=$this->categoryRepository->findAll();
        return $this->render('Front/home/productshoppage.html.twig', [
            'products'=>$products,
            'categories'=>$categories,
            'category'=>$categorie,
        ]);
    }
    /**
     * @Route("/product_shopingcart", name="product_shopingcart")
     * @param Request $request
     * @return Response
     */
    public function product_shopingcart(Request $request): Response
    {
        return $this->render('Front/home/product_shopingcartpage.html.twig', [
        ]);
    }
    /**
     * @Route("/checkoutpage", name="checkoutpage")
     * @param Request $request
     * @return Response
     */
    public function checkoutpage(Request $request): Response
    {
        return $this->render('Front/home/checkoutpage.html.twig', [
        ]);
    }
}
