<?php

namespace App\Repository;

use App\Entity\SecurityIssue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SecurityIssue|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecurityIssue|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecurityIssue[]    findAll()
 * @method SecurityIssue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecurityIssueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecurityIssue::class);
    }

    // /**
    //  * @return SecurityIssue[] Returns an array of SecurityIssue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SecurityIssue
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
