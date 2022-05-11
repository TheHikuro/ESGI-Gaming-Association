<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User\Section;
use App\Entity\User\User;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
  private $encoder;

  public function __construct(UserPasswordHasherInterface $encoder)
  {
    $this->encoder = $encoder;
  }

  public function load(ObjectManager $manager): void
  {
    $faker = Factory::create();

    // SECTIONS
    $section1 = new Section();
    $section1->setName('League of Legends');
    $manager->persist($section1);

    $section2 = new Section();
    $section2->setName('Among us');
    $manager->persist($section2);

    $section3 = new Section();
    $section3->setName('Laboratoire web');
    $manager->persist($section3);

    $section4 = new Section();
    $section4->setName('Laboratoire linux');
    $manager->persist($section4);

    $section5 = new Section();
    $section5->setName('No section');
    $manager->persist($section5);

    $userAdmin = new User();
    $userAdmin->setEmail('admin@gmail.com');
    $userAdmin->setName('admin');
    $userAdmin->setLastname('admin');
    $userAdmin->setPseudo('admin');
    $userAdmin->setSection($section5);
    $userAdmin->setRoles(['ROLE_ADMIN']);
    $userAdmin->setPassword($this->encoder->hashPassword(
      $userAdmin,
      'pwdpwd'));
    $manager->persist($userAdmin);

    $userUser = new User();
    $userUser->setEmail('user@gmail.com');
    $userUser->setName('user');
    $userUser->setLastname('user');
    $userUser->setPseudo('user');
    $userUser->setSection($section1);
    $userUser->setRoles(['ROLE_USER']);
    $userUser->setPassword($this->encoder->hashPassword(
      $userUser,
      'pwdpwd'));
    $manager->persist($userUser);

    // USERS
    for ($i = 1; $i <= 3; $i++) {
      $user = new User();
      $user->setEmail($faker->email);
      $user->setName($faker->firstName);
      $user->setLastname($faker->lastName);
      $user->setPseudo($faker->firstName);
      $user->setSection($section5);
      $user->setRoles(['ROLE_ADMIN']);
      $user->setPassword($this->encoder->hashPassword(
        $user,
        'pwdpwd'));

      $user2 = new User();
      $user2->setEmail($faker->email);
      $user2->setName($faker->firstName);
      $user2->setLastname($faker->lastName);
      $user2->setPseudo($faker->firstName);
      $user2->setSection($section5);
      $user2->setRoles(['ROLE_USER']);
      $user2->setPassword($this->encoder->hashPassword(
        $user2,
        'pwdpwd'));

      $user3 = new User();
      $user3->setEmail($faker->email);
      $user3->setName($faker->firstName);
      $user3->setLastname($faker->lastName);
      $user3->setPseudo($faker->firstName);
      $user3->setSection($section5);
      $user3->setRoles(['ROLE_USER']);
      $user3->setPassword($this->encoder->hashPassword(
        $user3,
        'pwdpwd'));

      $manager->persist($user);
      $manager->persist($user2);
      $manager->persist($user3);
    }

    $manager->flush();
  }
}
