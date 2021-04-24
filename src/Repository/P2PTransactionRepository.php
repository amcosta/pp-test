<?php

namespace App\Repository;

use App\Entity\P2PTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method P2PTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method P2PTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method P2PTransaction[]    findAll()
 * @method P2PTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class P2PTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, P2PTransaction::class);
    }

    // /**
    //  * @return P2PTransaction[] Returns an array of P2PTransaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?P2PTransaction
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
