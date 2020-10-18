<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }


    /**
     * @param $user
     * @return array  tableau d'évenements dont le $user est l'organisateur
     */
    public function findEventByOwner($user) {
        $qb = $this->createQueryBuilder('e')
            ->andWhere('e.owner = :val')
            ->setParameter('val', $user);
        $query = $qb->getQuery();
        return $query->execute();
    }

    /**
     * @param $user
     * @return int|mixed|string tableau d'évenements dont le user est participant
     */

    public function findEventByRegistrationsByUser($user)
    {
        $qb = $this->createQueryBuilder('e')
            ->join('e.registrations', 'r')
            ->addSelect('r')
            ->andWhere('r.participant = :val')
            ->setParameter('val', $user);
            $query = $qb->getQuery();
        return $query->execute();
    }


    /**
     * @param String $stateLabel
     * @return int|mixed|string return un tableau des événements dont le statut est passé en paramètre
     */
    public function findEventByStateLabel($stateLabel) {
        $qb = $this->createQueryBuilder('e')
            ->join('e.state', 's')
            ->addSelect('s')
            ->andWhere('s.label = :label')
            ->setParameter('label', $stateLabel);
        $query = $qb->getQuery();
        $query->execute();
        return $query->getResult();

    }

    /**
     * @quentin requête transitoire pour tests
     */
    public function findEventByDate($dateDebut, $dateFin)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.startDateTime > :dateDebut')
            ->andWhere('e.registrationLimitDate < :dateFin')
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin)
            ->getQuery()
            ->getResult();
    }


    /**
     * @param $campusId
     * @return int|mixed|string tableau d'événements qui sont organisés par le campus dont l'id est passé en paramètre
     */
    public function findEventByCampus($campusId) {
        $qb = $this->createQueryBuilder('e')
            ->join('e.campus', 'c')
            ->addSelect('c')
            ->andWhere('c.id = :campusId')
            ->setParameter('campusId', $campusId);
        $query = $qb->getQuery();
        $query->execute();
        return $query->getResult();

    }

    public function findEventBySearchWord($word) {
        $qb = $this->createQueryBuilder('e')
            ->andWhere('e.name like :word')
            ->setParameter('word','%' . $word . '%');
        $query = $qb->getQuery();
        return $query->execute();
    }

}
    
    
//en sql SELECT e, r FROM Event inner join Registration on e.id = r.eventId WHERE r.participant = e.owner

