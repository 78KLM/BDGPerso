<?php

namespace App\Repository;

use App\Entity\Voitures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Voitures>
 *
 * @method Voitures|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voitures|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voitures[]    findAll()
 * @method Voitures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoituresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voitures::class);
    }

    public function add(Voitures $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Voitures $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findPaginatedAndFiltered(int $page = 1, int $limit = 10, array $filters = [])
{
    $queryBuilder = $this->createQueryBuilder('v');

    // Appliquer les filtres
    if (isset($filters['carburant'])) {
        $queryBuilder->andWhere('v.carburant = :carburant')
            ->setParameter('carburant', $filters['carburant']);
    }
    if (isset($filters['annee'])) {
        $queryBuilder->andWhere('v.annee = :annee')
            ->setParameter('annee', $filters['annee']);
    }
    if (isset($filters['etat'])) {
        $queryBuilder->andWhere('v.etat = :etat')
            ->setParameter('etat', $filters['etat']);
    }

    // Pagination
    $queryBuilder->setFirstResult(($page - 1) * $limit)
        ->setMaxResults($limit);

    return $queryBuilder->getQuery()->getResult();
}

public function countFiltered(array $filters = []): int
{
    $queryBuilder = $this->createQueryBuilder('v');

    // Appliquer les filtres
    if (isset($filters['carburant'])) {
        $queryBuilder->andWhere('v.carburant = :carburant')
            ->setParameter('carburant', $filters['carburant']);
    }
    if (isset($filters['annee'])) {
        $queryBuilder->andWhere('v.annee = :annee')
            ->setParameter('annee', $filters['annee']);
    }
    if (isset($filters['etat'])) {
        $queryBuilder->andWhere('v.etat = :etat')
            ->setParameter('etat', $filters['etat']);
    }

    return $queryBuilder->select('COUNT(v.id)')->getQuery()->getSingleScalarResult();
}

public function countByEtat(): array
{
    return $this->createQueryBuilder('v')
        ->select('e.type as type, COUNT(v.id) as count')
        ->innerJoin('v.etat', 'e')
        ->groupBy('e.type')
        ->getQuery()
        ->getResult();
}

//    /**
//     * @return Voitures[] Returns an array of Voitures objects
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

//    public function findOneBySomeField($value): ?Voitures
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
