<?php

namespace App\Repository;

use App\Entity\Puntaje;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Puntaje|null find($id, $lockMode = null, $lockVersion = null)
 * @method Puntaje|null findOneBy(array $criteria, array $orderBy = null)
 * @method Puntaje[]    findAll()
 * @method Puntaje[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PuntajeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Puntaje::class);
    }

    // /**
    //  * @return Puntaje[] Returns an array of Puntaje objects
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
    public function findOneBySomeField($value): ?Puntaje
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
