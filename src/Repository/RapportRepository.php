<?php

namespace App\Repository;

use App\Entity\Rapport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rapport>
 *
 * @method Rapport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rapport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rapport[]    findAll()
 * @method Rapport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rapport::class);
    }


    public function add(Rapport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function remove(Rapport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    // renvoie les info de la table rapport en fonction de rapport.intervention ( a vérifier )
    public function findById(int $intervention_id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rapport r
            WHERE r.intervention = :id'
        );

        $query->setParameter('id', $intervention_id);

        return $query->getResult();
    }


    // take informations in rapport table
    public function findRapport()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rapport r 
            ORDER BY r.Created_at DESC'
        );

        return $query->getResult();
    }


    // take informations in rapport table
    public function findRapportAsc()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rapport r 
            ORDER BY r.Created_at ASC'
        );

        return $query->getResult();
    }


    // take specific informations in visite table
    public function findVisite()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT v
            FROM App\Entity\VisiteTechnique v
            ORDER BY v.created_at DESC'
        );

        return $query->getResult();
    }


    // take specific informations in visite table
    public function findVisiteAsc()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT v
            FROM App\Entity\VisiteTechnique v
            ORDER BY v.created_at ASC'
        );

        return $query->getResult();
    }


    // take specific informations in rapport table
    public function findRapportbyId(int $id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rapport r
            WHERE r.operateur = :id'
        );
        $query->setParameter('id', $id);

        return $query->getResult();
    }


    // take id in rapport table
    public function findRapportId()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r.id
            FROM App\Entity\Rapport r'
        );

        return $query->getResult();
    }
    
    
    // take the rapport by tel
    public function findRapportByTel(string $search = null)
    {
       $entityManager = $this->getEntityManager();

       $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rapport r
            JOIN App\Entity\Intervention i
            JOIN App\Entity\Client c
            WHERE r.numero_telephone_client LIKE :search
            OR (i.id = r.intervention AND i.client = c.id AND c.Name LIKE :search)
            or (i.id = r.intervention and i.Name like :search)
            '
        );

       $query->setParameter('search', '%'.$search.'%');

       return $query->getResult();
    }

    // take the rapport by tel
    public function findVsiteTechniqueByTel(string $search = null)
    {
       $entityManager = $this->getEntityManager();

       $query = $entityManager->createQuery(
            'SELECT v
            FROM App\Entity\VisiteTechnique v
            JOIN App\Entity\Intervention i
            JOIN App\Entity\Client c
            WHERE v.telephone LIKE :search
            OR (i.id = v.intervention AND i.client = c.id AND c.Name LIKE :search) 
            or (i.id = v.intervention AND i.Name like :search)'
        );

       $query->setParameter('search', '%'.$search.'%');

       return $query->getResult();
    }

    //take the rapport with cloture = 1
    public function findRapportByCloture(Int $cloturevalue) 
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rapport r
            JOIN App\Entity\Intervention i
            WHERE i.id = r.intervention AND i.Cloture = :cloturevalue
            order by r.Created_at DESC
            '
        );
        $query->setParameter('cloturevalue', $cloturevalue);
        return $query->getResult();
    }

    //take the visite whith cloture = 1
    public function findVisiteByCloture(int $cloturevalue)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT v
            FROM App\Entity\VisiteTechnique v
            JOIN App\Entity\Intervention i
            WHERE i.id = v.intervention AND i.Cloture = :cloturevalue
            order by v.created_at DESC
            '
        );
        $query->setParameter('cloturevalue', $cloturevalue);
        return $query->getResult();
    }

//    /**
//     * @return Rapport[] Returns an array of Rapport objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Rapport
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
