<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Profile>
 *
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    public function save(Profile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Profile $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findEntitiesByString($str)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p 
            FROM App\Entity\Profile p 
            WHERE p.ingameName LIKE :str'
        )->setParameter('str', '%' . $str . '%')
            ->setMaxResults(4);;

        return $query->getResult();
    }

    public function search($str, $country, $game, $gameRole): array
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $query = $queryBuilder
            ->select('p')
            ->from(Profile::class, 'p')
            ->leftJoin('p.user', 'u')
            ->leftJoin('p.gameRole', 'gr')
            ->where('p.ingameName LIKE :str')
            ->orderBy('CASE WHEN (u.premiumEnd >= CURRENT_DATE()) THEN 0 ELSE 1 END')
            ->addOrderBy('p.createdAt', 'DESC')
            ->setParameter('str', '%' . $str . '%');

        if (!empty($country)) {
            $query->andWhere('u.country = :country')
                ->setParameter('country', $country);
        }

        if (!empty($game)) {
            $query->andWhere('p.game = :game')
                ->setParameter('game', $game);
        }

        if (!empty($gameRole)) {
            $query->andWhere('gr.id = :gameRole')
                ->setParameter('gameRole', $gameRole);
        }


        $query->setMaxResults(40);

        return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return Profile[] Returns an array of Profile objects
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

    //    public function findOneBySomeField($value): ?Profile
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
