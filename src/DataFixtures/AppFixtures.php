<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $loader = new NativeLoader();
        $objects = $loader->loadFile(__DIR__.'/ORM/fixtures.yml');
        foreach($objects->getObjects() as $object){
            $manager->persist($object);
        }
        $manager->flush();

    }
}
