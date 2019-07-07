<?php

namespace App\Repository;

use App\Entity\Discussion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Discussion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discussion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discussion[]    findAll()
 * @method Discussion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscussionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Discussion::class);
    }

    // /**
    //  * @return Discussion[] Returns an array of Discussion objects
    //  */
    
    public function findByCouple($exp, $dest)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.expediteur = :exp', 'd.destinataire = :dest')
            ->orWhere('d.destinataire = :exp', 'd.expediteur = :dest')
            ->setParameter('exp', $exp)
            ->setParameter('dest', $dest)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10000)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Discussion
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
