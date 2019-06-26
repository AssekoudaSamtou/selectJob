<?php

namespace App\Repository;

use App\Entity\CategorieOffre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategorieOffre|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieOffre|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieOffre[]    findAll()
 * @method CategorieOffre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieOffreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategorieOffre::class);
    }

    // /**
    //  * @return CategorieOffre[] Returns an array of CategorieOffre objects
    //  */
    
    public function findOneByLibelle($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.libelle = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?CategorieOffre
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
