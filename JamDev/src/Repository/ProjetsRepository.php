<?php

namespace App\Repository;

use App\Entity\Projets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projets>
 *
 * @method Projets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projets[]    findAll()
 * @method Projets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projets::class);
    }

    public function save(Projets $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Projets $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Projets[] Returns an array of Projets objects
    * 
    */
   public function chercheTitre(mixed $value): array
   {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT p.id  FROM projets  as p
            WHERE  p.titre       LIKE :value
            ORDER BY p.id DESC
            ';
        
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery(['value' => "%".$value."%"]);
        return $result->fetchAllAssociative();
   }

   /**
    * @return Projets[] Returns an array of Projets objects
    * 
    */
   public function chercheTechno(mixed $value): array
   {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT p.id  FROM projets  as p
            JOIN projets_technologie AS a  ON a.projets_id = p.id
            JOIN technologie as t ON t.id = a.technologie_id
            WHERE t.technologie LIKE :value
            ORDER BY p.id DESC
            ';
        
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery(['value' => "%".$value."%"]);
        return $result->fetchAllAssociative();
    }

   public function SearchId(Int $categorie, mixed $value): array
   {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT DISTINCT p.id  FROM projets AS p

        LEFT JOIN projets_technologie AS pt 
            ON p.id = pt.projets_id
        JOIN technologie AS t 
            ON pt.technologie_id = t.id

        WHERE p.categorie_id = :categorie
            AND 
            (p.titre LIKE :value
            OR t.technologie LIKE :value)

        ';
        
        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery(['value' => "%".$value."%" ,'categorie' => $categorie]);
        return $result->fetchAllAssociative();
    }




//    /**
//     * @return Projets[] Returns an array of Projets objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Projets
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
