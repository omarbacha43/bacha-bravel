<?php

namespace App\DataFixtures;

use App\Entity\Destination;
use App\Entity\Hotel;
use App\Entity\Image;
use App\Entity\Role;
use App\Entity\SiteTouristique;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('FR-fr');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);


        $adminUser = new User();
        $adminUser->setPrenom('omar')
            ->setNom('bacha')
            ->setEmail('test@gmail.com')
            ->setPassword($this->encoder->encodePassword($adminUser, 'password'))
            ->setPhoto('https://images.pexels.com/photos/556416/pexels-photo-556416.jpeg?cs=srgb&dl=aube-montagnes-eau-pont-556416.jpg&fm=jpg')
            ->setIntroduction($faker->sentence())
            ->addUserRole($adminRole);

        $manager->persist($adminUser);
        $manager->flush();

        for ($i = 0; $i < 10; $i++){
            $destination = new Destination();

            $destination->setPhoto($faker->imageUrl($width = 1000, $height = 480))
                ->setDestination($faker->state)
                ->setCreatedAt(new \DateTime());
            ;


            for ($j = 0; $j < mt_rand(1, 8); $j++){

                $description = '<p>' . join('</p><p>', $faker->paragraphs(3)). '</p>';

                $titre = $faker->city;

                $site = new SiteTouristique();

                $site->setPhoto($faker->imageUrl($width = 640, $height = 480))
                    ->setTitre($titre)
                    ->setCreatedAt(new \DateTime())
                    ->setDescription($description)
                    ->setDestination($destination)
                    ->setIntroduction($faker->sentence)
                    ;

                    for ($k = 0; $k < mt_rand(1, 5); $k++ ){
                        $hotel = new Hotel();

                        $service = "Panier de fruits et des fleurs, Coffre-fort, Climatisation, Mini-bar,
                        Sèche-cheveux, Téléphone, Wi Fi Internet, TV Satellite, Piscine";

                        $hotel->setTitre($titre = $faker->city)
                            ->setVille($titre = $faker->city)
                            ->setSite($site)
                            ->setCreatedAt(new \DateTime())
                        ->setCoverImage($faker->ImageUrl());

                        $manager->persist($hotel);
                    }
                $manager->persist($site);
            }

            $manager->persist($destination);

            $manager->flush();

        }

        $manager->flush();
    }
}
