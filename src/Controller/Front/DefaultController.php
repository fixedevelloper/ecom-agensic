<?php

namespace App\Controller\Front;


use App\Entity\Category;
use App\Repository\AttributeRepository;
use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use App\Repository\CustomerRepository;
use App\Repository\LineItemRepository;
use App\Repository\ProductRepository;
use App\Repository\ShopRepository;
use App\Service\EndpointService;
use App\Service\paiement\TransferzeroService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private ProductRepository $productRepository;
    private CustomerRepository $customerRepository;
    private CategoryRepository $categoryRepository;
    private AttributeRepository $attriburRepository;
    private ShopRepository $shopRepository;
    private EntityManagerInterface $doctrine;
    private $cartRepository;
    private $lineitemrepository;
    private $session;

    /**
     * StaticApiController constructor.
     * @param ShopRepository $shopRepository
     * @param EntityManagerInterface $entityManager
     * @param CartRepository $cartRepository
     * @param LineItemRepository $lineItemRepository
     * @param SessionInterface $session
     * @param ProductRepository $productRepository
     * @param CustomerRepository $customerRepository
     * @param CategoryRepository $categoryRepository
     * @param AttributeRepository $attriburRepository
     */
    public function __construct(ShopRepository $shopRepository,EntityManagerInterface $entityManager,CartRepository $cartRepository, LineItemRepository $lineItemRepository, SessionInterface $session,ProductRepository $productRepository, CustomerRepository $customerRepository,
                                CategoryRepository $categoryRepository, AttributeRepository $attriburRepository)
    {
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->categoryRepository = $categoryRepository;
        $this->attriburRepository = $attriburRepository;
        $this->cartRepository = $cartRepository;
        $this->lineitemrepository = $lineItemRepository;
        $this->shopRepository=$shopRepository;
        $this->doctrine=$entityManager;
        $this->session = $session;
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
            'categories'=>$categories,
            'home'=>true
        ]);

    }
    public function header_slider(Category $category): Response
    {
        $categories_=$this->categoryRepository->findBy([]);
        $categories=[];
        foreach ($categories_ as $category){

            $categories[]=[
                'name'=>$category->getName(),
                'id'=>$category->getId(),
                'slug'=>$category->getSlug(),
            ];
        }
        return $this->render('Front/_partials/header_slider.html.twig', [
            'subcategories'=>$categories
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
            'home'=>false
        ]);
    }
    public function productmodal(): Response
    {
        return $this->render('Front/home/productmodal.html.twig', [

        ]);
    }
    public function bestseller(): Response
    {
        $bestsellers_=$this->productRepository->findByBestseller(8);
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
    public function bestsellerhome(): Response
    {
        $bestsellers_=$this->productRepository->findByBestseller(8);
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
        return $this->render('Front/home/bestsellerhome.html.twig', [
            'products'=>$bestsellers
        ]);
    }
    public function categorielist(): Response
    {
        return $this->render('Front/home/categorielist.html.twig', [
            'categories'=>$this->categoryRepository->findBy([])
        ]);
    }
    public function categoriesearch(): Response
    {
        return $this->render('Front/home/categoriesearch.html.twig', [
            'categories'=>$this->categoryRepository->findBy([])
        ]);
    }
    public function featureproducts(): Response
    {
        $products_=$this->productRepository->findFeatureds(4);
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
        $products_=$this->productRepository->findNewArrivals(20);
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
    public function categoryproducts(): Response
    {
        $products_=$this->productRepository->findCategories(8);
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
        return $this->render('Front/home/categoryproducts.html.twig', [
            'products'=>$products
        ]);
    }
    public function popularproduct(): Response
    {
        $products_=$this->productRepository->findPopularproducts(8);
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
        }else{
            $products_=$this->productRepository->findAll();
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
                    'regularprice' => $product->getRegularPrice(),
                ];
            }
        }
        $categories=$this->categoryRepository->findAll();
        return $this->render('Front/home/productshoppage.html.twig', [
            'products'=>$products,
            'categories'=>$categories,
            'category'=>$categorie,
            'home'=>false
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
     * @Route("/shop/{slug}", name="shop_page")
     * @param Request $request
     * @return Response
     */
    public function shop_page(Request $request,$slug): Response
    {
        $shop=$this->shopRepository->findOneBy(['slug'=>$slug]);
        if (is_null($shop)){
            $this->redirectToRoute('home');
        }
        $products=[];
        $products_=$shop->getProducts();
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
                'regularprice' => $product->getRegularPrice(),
            ];
        }
        return $this->render('Front/home/shop_page.html.twig', [
            'products'=>$products,
            'shop'=>$shop,
            'home'=>false
        ]);
    }
    /**
     * @Route("/checkoutpage", name="checkoutpage")
     * @param Request $request
     * @return Response
     */
    public function checkoutpage(Request $request): Response
    {
        $cartId = $this->session->get('cart');
        if (is_null($cartId)){
            return $this->redirectToRoute('home');
        }
        $islogged=true;
        if (is_null($this->getUser())){

            $islogged=false;
            return $this->redirectToRoute('loginpage');
        }
        $customer=$this->customerRepository->findOneBy(['compte'=>$this->getUser()]);
        $cart = $this->cartRepository->find($cartId);
        $line_carts = [];
        $sumary = 0.0;
        foreach ($cart->getLineItems() as $lineItem) {
            $product=$lineItem->getProduct();
            $image = $product->getImages()[0];
            $sumary += $lineItem->getSubtotal();
            $line_carts[] = [
                'id' => $lineItem->getId(),
                'product_name' => $lineItem->getName(),
                'price' => $lineItem->getPrice(),
                'quantity' => $lineItem->getQuantity(),
                'image' => is_null($image)?" ":$image->getSrc(),
                'slug' => $product->getSlug()
            ];
        }
        return $this->render('Front/home/checkoutpage.html.twig', [
            'count_item' => count($line_carts),
            'summary' => $sumary,
            'shipping'=>0.0,
            'lines' => $line_carts,
            'home'=>false,
            'customer'=>$customer,
            'islogged'=>$islogged
        ]);
    }
}
