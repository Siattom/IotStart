<?php

namespace App\Repository;

use App\Entity\Operateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Operateur>
 *
 * @method Operateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operateur[]    findAll()
 * @method Operateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operateur::class);
    }


    public function add(Operateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function remove(Operateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    // permet de recupérer les info operateur (a vérifier)
    public function findForInter()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT o.name, o.surname, o.id
            FROM App\Entity\Operateur o'
        );

        return $query->getResult();
    }


    // permet de retrouver un user par son id
    public function findUser(int $userId)
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


    // take the intervention with op.id cloture = 1
    public function findInterClotureOui(int $id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rapport r
            JOIN App\Entity\Intervention i
            WHERE i.operateur = :id
            AND  i.Cloture = 1
            AND r.intervention = i.id'
        );

        $query->setParameter('id', $id);
        return $query->getResult();
    }


    // take the intervention with op.id cloture = 0
    public function findInterClotureNon(int $id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Rapport r
            JOIN App\Entity\Intervention i
            WHERE i.operateur = :id
            AND  i.Cloture = 0
            AND r.intervention = i.id'
        );

        $query->setParameter('id', $id);
        return $query->getResult();
    }


    // search by the ot name in a table rapport
    public function findRapportByOt(int $id, string $search = null)
    {

       $entityManager = $this->getEntityManager();

       $query = $entityManager->createQuery(
           'SELECT r
           FROM App\Entity\Rapport r
           JOIN App\Entity\Intervention i
           JOIN App\Entity\Client c
           WHERE (i.operateur = :id 
           AND r.intervention = i.id 
           AND i.not LIKE :search)'

       );
      
       $query->setParameter('id', $id);
       $query->setParameter('search', '%'.$search.'%');

       return $query->getResult();
    }


//    /**
//     * @return Operateur[] Returns an array of Operateur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Operateur
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
