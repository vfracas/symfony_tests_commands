<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $article = new Article();
        $article->setDescription('SUPER ARTICLE');
        $article->setTitle('SUPER TITRE');
        $article->setIsActif(true);
        $article->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));

        $manager->persist($article);


        for($i = 0; $i < 10; $i++){
            $articleFake = new Article();
            $articleFake->setTitle($faker->sentence());
            $articleFake->setDescription($faker->paragraph());
            $articleFake->setIsActif(false);
            $articleFake->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));

            $manager->persist($articleFake);
        }

        $manager->flush();
    }

    public function getDependencies(){
        return [
            UserFixtures::class
        ];
    }
}
