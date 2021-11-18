<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('usuario')
             ->setPassword('$argon2i$v=19$m=65536,t=4,p=1$L3p5bUhYaDdqRi4wU3AvNQ$zss6zQhiD3492+AE+5HM8sdZQnllYDIa7RBPKj9XLMA');
        $manager->persist($user);

        $manager->flush();
    }
}
