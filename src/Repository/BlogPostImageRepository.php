<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\BlogPostImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BlogPostImage>
 *
 * @method BlogPostImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPostImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPostImage[]    findAll()
 * @method BlogPostImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPostImage::class);
    }

    //    /**
    //     * @return BlogPostImage[] Returns an array of BlogPostImage objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BlogPostImage
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
