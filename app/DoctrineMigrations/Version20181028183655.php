<?php

namespace Application\Migrations;

use AppBundle\Entity\League;
use AppBundle\Entity\Season;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181028183655 extends AbstractMigration  implements ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function postUp(Schema $schema)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->container->get('doctrine.orm.entity_manager');

        $season2018 = new Season();
        $season2018->setName('2018/19')
            ->setActive(true);
        $em->persist($season2018);

        $league1 = new League();
        $league1->setName('1. liga');
        $em->persist($league1);

        $league2 = new League();
        $league2->setName('2. liga');
        $em->persist($league2);

        $em->flush();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
