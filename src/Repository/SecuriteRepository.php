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


    // permet de retrouver les demandes sécurité par l'id ( ici pour créer une intervention directement via la demande )
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
 

    // renvoie les infos client/securite lié, sert dans la meme fonction que la fonction du dessus
    public function findClient(int $id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT c, s
            FROM App\Entity\Client c
            JOIN App\Entity\Securite s
            WHERE c.id = s.client
            AND s.id = :id 
            ' 
        );
        $query->setParameter('id', $id);
        return $query->getResult();
    }

    
//    /**
//     * @return Securite[] Returns an array of Securite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $v.format('d/m/Y'))
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
