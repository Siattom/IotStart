<?php

namespace App\Repository;

use App\Entity\Intervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Intervention>
 *
 * @method Intervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervention[]    findAll()
 * @method Intervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterventionRepository extends ServiceEntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('Created_at' => 'DESC'));
    }


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
            WHERE i.operateur = :id
            AND i.Cloture = 0'
        );

        $query->setParameter('id', $operateur_id)
        ;

        return $query->getResult();
    }


    // récupère l'operateur
    public function findOp(int $userId)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT o
            FROM App\Entity\Operateur o
            Where o.user = :id
            '
        );

        $query->setParameter('id', $userId);

        return $query->getResult();
    }


    // récupère les interventions avec le rapport id
    public function findInterRapport(int $rapportId)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT i
            FROM App\Entity\Intervention i
            WHERE i.id = :id'
        );

        $query->setParameter('id', $rapportId);

        return $query->getResult();
    }


    // recupere les intervention avec l'id fournit (a vérifier)
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


    // permet de recuperer les infos d'un rapport via l'id intervention
    public function findRapByInt(int $intervention)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rapport r
            WHERE r.intervention = :id'
        );

        $query->setParameter('id', $intervention);

        return $query->getResult();
    }


    /**
     * Liste les interventions par recherche de nom clients
     */
     public function findAllOrderedByClientAscQb(string $search = null)
     {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT i
            FROM App\Entity\Intervention i
            JOIN App\Entity\Client c
            WHERE i.client = c.id
            AND c.Name LIKE :search
            OR i.client = c.id 
            AND c.Tel LIKE :search
            OR i.client = c.id
            AND i.Adresse LIKE :search'
        );
       
        $query->setParameter('search', '%'.$search.'%');

        return $query->getResult();
     }


     //recupere toutes les infos d'une intervention via son id
    public function findInterInfoById(int $id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT i
            FROM App\Entity\Intervention i 
            WHERE i.id = :id'
        );

        $query->setParameter('id', $id);

        return $query->getResult();
    }


//    /**
//     * @return Intervention[] Returns an array of Intervention objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
//    public function findOneBySomeField($value): ?Intervention
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
