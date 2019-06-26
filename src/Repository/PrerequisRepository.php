<?php

namespace App\Repository;

use App\Entity\Prerequis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Prerequis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prerequis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prerequis[]    findAll()
 * @method Prerequis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrerequisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Prerequis::class);
    }

    // /**
    //  * @return Prerequis[] Returns an array of Prerequis objects
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
    public function findOneBySomeField($value): ?Prerequis
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
