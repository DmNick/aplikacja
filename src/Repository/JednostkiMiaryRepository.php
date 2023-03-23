<?php

namespace App\Repository;

use App\Entity\JednostkiMiary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JednostkiMiary>
 *
 * @method JednostkiMiary|null find($id, $lockMode = null, $lockVersion = null)
 * @method JednostkiMiary|null findOneBy(array $criteria, array $orderBy = null)
 * @method JednostkiMiary[]    findAll()
 * @method JednostkiMiary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JednostkiMiaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JednostkiMiary::class);
    }

    public function save(JednostkiMiary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JednostkiMiary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return JednostkiMiary[] Returns an array of JednostkiMiary objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JednostkiMiary
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
