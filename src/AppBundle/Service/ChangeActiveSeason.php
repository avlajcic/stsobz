<?php

namespace AppBundle\Service;


use AppBundle\Entity\Season;
use Doctrine\ORM\EntityManagerInterface;

class ChangeActiveSeason
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function checkAndChangeActiveSeason($season)
    {
        /** @var Season $activeSeason */
        $activeSeason = $this->em->getRepository('AppBundle:Season')->findOneBy(array(
            'active' => true
        ));

        if ($activeSeason && $activeSeason->getId() != $season->getId()) {
            $activeSeason->setActive(false);
            $this->em->persist($activeSeason);
        }
    }
}