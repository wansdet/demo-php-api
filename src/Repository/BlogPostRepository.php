<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\BlogPost;
use App\Entity\BlogPostComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BlogPost>
 *
 * @method BlogPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPost[]    findAll()
 * @method BlogPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPost::class);
    }

    public function delete(BlogPost $blogPost): void
    {
        $this->getEntityManager()->remove($blogPost);
        $this->getEntityManager()->flush();
    }

    /**
     * @return array<BlogPost>
     */
    public function findFeaturedBlogPosts(): array
    {
        return $this->createQueryBuilder('b')
            //->join('b.blogPostComments', 'c')
            ->where('b.status = :status')
            //->andWhere('c.status = :commentStatus')
            ->andWhere('b.featured IS NOT NULL')
            ->setParameter('status', BlogPost::STATUS_PUBLISHED)
            //->setParameter('commentStatus', BlogPostComment::STATUS_PUBLISHED)
            ->orderBy('b.featured', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<BlogPost>
     */
    public function findAnnualBlogPostsByAuthorsReport(): array
    {
        return $this->createQueryBuilder('b')
            ->select('COUNT(b) as blogPostCount', 'b.createdBy as author', 'YEAR(b.createdAt) as year')
            ->andWhere('b.status = :status')
            ->setParameter('status', BlogPost::STATUS_PUBLISHED)
            ->groupBy('b.createdBy', 'year')
            ->orderBy('year', 'ASC')
            ->addOrderBy('author')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<BlogPost>
     */
    public function findAnnualBlogPostsByCategoriesReport(): array
    {
        return $this->createQueryBuilder('b')
            ->select('COUNT(b) as blogPostCount', 'bc.blogCategoryName', 'YEAR(b.createdAt) as year')
            ->leftJoin('b.blogCategory', 'bc')
            ->andWhere('b.status = :status')
            ->setParameter('status', BlogPost::STATUS_PUBLISHED)
            ->groupBy('bc.blogCategoryName', 'year')
            ->orderBy('year', 'ASC')
            ->addOrderBy('bc.blogCategoryName')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<BlogPost>
     */
    public function findMonthlyBlogPostsByAuthorsReport(): array
    {
        return $this->createQueryBuilder('b')
            ->select('COUNT(b) as blogPostCount', 'b.createdBy as author', 'MONTH(b.createdAt) - 1 as month', 'YEAR(b.createdAt) as year')
            ->andWhere('b.status = :status')
            ->setParameter('status', BlogPost::STATUS_PUBLISHED)
            ->groupBy('b.createdBy', 'month', 'year')
            ->orderBy('year', 'ASC')
            ->addOrderBy('month', 'ASC')
            ->addOrderBy('author')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<BlogPost>
     */
    public function findMonthlyBlogPostsByCategoriesReport(): array
    {
        return $this->createQueryBuilder('b')
            ->select('COUNT(b) as blogPostCount', 'bc.blogCategoryName', 'MONTH(b.createdAt) - 1 as month', 'YEAR(b.createdAt) as year')
            ->leftJoin('b.blogCategory', 'bc')
            ->andWhere('b.status = :status')
            ->setParameter('status', BlogPost::STATUS_PUBLISHED)
            ->groupBy('bc.blogCategoryName', 'month', 'year')
            ->orderBy('year', 'ASC')
            ->addOrderBy('month', 'ASC')
            ->addOrderBy('bc.blogCategoryName')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array<string, mixed> $criteria
     *
     * @return array<BlogPost>
     */
    public function findPublishedBlogPosts(array $criteria = []): array
    {
        $queryBuilder =
        $this->createQueryBuilder('b')
            //->join('b.blogPostComments', 'c')
            ->where('b.status = :status')
            //->andWhere('c.status = :commentStatus')
            ->setParameter('status', BlogPost::STATUS_PUBLISHED)
            //>setParameter('commentStatus', BlogPostComment::STATUS_PUBLISHED)
            ->orderBy('b.id', 'DESC');

        if (!empty($criteria)) {
            foreach ($criteria as $field => $value) {
                $queryBuilder->andWhere("b.$field = :$field")
                    ->setParameter($field, $value);
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function save(BlogPost $blogPost): void
    {
        $this->getEntityManager()->persist($blogPost);
        $this->getEntityManager()->flush();
    }
}
