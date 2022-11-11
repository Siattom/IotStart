<?php

namespace App\Repository;

use App\Entity\Intervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Intervention>
 *
 * @method Intervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervention[]    findAll()
 * @method Intervention[]    findInt()
 * @method Intervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intervention::class);
    }

    public function add(Intervention $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Intervention $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /*public function adresseInt(Intervention $entity)
    {
        $valeur = $
    } */

    public function findByName(Intervention $name)
    {
        return $this->createQueryBuilder('i')
            ->innerJoin('i.name', 'n')
            ->andWhere('n = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }

    public function findInt(int $operateur_id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT i
			FROM App\Entity\Intervention i
			WHERE i.operateur = :id'
        );

        $query->setParameter('id', $operateur_id)
            ->setMaxResults(3)
        ;

        return $query->getResult();
    }

    public function findIntByOpe(int $intervention)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT i
            FROM App\Entity\Intervention i
            WHERE i.id = :id
            ORDER BY i.id ASC'
        );

        $query->setParameter('id', $intervention);

        return $query->getResult();
    }


//    /**
//     * @return Intervention[] Returns an array of Intervention objects
//     */
//    public function findIntById($id): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.name = :id')
//            ->setParameter('id', $id)
//            ->orderBy('i.id', 'DESC')
//            ->setMaxResults(3)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
}



