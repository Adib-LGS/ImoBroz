<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_En');
        for ($i = 0; $i < 100; $i++){
            $property = new Property();
            $property->setTitle($faker->words(4, true))
                    ->setDescription($faker->sentences(3, true))
                    ->setSurface($faker->numberBetween(20, 400))
                    ->setRooms($faker->numberBetween(1, 10))
                    ->setBedrooms($faker->numberBetween(1, 5))
                    ->setFloor($faker->numberBetween(0, 3))
                    ->setPrice($faker->numberBetween(1000000, 10000000))
                    ->setHeat($faker->numberBetween(0, count(Property::HEAT) -1))
                    ->setAdress($faker->address)
                    ->setCity($faker->city)
                    ->setPostalCode($faker->postcode)
                    ->setSold(false);
            $manager->persist($property);
            
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
