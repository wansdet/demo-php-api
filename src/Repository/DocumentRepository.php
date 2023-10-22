<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Document>
 *
 * @method Document|null find($id, $lockMode = null, $lockVersion = null)
 * @method Document|null findOneBy(array $criteria, array $orderBy = null)
 * @method Document[]    findAll()
 * @method Document[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    public function delete(Document $document): void
    {
        $this->_em->remove($document);
        $this->_em->flush();
    }

    /**
     * @param array<string, mixed>       $criteria
     * @param array<string, string>|null $orderBy
     */
    public function findByQuery(array $criteria = [], array $orderBy = null, int $limit = null, int $offset = null): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('d')
            ->orderBy('d.createdAt', 'DESC');

        if (!empty($criteria)) {
            foreach ($criteria as $field => $value) {
                $queryBuilder->andWhere("d.$field = :$field")
                    ->setParameter($field, $value);
            }
        }

        if (!empty($orderBy)) {
            foreach ($orderBy as $field => $direction) {
                $queryBuilder->addOrderBy("d.$field", $direction);
            }
        }

        if (null !== $limit) {
            $queryBuilder->setMaxResults($limit);
        }

        if (null !== $offset) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder;
    }

    public function save(Document $document): void
    {
        $this->_em->persist($document);
        $this->_em->flush();
    }

    //    /**
    //     * @return Document[] Returns an array of Document objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Document
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
