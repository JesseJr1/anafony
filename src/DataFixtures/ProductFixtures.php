<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public const PRODUCT_LAPTOP = 'PRODUCT_LAPTOP';

    public function load(ObjectManager $manager): void
    {
        $products = [];

        for ($i = 1; $i <= 50; $i++) {
            $product = new Product();
            $product->setName('Tablet as a laptop' . $i);
            $product->setCategory($this->getReference(CategoryFixtures::CATEGORY_LAPTOP));
            $product->setPrice(mt_rand(200, 2000));
            // $mark = new Mark();
            // $mark->setMark(mt_rand(1, 5));
            $manager->persist($product);
            // $manager->persist($mark);
        }

        $products[] = $product;

        $this->addReference(self::PRODUCT_LAPTOP, $product);


        $manager->flush();
    }



    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
