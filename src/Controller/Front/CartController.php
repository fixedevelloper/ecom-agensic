<?php

namespace App\Controller\Front;

use App\Entity\Cart;
use App\Entity\LineItem;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CartRepository;
use App\Repository\LineItemRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CartController extends AbstractController
{


    private $session;
    private $productRepository;
    private $cartRepository;
    private $lineitemrepository;
    private $doctrine;

    public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository, CartRepository $cartRepository, LineItemRepository $lineItemRepository, SessionInterface $session)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
        $this->lineitemrepository = $lineItemRepository;
        $this->doctrine = $entityManager;
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('Front/cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    public function cart(): Response
    {
        $cartId = $this->session->get('cart');
        if (is_null($cartId)) {
            return $this->render('Front/cart/cart.html.twig', [
                'count_item' => 0,
                'summary' => 0.0,
                'lines' => []
            ]);
        }
        $cart = $this->cartRepository->find($cartId);
        $line_carts = [];
        $sumary = 0.0;
        foreach ($cart->getLineItems() as $lineItem) {
            $product=$this->productRepository->find($lineItem->getProductId());
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
        return $this->render('Front/cart/cart.html.twig', [
            'count_item' => count($line_carts),
            'summary' => $sumary,
            'lines' => $line_carts
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
     * @Route("/cart/show", name="show_cart")
     */
    public function showCart()
    {
        $cartId = $this->session->get('cart');

        $cart = $cartId ? $this->cartRepository->find($cartId) : new Cart();

        $line_carts = [];
        foreach ($cart->getLineItems() as $lineItem) {
            $product=$this->productRepository->find($lineItem->getProductId());
            $image = $product->getImages()[0];
            $line_carts[] = [
                'product_name' => $lineItem->getName(),
                'price' => $lineItem->getPrice(),
                'quantity' => $lineItem->getQuantity(),
                'image' => $image->getSrc(),
                'slug' => $product->getSlug()
            ];
        }
        return $this->render('Front/cart/view.html.twig', [
            'cart' => $cart,
            'linecarts' => $line_carts
        ]);

        //return $this->partial($session, true);
    }


    /**
     * Checkout
     *
     * @Route("/cart/checkout", name="checkout_cart", methods={"GET","POST"})
     */
    public function checkout(Request $request, UserInterface $user)
    {
        $cartId = $this->session->get('cart');
        $repositoryCart = $this->getDoctrine()->getRepository(Cart::class);
        $cart = $cartId ? $repositoryCart->find($cartId) : new Cart();

        $repositoryUser = $this->getDoctrine()->getRepository(User::class);
        $user = $repositoryUser->findOneBy(['email' => $user->getUsername()]);

        $form = $this->createForm(AddressChooserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $selectedAddress = $form->get('addresses')->getData();

            $command = new Package();

            $command->setPrice($cart->getTotal());
            $command->setAddress($selectedAddress);
            $command->setCreationDate(new \DateTime());
            $command->setUser($user);
            $command->setCart($cart);
            //Find a better way. Pass address value to the next form
            $command->setIsPaid(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($command);
            $entityManager->flush();

            return $this->redirectToRoute('checkout_payment', array('cmd' => $command->getId()));
        }

        return $this->render('checkout/checkout.html.twig', [
            'cart' => $cart,
            'addresselect' => $form->createView(),
        ]);
    }

    /**
     * @Route("/cart/{cid}/{pid}", name="cart_delete", methods={"DELETE"})
     */
    public function removeFromCart(Request $request, Product $pid, Cart $cid)
    {
        $repositoryP = $this->getDoctrine()->getRepository(CartProduct::class);
        $product = $repositoryP->findOneBy([
            'product' => $pid,
            'cart' => $cid
        ]);
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }
        // @pgrimaud : how to redirect user to the last URL known (ex: product/:id page)
        //$routeName = $request->attributes->get('_route');
        return $this->redirectToRoute('index');
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

                $cartProduct = new LineItem();
                $cartProduct->setCart($cart);
                $cartProduct->setProductId($product->getId());
                $cartProduct->setQuantity((int)$request->get('quantity'));
                $cartProduct->setPrice($product->getSalePrice());
                $cartProduct->setName($product->getName());
                $cartProduct->setSubtotal($product->getSalePrice() * $cartProduct->getQuantity());
                $this->doctrine->persist($cartProduct);
                $this->doctrine->flush();

                $status = 'ok';
                $message = 'Added to cart';
            }
        }

        return new JsonResponse([
            'result' => $status,
            'message' => $message,
            'cart' => $cart,
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
