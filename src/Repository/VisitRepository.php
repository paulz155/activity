<?php

namespace App\Repository;

use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Visit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visit[]    findAll()
 * @method Visit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Visit::class);
    }

    public function findAllGroupByUrl($page = null, $limit = 2): array {
        $entityManager = $this->getEntityManager();
        
        $q = 'SELECT v.url, count(v.id) as count, max(v.data) as last FROM App\Entity\Visit v GROUP BY v.url';

        $query = $entityManager->createQuery($q);
        if(!is_null($page)) {
            $query->setFirstResult($page * $limit);
            $query->setMaxResults($limit);
        }

        return $query->getResult();
    }

    public function countAllGroupByUrl($page = null): int {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT count(DISTINCT v.url) as count FROM App\Entity\Visit v'
        );

        // возвращает массив объектов Продуктов
        return $query->getResult()[0]['count'];
    }

}
