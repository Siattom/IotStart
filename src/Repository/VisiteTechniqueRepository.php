<?php

namespace App\Repository;

use App\Entity\VisiteTechnique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VisiteTechnique>
 *
 * @method VisiteTechnique|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisiteTechnique|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisiteTechnique[]    findAll()
 * @method VisiteTechnique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisiteTechniqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisiteTechnique::class);
    }


    public function add(VisiteTechnique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    

    public function remove(VisiteTechnique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    // take the vt for admin
    public function findRapportVt()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT v
            FROM App\Entity\VisiteTechnique v
            ORDER BY v.created_at DESC'
        );

        return $query->getResult();
    }


    /**
     * Liste les interventions par recherche de nom clients
     */
    public function findAllOrderedByClientAscQb(string $search = null)
    {

       $entityManager = $this->getEntityManager();

       $query = $entityManager->createQuery(
           'SELECT v
           FROM App\Entity\VisiteTechnique v
           WHERE (v.nom LIKE :search)
           OR (v.adresse LIKE :search)
           OR (v.travaux_a_effectuer LIKE :search)
           '

       );
      
       $query->setParameter('search', '%'.$search.'%');

       return $query->getResult();
    }



//    /**
//     * @return VisiteTechnique[] Returns an array of VisiteTechnique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VisiteTechnique
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
