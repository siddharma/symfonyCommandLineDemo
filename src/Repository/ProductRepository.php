<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductRepository
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveProductData($dataArray)
    {

        $count = 1;
        foreach ($dataArray as $key => $product) {
            if ($key == 0 || empty($product['0'])) {
                continue;
            }

            $productObj = new Product();
            $productObj->setEntityId($product['0']);
            $productObj->setCategoryName(addslashes($product['1']));
            $productObj->setSku(addslashes($product['2']));
            $productObj->setName(addslashes($product['3']));
            $productObj->setDescription(addslashes($product['4']));
            $productObj->setShortdesc(addslashes($product['5']));
            $productObj->setPrice(addslashes($product['6']));
            $productObj->setLink(addslashes($product['7']));
            $productObj->setImage(addslashes($product['8']));
            $productObj->setBrand(addslashes($product['9']));
            $productObj->setRating(addslashes($product['10']));
            $productObj->setCaffeineType(addslashes($product['11']));
            $productObj->setCount(addslashes($product['12']));
            $productObj->setFlavored(addslashes($product['13']));
            $productObj->setSeasonal(addslashes($product['14']));
            $productObj->setInstock(addslashes($product['15']));
            $productObj->setFacebook(addslashes($product['16']));
            $productObj->setIsKCup(addslashes($product['17']));
            $this->em->persist($productObj);
            if ($count == 20) {
                $this->em->flush();
                $this->em->clear();
                $count = 1;
            }

            $count++;
        }

        $this->em->flush();
        $this->em->clear();
    }
}
