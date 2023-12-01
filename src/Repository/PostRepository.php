<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function getRandomImages(int $limit): array
    {
        // STEP 5 Prevedere un pulsante che mostra 10 immagini random tra tutte quelle presenti a DB

        $entityManager = $this->getEntityManager();

        // Ottieni il numero totale di entità nella tabella
        $totalEntities = $entityManager
            ->createQuery('SELECT COUNT(p.id) FROM App\Entity\Post p')
            ->getSingleScalarResult();

        // Genera un set casuale di indici
        $randomIndexes = range(0, $totalEntities - 1);
        shuffle($randomIndexes);

        // La lunghezza effettiva dell'array di indici generati
        $limit = min(10, count($randomIndexes));

        // Seleziona le entità corrispondenti agli indici generati casualmente
        $query = $entityManager->createQuery(
            'SELECT p FROM App\Entity\Post p WHERE p.id IN (:randomIndexes)'
        )->setParameter('randomIndexes', array_slice($randomIndexes, 0, $limit));

        $results = $query->getResult();

        return $results;
    }

    //    /**
    //     * @return Post[] Returns an array of Post objects
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

    //    public function findOneBySomeField($value): ?Post
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
