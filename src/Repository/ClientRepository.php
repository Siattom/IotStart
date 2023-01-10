<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 *
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }


    public function add(Client $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    // permet de retrouver un user via son id dans la table client
    public function findUser(int $userId)
    {
        $entityManager = $this->getEntityManager();
    
        $query = $entityManager->createQuery(
            'SELECT c
            FROM App\Entity\Client c
            Where c.user = :id
            '
        );
    
        $query->setParameter('id', $userId);
    
        return $query->getResult();
    }


    // take the client by search
    public function findClientBySearch(string $search = null)
    {
       $entityManager = $this->getEntityManager();

       $query = $entityManager->createQuery(
            'SELECT c
            FROM App\Entity\Client c
            JOIN App\Entity\User u
            WHERE c.Tel LIKE :search
            OR c.Adresse LIKE :search
            OR c.user = u.id AND u.Name LIKE :search
            OR c.CodePostal LIKE :search
            OR c.Ville LIKE :search
            OR c.Activity LIKE :search
            '
        );

       $query->setParameter('search', '%'.$search.'%');

       return $query->getResult();
    }
    

    // permet de retrouver les demandes sécurité par l'id de l'utilisateur ( ici le client pourra voir ses demandes)
    public function findSecuriteById(int $userId)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT s
            FROM App\Entity\Securite s
            WHERE s.user = :id'
        );

        $query->setParameter('id', $userId);
        return $query->getResult();
    }


    
    public function remove(Client $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


//    /**
//     * @return Client[] Returns an array of Client objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Client
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
