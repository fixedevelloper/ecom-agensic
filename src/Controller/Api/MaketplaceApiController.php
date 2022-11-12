<?php


namespace App\Controller\Api;


use App\Entity\Product;
use App\Entity\Shop;
use App\Entity\SpecialityShop;
use App\Entity\User;
use App\Repository\AttributeRepository;
use App\Repository\CategoryRepository;
use App\Repository\CustomerRepository;
use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use App\Repository\ShopOrderLineRepository;
use App\Repository\ShopOrderRepository;
use App\Repository\ShopRepository;
use App\Repository\SpecialityShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MaketplaceApiController extends AbstractFOSRestController
{
    private ProductRepository $productRepository;
    private CustomerRepository $customerRepository;
    private CategoryRepository $categoryRepository;
    private AttributeRepository $attributeRepository;
    private EntityManagerInterface $doctrine;
    private ImageRepository $imageRepository;
    private ShopRepository $shopRepository;
    private ShopOrderRepository $shopOrderRepository;
    private ShopOrderLineRepository $shopOrderLineRepository;
    private $specialityRepository;
    private $passwordEncoder;

    /**
     * StaticApiController constructor.
     * @param UserPasswordHasherInterface $passwordEncoder
     * @param SpecialityShopRepository $specialityRepository
     * @param ShopRepository $shopRepository
     * @param ShopOrderLineRepository $shopOrderLineRepository
     * @param ShopOrderRepository $shopOrderRepository
     * @param ImageRepository $imageRepository
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $productRepository
     * @param CustomerRepository $customerRepository
     * @param CategoryRepository $categoryRepository
     * @param AttributeRepository $attriburRepository
     */
    public function __construct(UserPasswordHasherInterface $passwordEncoder,SpecialityShopRepository $specialityRepository,ShopRepository $shopRepository,ShopOrderLineRepository $shopOrderLineRepository,
                                ShopOrderRepository $shopOrderRepository,ImageRepository $imageRepository, EntityManagerInterface $entityManager, ProductRepository $productRepository, CustomerRepository $customerRepository,
                                CategoryRepository $categoryRepository, AttributeRepository $attriburRepository)
    {
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->categoryRepository = $categoryRepository;
        $this->attributeRepository = $attriburRepository;
        $this->imageRepository = $imageRepository;
        $this->shopOrderLineRepository=$shopOrderLineRepository;
        $this->shopRepository=$shopRepository;
        $this->shopOrderRepository=$shopOrderRepository;
        $this->specialityRepository=$specialityRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->doctrine = $entityManager;
    }

    /**
     * @Rest\Post("/v1/shops", name="api_shop_post")
     * @param Request $request
     * @return Response
     */
    public function shopPost(Request $request)
    {
        $res = json_decode($request->getContent(), true);
        $data = $res['data'];
        if (!is_null($data['id'])) {
            $shop = $this->shopRepository->find($data['id']);
        } else {
            $shop = new Shop();
            $user=new User();
            $user->setEmail($data['email']);
            $user->setUsername($data['email']);
            $user->setName($data['name']);
            $plainPassword = $data['password'];
            $hashedPassword = $this->passwordEncoder->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
            if (!empty($data['phone'])){
                $user->setPhone($data['phone']);
               // $user->setAvatar($data['avatar']);
            }
            $user->setRoles(["ROLE_VENDOR"]);
            $user->setIsactivate(true);
            $this->doctrine->persist($user);
            $shop->setCompte($user);
            $this->doctrine->persist($shop);
        }
        $shop->setName($data['name']);
        $shop->setCity($data['city']);
        $shop->setAddress($data['address']);
        $shop->setPhone($data['phone']);
        $shop->setPhone2($data['phone2']);
        $shop->setCountry($data['country']);
        $shop->setCountrycode($data['countrycode']);
        $shop->setAddress2($data['address2']);

        if (null == $shop->getSlug() || '' == $shop->getSlug()) {
            $slug = str_replace(' ', '_', strtolower($shop->getName()));
            $shop->setSlug($slug);
        } else {
            $slug = str_replace(' ', '_', strtolower($shop->getSlug()));
            $shop->setSlug($slug);
        }
        if (!empty($data['speciality'])) {
                $speciality = $this->specialityRepository->find($data['speciality']);
                $shop->setSpeciality($speciality);

        }

        $this->doctrine->flush();
        $view = $this->view([], Response::HTTP_OK, []);
        return $this->handleView($view);
    }
    /**
     * @Rest\Get("/v1/shops", name="api_shop_list")
     * @param Request $request
     * @return Response
     */
    public function shopList(Request $request)
    {
        $shops = $this->shopRepository->findAll();
        $data = [];
        foreach ($shops as $shop) {
            $data[] = [
                'id' => $shop->getId(),
                'name' => $shop->getName(),
                'slug' => $shop->getSlug(),
                'phone' => $shop->getPhone(),
                'address' => $shop->getAddress(),
                'address2' => $shop->getAddress2(),
                'phone2' => $shop->getPhone2(),
                'city' => $shop->getCity(),
                'country' => $shop->getCountry(),
                'countrycode' => $shop->getCountrycode(),
            ];
        }
        $view = $this->view($data, Response::HTTP_OK, []);
        return $this->handleView($view);
    }
    /**
     * @Rest\Get("/v1/shops/one/{id}", name="api_shop_one_user")
     * @param Request $request
     * @return Response
     */
    public function shopOneByuser(Request $request,User $user)
    {
        $shop = $this->shopRepository->findOneBy(['compte'=>$user]);

            $data = [
                'id' => $shop->getId(),
                'name' => $shop->getName(),
                'slug' => $shop->getSlug(),
                'phone' => $shop->getPhone(),
                'address' => $shop->getAddress(),
                'address2' => $shop->getAddress2(),
                'phone2' => $shop->getPhone2(),
                'city' => $shop->getCity(),
                'country' => $shop->getCountry(),
                'countrycode' => $shop->getCountrycode(),
            ];
        $view = $this->view($data, Response::HTTP_OK, []);
        return $this->handleView($view);
    }
    /**
     * @Rest\Get("/v1/specialities", name="api_speciality_list")
     * @param Request $request
     * @return Response
     */
    public function specialityList(Request $request)
    {
        $shops = $this->specialityRepository->findAll();
        $data = [];
        foreach ($shops as $shop) {
            $data[] = [
                'id' => $shop->getId(),
                'name' => $shop->getName(),
                'slug' => $shop->getSlug(),
            ];
        }
        $view = $this->view($data, Response::HTTP_OK, []);
        return $this->handleView($view);
    }
    /**
     * @Rest\Post("/v1/specialities", name="api_speciality_post")
     * @param Request $request
     * @return Response
     */
    public function specialityPost(Request $request)
    {
        $res = json_decode($request->getContent(), true);
        $data = $res['data'];
        if (!is_null($data['id'])) {
            $speciality = $this->specialityRepository->find($data['id']);
        } else {
            $speciality = new SpecialityShop();
            $this->doctrine->persist($speciality);
        }
        $speciality->setName($data['name']);

        if (null == $speciality->getSlug() || '' == $speciality->getSlug()) {
            $slug = str_replace(' ', '_', strtolower($speciality->getName()));
            $speciality->setSlug($slug);
        } else {
            $slug = str_replace(' ', '_', strtolower($speciality->getSlug()));
            $speciality->setSlug($slug);
        }
        $this->doctrine->flush();
        $view = $this->view([], Response::HTTP_OK, []);
        return $this->handleView($view);
    }
}
