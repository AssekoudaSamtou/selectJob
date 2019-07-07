<?php

namespace App\Repository;

use App\Entity\DateInscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DateInscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method DateInscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method DateInscription[]    findAll()
 * @method DateInscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DateInscriptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DateInscription::class);
    }

    // /**
    //  * @return DateInscription[] Returns an array of DateInscription objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DateInscription
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
