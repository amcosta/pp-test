<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\WalletRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;
    private SluggerInterface $slugger;
    private WalletRepository $walletRepository;

    public function __construct(UserPasswordEncoderInterface $encoder,
                                SluggerInterface $slugger,
                                WalletRepository $walletRepository)
    {
        $this->encoder = $encoder;
        $this->slugger = $slugger;
        $this->walletRepository = $walletRepository;
    }

    public function load(ObjectManager $manager)
    {
        $users = [
            $this->createUser('Pumba', 'hakunamatata'),
            $this->createUser('Timão', 'hakunamatata'),
            $this->createUser('Simba', 'hakunamatata'),
        ];

        foreach ($users as $user) {
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function createUser(string $name, string $plainPassword): User
    {
        $user = new User();
        $user->setName($name);
        $user->setUsername($this->slugger->slug($name));
        $user->setPassword($this->encoder->encodePassword($user, $plainPassword));
        $this->walletRepository->createWalletForUser($user);

        return $user;
    }
}
