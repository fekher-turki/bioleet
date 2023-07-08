<?php

namespace App\Repository;

use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function save(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Team $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTeamsNotOwnedByUser(User $user)
    {
        return $this->createQueryBuilder('team')
            ->leftJoin('team.players', 'profile')
            ->andWhere('profile.user = :user')
            ->andWhere('profile.team IS NOT NULL')
            ->andWhere('team.owner != :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function findEntitiesByString($str)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT t 
            FROM App\Entity\Team t 
            WHERE t.teamName LIKE :str'
        )->setParameter('str', '%'.$str.'%')
        ->setMaxResults(4);;

        return $query->getResult();
    }

    public function search($str, $country, $game): array
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $query = $queryBuilder
            ->select('t')
            ->from(Team::class, 't')
            ->leftJoin('t.owner', 'u')
            ->where('t.teamName LIKE :str')
            ->orderBy('CASE WHEN (u.premiumEnd >= CURRENT_DATE()) THEN 0 ELSE 1 END')
            ->addOrderBy('t.createdAt', 'DESC')
            ->setParameter('str', '%' . $str . '%');

        if (!empty($country)) {
            $query->andWhere('t.country = :country')
                ->setParameter('country', $country);
        }

        if (!empty($game)) {
            $query->andWhere('t.game = :game')
                ->setParameter('game', $game);
        }


        $query->setMaxResults(40);

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Team[] Returns an array of Team objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Team
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
