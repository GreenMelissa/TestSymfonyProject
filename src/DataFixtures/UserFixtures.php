<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Фикстура для пользователей
 */
class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $hasher;

    /**
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setRoles(['ROLE_ADMIN']);

        $password = $this->hasher->hashPassword($user, 'admin_password');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setUsername('user');
        $user->setRoles(['ROLE_USER']);

        $password = $this->hasher->hashPassword($user, 'user_password');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}
