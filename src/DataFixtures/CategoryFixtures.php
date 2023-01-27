<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_LAPTOP = 'CATEGORY_LAPTOP';

    public const CATEGORY_HEADPHONE = 'CATEGORY_HEADPHONE';

    public const CATEGORY_CONSOLE = 'CATEGORY_CONSOLE';



    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <+ 6 ; $i++) { 
            $category = new Category();
            $category->setTitle('category' . $i);
            $manager->persist($category);
        }
        $this->addReference(self::CATEGORY_LAPTOP, $category);

        $manager->flush();

        // $console = new Category();
        // $console->setTitle('Console');
        // $manager->persist($console);
        // $this->addReference(self::CATEGORY_CONSOLE, $console);

        // $headphone = new Category();
        // $headphone->setTitle('Headphone');
        // $manager->persist($headphone);
        // $this->addReference(self::CATEGORY_HEADPHONE, $headphone);
    }
}
