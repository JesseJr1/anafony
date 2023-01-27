<?php

namespace App\DataFixtures;

use App\Entity\Rate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RateFixtures extends Fixture
{

    public const RATE_LAPTOP = 'RATE_LAPTOP';

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) { 
            # code...
            $rate = new Rate();
            $rate->setRate(mt_rand(1, 5));
            // $mark->setProduct($this->getReference(ProductFixtures::PRODUCT_LAPTOP));
            $manager->persist($rate);
        }

        $this->addReference(self::RATE_LAPTOP, $rate);
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProductFixtures::class,
        ];
    }
}