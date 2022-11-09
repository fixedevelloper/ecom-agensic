<?php


namespace App\Controller\Api;


use App\Entity\Attribute;
use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Product;
use App\Repository\AttributeRepository;
use App\Repository\CategoryRepository;
use App\Repository\CustomerRepository;
use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\StringType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StaticApiController extends AbstractFOSRestController
{
    private $productRepository;
    private $customerRepository;
    private $categoryRepository;
    private $attriburRepository;
    private $doctrine;
    private $imageRepository;

    /**
     * StaticApiController constructor.
     * @param ImageRepository $imageRepository
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $productRepository
     * @param CustomerRepository $customerRepository
     * @param CategoryRepository $categoryRepository
     * @param AttributeRepository $attriburRepository
     */
    public function __construct(ImageRepository $imageRepository, EntityManagerInterface $entityManager, ProductRepository $productRepository, CustomerRepository $customerRepository,
                                CategoryRepository $categoryRepository, AttributeRepository $attriburRepository)
    {
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->categoryRepository = $categoryRepository;
        $this->attriburRepository = $attriburRepository;
        $this->imageRepository = $imageRepository;
        $this->doctrine = $entityManager;
    }

    /**
     * @Rest\Post("/v1/products", name="api_products_post")
     * @param Request $request
     */
    public function productPost(Request $request)
    {
        $res = json_decode($request->getContent(), true);
        $data = $res['data'];
        if (!is_null($data['id'])) {
            $product = $this->productRepository->find($data['id']);
        } else {
            $product = new Product();
            $this->doctrine->persist($product);
        }
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setRegularPrice($data['regulaprice']);
        $product->setSalePrice($data['saleprice']);
        $product->setType($data['type']);
        $product->setHeight($data['height']);
        $product->setLength($data['length']);
        $product->setWeight($data['weight']);
        $product->setManageStock($data['managestock']);
        if (!empty($data['parent'])) {
            $product->setParentId($data['parent']);
        }
        $product->setStockQuantity($data['stockquantity']);
        $product->setWidth($data['width']);
        $product->setManageStock($data['managestock']);
        if (null == $product->getSlug() || '' == $product->getSlug()) {
            $slug = str_replace(' ', '_', strtolower($product->getName()));
            $product->setSlug($slug);
        } else {
            $slug = str_replace(' ', '_', strtolower($product->getSlug()));
            $product->setSlug($slug);
        }
        if (!empty($data['categories'])) {
            for ($i = 0; $i < count($data['categories']); $i++) {
                $category = $this->categoryRepository->find($data['categories'][$i]);
                $product->addCategory($category);
            }
        }
        if (!empty($data['images'])) {
            for ($i = 0; $i < count($data['images']); $i++) {
                $image = $this->imageRepository->find($data['images'][$i]);
                $product->addImage($image);
            }
        }
        if (!empty($data['attributes'])) {
            for ($i = 0; $i < count($data['attributes']); $i++) {
                $attribute = $this->attriburRepository->find($data['attributes'][$i]);
                $product->addAttribute($attribute);
            }
        }
        $product->setManageStock($data['managestock']);
        $this->doctrine->flush();
        $view = $this->view([], Response::HTTP_OK, []);
        return $this->handleView($view);

    }

    /**
     * @Rest\Get("/v1/products", name="api_product_list")
     * @param Request $request
     * @return Response
     */
    public function productList(Request $request)
    {
        $products = $this->productRepository->findAll();
        $data = [];
        foreach ($products as $product) {
            $image = $product->getImages()[0];
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'managestock' => $product->getId(),
                'width' => $product->getWidth(),
                'stockquantity' => $product->getStockQuantity(),
                'weight' => $product->getWeight(),
                'length' => $product->getLength(),
                'height' => $product->getHeight(),
                'image' => is_null($image) ? "" : $this->getParameter('domaininit') . $image->getSrc(),
                'type' => $product->getType(),
                'saleprice' => $product->getSalePrice(),
                'regularprice' => $product->getRegularPrice(),
            ];
        }
        $view = $this->view($data, Response::HTTP_OK, []);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/v1/products/{id}", name="api_product_one")
     * @param Request $request
     * @return Response
     */
    public function productOne(Product $product, Request $request)
    {

        $image = $product->getImages()[0];
        $images = [];
        foreach ($product->getImages() as $im) {
            $images[] = [
                'url' => $this->getParameter('domaininit') . $im->getSrc(),
                'id' => $im->getId(),
            ];
        }
        $categories = [];
        foreach ($product->getCategories() as $category) {
            $categories[] = [
                'name' => $category->getName(),
                'id' => $category->getId(),
                'display' => $category->getDisplay(),
                'description' => $category->getDescription()
            ];
        }
        $data = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'categories'=>$categories,
            'managestock' => $product->getId(),
            'width' => $product->getWidth(),
            'stockquantity' => $product->getStockQuantity(),
            'weight' => $product->getWeight(),
            'length' => $product->getLength(),
            'height' => $product->getHeight(),
            'images' => $images,
            'image' => is_null($image) ? "" : $this->getParameter('domaininit') . $image->getSrc(),
            'type' => $product->getType(),
            'saleprice' => $product->getSalePrice(),
            'regularprice' => $product->getRegularPrice(),
        ];

        $view = $this->view($data, Response::HTTP_OK, []);
        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/v1/categories", name="api_category_post")
     * @param Request $request
     * @return Response
     */
    public function categoryPost(Request $request)
    {
        $res = json_decode($request->getContent(), true);
        $data = $res['data'];
        if (!is_null($data['id'])) {
            $category = $this->categoryRepository->find($data['id']);
        } else {
            $category = new Category();
            $this->doctrine->persist($category);
        }
        $category->setName($data['name']);
        $category->setDisplay($data['display']);
        $category->setDescription($data['description']);
        $category->setParent($data['parent']);
        if (null == $category->getSlug() || '' == $category->getSlug()) {
            $slug = str_replace(' ', '-', strtolower($category->getName()));
            $category->setSlug($slug);
        } else {
            $slug = str_replace(' ', '-', strtolower($category->getSlug()));
            $category->setSlug($slug);
        }
        $this->doctrine->flush();
        $view = $this->view([], Response::HTTP_OK, []);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/v1/categories", name="api_category_list")
     * @param Request $request
     * @return Response
     */
    public function categoryList(Request $request)
    {
        $categories = $this->categoryRepository->findAll();
        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'display' => $category->getDisplay(),
                'description' => $category->getDescription()
            ];
        }
        $view = $this->view($data, Response::HTTP_OK, []);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/v1/attributes", name="api_attribut_list")
     * @param Request $request
     * @return Response
     */
    public function attributList(Request $request)
    {
        $attributes = $this->attriburRepository->findAll();
        $data = [];
        foreach ($attributes as $attribute) {
            $data[] = [
                'id' => $attribute->getId(),
                'name' => $attribute->getName(),
                'variation' => $attribute->getVariations(),
                'options' => $attribute->getOptions()
            ];
        }
        $view = $this->view($data, Response::HTTP_OK, []);
        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/v1/attributes", name="api_attribute_post")
     * @param Request $request
     * @return Response
     */
    public function attributePost(Request $request)
    {
        $res = json_decode($request->getContent(), true);
        $data = $res['data'];
        if (!is_null($data['id'])) {
            $attribute = $this->attriburRepository->find($data['id']);
        } else {
            $attribute = new Attribute();
            $this->doctrine->persist($attribute);
        }
        $attribute->setName($data['name']);
        $attribute->setVariation($data['variation']);
        $attribute->setOptions($data['options']);
        $attribute->setVisible($data['visible']);
        $this->doctrine->flush();
        $view = $this->view([], Response::HTTP_OK, []);
        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/v1/images", name="api_image_post")
     * @param Request $request
     * @return Response
     */
    public function imagePost(Request $request)
    {
        $res = json_decode($request->getContent(), true);
        $data = $res;
        if (!is_null($data['id'])) {
            $image = $this->imageRepository->find($data['id']);
        } else {
            $image = new Image();
            $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/products/';
            if (!empty($data['filename'])) {
                $image_parts = explode(";base64,", $data['filename']);
                if (!empty($image_parts[1])) {
                    $image_base64 = base64_decode($image_parts[1]);

                    $file = $destination . $data['name'];
                    if (file_put_contents($file, $image_base64)) {
                        $image->setSrc('uploads/products/' . $data['name']);
                    }
                }
            }
            $image->setName($data['name']);
            $this->doctrine->persist($image);
        }
        if (!empty($data['alt'])) {
            $image->setAlt($data['alt']);
        }
        $this->doctrine->flush();
        $view = $this->view([], Response::HTTP_OK, []);
        return $this->handleView($view);
    }

    /**
     * @Rest\Get("/v1/images", name="api_image_list")
     * @param Request $request
     * @return Response
     */
    public function imageList(Request $request)
    {
        $attributes = $this->imageRepository->findAll();
        $data = [];
        foreach ($attributes as $image) {
            $data[] = [
                'id' => $image->getId(),
                'name' => $image->getName(),
                'url' => is_null($image->getSrc()) ? "" : $this->getParameter('domaininit') . $image->getSrc(),
                'alt' => $image->getAlt()
            ];
        }
        $view = $this->view($data, Response::HTTP_OK, []);
        return $this->handleView($view);
    }
    /**
     * @Rest\Delete("/v1/images/{id}", name="api_product_delete")
     * @param Request $request
     * @return Response
     */
    public function imagedelete(Image $image, Request $request)
    {
        $this->doctrine->remove($image);
        $this->doctrine->flush();
        $view = $this->view([], Response::HTTP_OK, []);
        return $this->handleView($view);
    }
}
