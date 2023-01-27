<?php

namespace App\DataFixtures;

use App\Entity\ProductPicture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductPictureFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $productPicture = new ProductPicture();
        $productPicture->setPath('laptop.jpeg');
        $productPicture->setPosition(1);
        $productPicture->setProduct($this->getReference(ProductFixtures::PRODUCT_LAPTOP));
        $manager->persist($productPicture);

        $manager->flush();
    }
}
