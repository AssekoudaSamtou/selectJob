<?php

namespace App\Repository;

use App\Entity\CompetenceOffre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompetenceOffre|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetenceOffre|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetenceOffre[]    findAll()
 * @method CompetenceOffre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetenceOffreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompetenceOffre::class);
    }

    // /**
    //  * @return CompetenceOffre[] Returns an array of CompetenceOffre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompetenceOffre
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
