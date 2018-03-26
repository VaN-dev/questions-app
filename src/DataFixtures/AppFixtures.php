<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Question;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadCategories($manager);
        $this->loadQuestions($manager);

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager)
    {
        $user = (new User())
            ->setUsername('admin@localhost')
            ->setRoles(['ROLE_ADMIN'])
        ;

        $user->setPassword($this->encoder->encodePassword($user, 'admin'));

        $manager->persist($user);
    }

    private function loadCategories(ObjectManager $manager)
    {
        $category01 = (new Category())
            ->setName('Backend')
        ;
        $category02 = (new Category())
            ->setName('Frontend')
        ;
        $category03 = (new Category())
            ->setName('Devops')
        ;
        $category04 = (new Category())
            ->setName('Management')
        ;

        $manager->persist($category01);
        $manager->persist($category02);
        $manager->persist($category03);
        $manager->persist($category04);
    }

    private function loadQuestions(ObjectManager $manager)
    {
        $question01 = (new Question())
            ->setLabel('Quelle est la version de PHP en cours ?')
        ;
        $question02 = (new Question())
            ->setLabel('Quelle est la version de Symfony en cours ?')
        ;

        $manager->persist($question01);
        $manager->persist($question02);
    }
}
