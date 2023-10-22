<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\BlogPostComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BlogPostComment>
 *
 * @method BlogPostComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPostComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPostComment[]    findAll()
 * @method BlogPostComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPostComment::class);
    }

    public function delete(BlogPostComment $blogPostComment): void
    {
        $this->_em->remove($blogPostComment);
        $this->_em->flush();
    }

    public function save(BlogPostComment $blogPostComment): void
    {
        $this->_em->persist($blogPostComment);
        $this->_em->flush();
    }

    //    /**
    //     * @return BlogPostComment[] Returns an array of BlogPostComment objects
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

    //    public function findOneBySomeField($value): ?BlogPostComment
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
