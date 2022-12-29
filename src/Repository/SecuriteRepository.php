<?php

namespace App\Repository;

use App\Entity\Securite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Securite>
 *
 * @method Securite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Securite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Securite[]    findAll()
 * @method Securite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecuriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Securite::class);
    }

    public function add(Securite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Securite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSecuriteById(Int $id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT s
            FROM App\Entity\Securite s
            WHERE s.id = :id'
        );

        $query->setParameter('id', $id);
        return $query->getResult();
    }
 
    public function findClient()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT s, c
			FROM App\Entity\Securite s
            JOIN App\Entity\Client c 
            ' 
        );

        return $query->getResult();
    }
//    /**
//     * @return Securite[] Returns an array of Securite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Securite
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
