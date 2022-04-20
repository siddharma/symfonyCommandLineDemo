<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $entityId;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $categoryName;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $sku;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $description;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $shortdesc;
/**
     * @ORM\Column(type="float")
     */
    private string $price;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $link;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $image;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $brand;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $rating;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $caffeineType;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $count;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $flavored;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $seasonal;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $instock;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $facebook;
/**
     * @ORM\Column(type="string", length=255)
     */
    private string $isKCup;
    public function getEntityId(): ?int
    {
        return $this->entityId;
    }
    public function getCategoryName(): string
    {
        return $this->categoryName;
    }
    public function getSku(): string
    {
        return $this->sku;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getShortdesc(): string
    {
        return $this->shortdesc;
    }
    public function getPrice(): float
    {
        return $this->price;
    }
    public function getLink(): string
    {
        return $this->link;
    }
    public function getImage(): string
    {
        return $this->image;
    }
    public function getBrand(): string
    {
        return $this->brand;
    }
    public function getRating(): string
    {
        return $this->rating;
    }
    public function getCaffeineType(): string
    {
        return $this->caffeineType;
    }
    public function getCount(): string
    {
        return $this->count;
    }
    public function getFlavored(): string
    {
        return $this->flavored;
    }
    public function getSeasonal(): string
    {
        return $this->seasonal;
    }
    public function getInstock(): string
    {
        return $this->instock;
    }
    public function getFacebook(): string
    {
        return $this->facebook;
    }
    public function getIsKCup(): string
    {
        $this->isKCup;
    }

    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
    }
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }
    public function setSku($sku)
    {
        $this->sku = $sku;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setShortdesc($shortdesc)
    {
        $this->shortdesc = $shortdesc;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function setLink($link)
    {
        $this->link = $link;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
    public function setCaffeineType($caffeineType)
    {
        $this->caffeineType = $caffeineType;
    }
    public function setCount($count)
    {
        $this->count = $count;
    }
    public function setFlavored($flavored)
    {
        $this->flavored = $flavored;
    }
    public function setSeasonal($seasonal)
    {
        $this->seasonal = $seasonal;
    }
    public function setInstock($instock)
    {
        $this->instock = $instock;
    }
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }
    public function setIsKCup($isKCup)
    {
        $this->isKCup = $isKCup;
    }
}
