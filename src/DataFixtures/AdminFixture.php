<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixture extends \Doctrine\Bundle\FixturesBundle\Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $dummyAdmin = new User();
        $dummyAdmin->setCutleryNumber(0)
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $dummyAdmin,
                    'admin'
                )
            )
            ->setEmail('admin@admin.com')
            ->setRoles(["ROLE_ADMIN"]);

        $manager->persist($dummyAdmin);
        $manager->flush();
    }
}