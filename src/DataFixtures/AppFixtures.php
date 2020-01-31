<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $loader = new NativeLoader();
        $objects = $loader->loadFile(__DIR__.'/ORM/fixtures.yml');
        foreach($objects->getObjects() as $object){
            if ($object instanceof Usuario) {
                $object->setPassword(
                    $this->passwordEncoder->encodePassword(
                        $object,
                        $object->getPlainPassword()
                    )
                );
            }
            $manager->persist($object);
        }
        $manager->flush();

    }
}
