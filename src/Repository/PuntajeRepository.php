<?php

namespace App\Repository;

use App\Entity\Puntaje;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\AbstractQuery;

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

    public function getPostAverage($post)
    {
        return $this->createQueryBuilder('p')
            ->select('AVG(p.valor) as average')
            ->andWhere('p.post = :post')
            ->setParameter('post', $post)
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_SINGLE_SCALAR);
    }

    public function getVotoUsuario($post, $usuario)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.post = :post')
            ->andWhere('p.usuario = :usuario')
            ->setParameter('post', $post)
            ->setParameter('usuario', $usuario)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
