<?php
namespace Acme\HelloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\HelpBundle\Entity\Team;

class LoadTeamData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $team = new Team();
        $team->setName('巨人');
        $team->setLeague('セントラル');
        $manager->persist($team);

        $team = new Team();
        $team->setName('阪神');
        $team->setLeague('セントラル');
        $manager->persist($team);

        $team = new Team();
        $team->setName('中日');
        $team->setLeague('セントラル');
        $manager->persist($team);

        $team = new Team();
        $team->setName('ヤクルト');
        $team->setLeague('セントラル');
        $manager->persist($team);

        $team = new Team();
        $team->setName('横浜');
        $team->setLeague('セントラル');
        $manager->persist($team);

        $team = new Team();
        $team->setName('広島');
        $team->setLeague('セントラル');
        $manager->persist($team);

        $team = new Team();
        $team->setName('オリックス');
        $team->setLeague('パシフィック');
        $manager->persist($team);

        $team = new Team();
        $team->setName('西武');
        $team->setLeague('パシフィック');
        $manager->persist($team);

        $team = new Team();
        $team->setName('ロッテ');
        $team->setLeague('パシフィック');
        $manager->persist($team);

        $team = new Team();
        $team->setName('日本ハム');
        $team->setLeague('パシフィック');
        $manager->persist($team);

        $team = new Team();
        $team->setName('楽天');
        $team->setLeague('パシフィック');
        $manager->persist($team);

        $team = new Team();
        $team->setName('ソフトバンク');
        $team->setLeague('パシフィック');
        $manager->persist($team);

        $manager->flush();
    }
}