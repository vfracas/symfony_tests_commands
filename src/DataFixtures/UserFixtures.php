<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    protected $faker;
    public $hasher;
    public const ADMIN_USER_REFERENCE = 'admin';

    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $userAdmin = new User();
        $userAdmin->setEmail('admin@admin.com');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $userAdmin->setPassword($this->hasher->hashPassword($userAdmin, 'admin'));
        $this->addReference(self::ADMIN_USER_REFERENCE, $userAdmin);
        $manager->persist($userAdmin);

        $user = new User();
        $user->setEmail('user@user.com');
        $user->setPassword($this->hasher->hashPassword($user, 'user'));
        $manager->persist($user);

        for($i = 0; $i < 10; $i++){
            $userFake = new User();
            $userFake->setEmail($faker->freeEmail());
            $userFake->setPassword($faker->password(10, 15));
            $manager->persist($userFake);
        }

        $manager->flush();
    }
}
