<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Matiere;
use App\Entity\Questionnaire;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $userPasswordHasherInterface) {}

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@site.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFirstName('Admin');
        $user->setLastName('Admin');
        $user->setPassword($this->userPasswordHasherInterface->hashPassword($user,'password'));
        $manager->persist($user);

        $user = new User();
        $user->setEmail('formateur1@site.com');
        $user->setRoles(['ROLE_FORMATEUR']);
        $user->setFirstName('Formateur');
        $user->setLastName('Formateur');
        $user->setPassword($this->userPasswordHasherInterface->hashPassword($user,'password'));
        $manager->persist($user);

        $user = new User();
        $user->setEmail('formateur2@site.com');
        $user->setRoles(['ROLE_FORMATEUR']);
        $user->setFirstName('Formateur');
        $user->setLastName('Formateur');
        $user->setPassword($this->userPasswordHasherInterface->hashPassword($user,'password'));
        $manager->persist($user);

        $matiere = new Matiere();
        $matiere->setLibelle('PHP');
        $manager->persist($matiere);
        $this->addReference('matiere-php', $matiere);

        $matiere = new Matiere();
        $matiere->setLibelle('HTML');
        $manager->persist($matiere);
        $this->addReference('matiere-html', $matiere);


        $manager->flush();
    }
}
