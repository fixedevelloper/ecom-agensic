<?php

namespace App\Controller\Front;

use App\Entity\Billing;
use App\Entity\Cart;
use App\Entity\Customer;
use App\Entity\LineItem;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ShopOrder;
use App\Entity\ShopOrderLine;
use App\Entity\User;
use App\Repository\CartRepository;
use App\Repository\CustomerRepository;
use App\Repository\LineItemRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CartController extends AbstractController
{


    private SessionInterface $session;
    private ProductRepository $productRepository;
    private CartRepository $cartRepository;
    private LineItemRepository $lineitemrepository;
    private CustomerRepository $customerRepository;
    private OrderRepository $orderRepository;
    private EntityManagerInterface $doctrine;

    public function __construct(OrderRepository $orderRepository,EntityManagerInterface $entityManager, ProductRepository $productRepository,CustomerRepository $customerRepository,
                                CartRepository $cartRepository, LineItemRepository $lineItemRepository, SessionInterface $session)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
        $this->lineitemrepository = $lineItemRepository;
        $this->customerRepository=$customerRepository;
        $this->orderRepository=$orderRepository;
        $this->doctrine = $entityManager;
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('Front/cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    /**
     * @Route("/successpage/{keyorder}", name="app_cart_successpage", options={"expose"=true})
     * @param $keyorder
     * @return Response
     */
    public function successpage($keyorder): Response
    {
        //il faut recuperer le denier
        $order=$this->orderRepository->findOneBy(['number'=>$keyorder]);
        return $this->render('Front/cart/successpage.html.twig', [
          'order'=>$order,
            'home'=>false
        ]);
    }
    public function cart(): Response
    {
        $cartId = $this->session->get('cart');
        if (is_null($cartId)) {
            return $this->render('Front/cart/cart.html.twig', [
                'count_item' => 0,
                'summary' => 0.0,
                'lines' => [],
                'home'=>false
            ]);
        }
        $cart = $this->cartRepository->find($cartId);
        $line_carts = [];
        $sumary = 0.0;
        foreach ($cart->getLineItems() as $lineItem) {
            $product=$lineItem->getProduct();
            $image = $product->getImages()[0];
            $sumary += $lineItem->getSubtotal();
            $line_carts[] = [
                'product_id' => $product->getId(),
                'id' => $lineItem->getId(),
                'product_name' => $lineItem->getName(),
                'price' => $lineItem->getPrice(),
                'quantity' => $lineItem->getQuantity(),
                'image' => is_null($image)?" ":$image->getSrc(),
                'slug' => $product->getSlug()
            ];
        }
        return $this->render('Front/cart/cart.html.twig', [
            'count_item' => count($line_carts),
            'cart'=>$cartId,
            'summary' => $sumary,
            'lines' => $line_carts,
            'home'=>false
        ]);
    }

    /**
     * @Route("/cart.json", name="cart_json", methods={"GET"})
     */
    public function cartJson()
    {
        $cartId = $this->session->get('cart');
        $cart = $cartId ? $this->cartRepository->find($cartId) : new Cart();
        //get the last product
        $addedProduct = $cart->getLineItems()[count($cart->getLineItems()) - 1]
            ? $cart->getLineItems()[count($cart->getLineItems()) - 1]->getProduct()
            : new Cart();
        return new JsonResponse([
            'addedProduct' => [
                'name' => $addedProduct->getName(),
                'price' => $addedProduct->getPrice(),
                'pictureUrl' => $addedProduct->getPictureUrl()
            ],
            'newTotalProducts' => count($cart->getLineItems()),
            'newTotal' => $cart->getTotal()
        ]);
    }

    /**
     * @Route("user/{id}/cart", name="get_cart", methods={"GET"})
     */
    public function getCartUser($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Cart::class);
        $cart = //$repository->findAll();
            $repository->find(8);

        return new JsonResponse([
            'result' => $cart,
        ]);
    }

    /**
     * @Route("/cart/show", name="show_cart", options={"expose"=true})
     */
    public function showCart()
    {
        $cartId = $this->session->get('cart');

        $cart = $cartId ? $this->cartRepository->find($cartId) : new Cart();
        $totals=0.0;
        $line_carts = [];
        foreach ($cart->getLineItems() as $lineItem) {
            $product=$lineItem->getProduct();
            $image = $product->getImages()[0];
            $subtotal=$lineItem->getQuantity()*$lineItem->getPrice();
            $line_carts[] = [
                'product_id' => $product->getId(),
                'product_name' => $lineItem->getName(),
                'product_shortdescription' => $product->getShortDescription(),
                'price' => $lineItem->getPrice(),
                'quantity' => $lineItem->getQuantity(),
                'subtotal'=>$subtotal,
                'image' => $image->getSrc(),
                'slug' => $product->getSlug()
            ];
            $totals+=$subtotal;
        }
        return $this->render('Front/cart/view.html.twig', [
            'cart' => $cart,
            'linecarts' => $line_carts,
            'total'=>$totals,
            'home'=>false,
        ]);

        //return $this->partial($session, true);
    }


    /**
     * Checkout
     *
     * @Route("/cart/checkout", name="checkout_cart", methods={"GET","POST"})
     */
    public function checkout(Request $request)
    {
        $cartId = $this->session->get('cart');
        $cart = $this->cartRepository->find($cartId);
/*        if (is_null($this->getUser())){
            $user=new User();
            $user->setEmail($request->get('email'));
            $user->setEmail($request->get('email'));
            $billing=new Billing();
            $this->doctrine->persist($billing);
            $customer=new Customer();
            $customer->setCompte($user);
        }*/
        $customer=$this->customerRepository->find($request->get('customer'));
        $order=new Order();
        $order->setShipping($customer->getShipping());
        $order->setBilling($customer->getBilling());
        $this->doctrine->persist($order);
        $total=0.0;
        foreach ($cart->getLineItems() as $lineItem){
            $total+=$lineItem->getSubtotal();
        }
        $products=array_map(function ($item){
            return $item->getProduct();
        }, (array)$cart->getLineItems()->getValues());
        /// on recupere les vendeurs dans le panier
        $shops=array_map(function ($item){
            return $item->getProduct()->getShop();
        }, (array)$cart->getLineItems()->getValues());
        /// on fait une recherche sur chaque vendeur
        foreach ($shops as $shop){
            $orderSeller=new ShopOrder();
            $orderSeller->setShop($shop);
            $this->doctrine->persist($orderSeller);
            $items=array_filter($cart->getLineItems()->getValues(),function ($item)use ($shop){
                $bool=false;
                if ($item->getProduct()->getShop()==$shop){
                    $bool= true;
                }
                return $bool;
            });
            $total=0.0;
            foreach ($items as $lineItem){
                $shopOrderLine=new ShopOrderLine();
                $shopOrderLine->setLineorder($lineItem);
                $orderSeller->addShoporderliine($shopOrderLine);
                $total+=$lineItem->getSubtotal();
                $this->doctrine->persist($shopOrderLine);
            }
            $orderSeller->setTotalTax(0.0);
            $orderSeller->setTotal($total);
            $orderSeller->setPricesIncludeTax(0.0);
            $orderSeller->setDiscountTotal(0.0);
            $orderSeller->setDiscountTax(0.0);
            $orderSeller->setParentOrder($order);
            $orderSeller->setStatus(Order::PENDING);
        }
        $order->setPaymentMethod($request->get('paymentmethod'));
        $order->setPaymentMethodTitle($request->get('paymentmethod'));
        $order->setCurrency('USD');
        $order->setCustomerId($customer->getId());
        $order->setTotal($total);
        $order->setCartHash('');
        $order->setCartTax(null);
        $order->setCouponLines([]);
        $order->setCustomerIpAddress('');
        $order->setCustomerNote('');
        $order->setDiscountTax(null);
        $order->setDiscountTotal(null);
        $order->setFeeLines([]);
        $order->setShippingTax(null);
        $order->setPricesIncludeTax($total);
        $order->setShippingTotal($request->get('shipping_amount'));
        $order->setTotalTax(0.0);
        $order->setStatus(Order::PENDING);
        $reference="";
        $allowed_characters = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
        for ($i = 1; $i <= 12; ++$i) {
            $reference .= $allowed_characters[rand(0, count($allowed_characters) - 1)];
        }
        $order->setNumber($reference);
        $this->session->clear();
       // $this->doctrine->remove($cart);
        $this->doctrine->flush();
        return new JsonResponse([
            'result' => '',
            'numberorder'=>$reference,
            'message' => $products,
        ]);
    }
    function createBilling(Request $request,Billing $billing){
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
    }

    /**
     * @Route("/cart/{cid}/{pid}", name="cart_delete", methods={"GET"})
     * @param Request $request
     * @param Product $pid
     * @param Cart $cid
     * @return RedirectResponse
     */
    public function removeFromCart(Request $request, Cart $cid, Product $pid)
    {
        $line = $this->lineitemrepository->findOneBy([
            'product' => $pid,
            'cart' => $cid
        ]);
            $this->doctrine->remove($line);
            $this->doctrine->flush();
        return $this->redirectToRoute('show_cart');
    }


    /**
     * @Route("/cart/add", name="add_cart_json", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addToCartJson(Request $request)
    {
        $product = $this->productRepository->find($request->get('product_id'));
        if (!$product instanceof Product) {
            $status = 'ko';
            $message = 'Product not found';
        } else {
            if ($product->getStockQuantity() < $request->get('quantity')) {
                $status = 'ko';
                $message = 'Missing quantity for product';
            } else {
                $cartId = $this->session->get('cart');

                if (!$cartId) {
                    $cart = new Cart();

                    $this->doctrine->persist($cart);
                    $this->doctrine->flush();
                    $this->session->set('cart', $cartId = $cart->getId());
                } else {
                    $cart = $this->cartRepository->find($cartId);
                }
                $cartProduct=$this->lineitemrepository->findOneBy(['product'=>$product,'cart'=>$cart]);
                if (is_null($cartProduct)){
                    $cartProduct = new LineItem();
                    $cartProduct->setCart($cart);
                    $cartProduct->setProduct($product);
                    $cartProduct->setQuantity((int)$request->get('quantity'));
                    $cartProduct->setPrice($product->getSalePrice());
                    $cartProduct->setName($product->getName());
                    $cartProduct->setSubtotal($product->getSalePrice() * $cartProduct->getQuantity());
                    $this->doctrine->persist($cartProduct);
                }else{
                    $cartProduct->setSubtotal($cartProduct->getSubtotal()+($product->getSalePrice() * $cartProduct->getQuantity()));
                    $cartProduct->setQuantity($cartProduct->getQuantity()+(int)$request->get('quantity'));
                }
                $this->doctrine->flush();

                $status = 'ok';
                $message = 'Added to cart';
            }
        }

        return new JsonResponse([
            'result' => $status,
            'message' => $message,
            'cart' => $cart,
            'slug'=>$product->getSlug()
        ]);
    }

    public function partial()
    {
        $cartId = $this->session->get('cart');
        $repositoryCart = $this->getDoctrine()->getRepository(Cart::class);

        /** @var Cart $cart */
        $cart = $cartId ? $repositoryCart->find($cartId) : new Cart();

        return $this->render('partials/cart.html.twig', [
            'cart' => $cart
        ]);
        /*
        if ($isFullView) {
            return $this->render('partials/cart.html.twig', [
                'cart' => $cart
            ]);
        } else {
            return $this->render('cart/index.html.twig', [
                'cart' => $cart
            ]);
        }*/
    }
}
