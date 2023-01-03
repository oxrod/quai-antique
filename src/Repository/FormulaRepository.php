<?php

namespace App\Repository;

use App\Entity\Formula;
use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Form;

/**
 * @extends ServiceEntityRepository<Formula>
 *
 * @method Formula|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formula|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formula[]    findAll()
 * @method Formula[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormulaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formula::class);
    }

    public function save(Formula $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Formula $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ?Formula[] Returns an array of Formula objects
//     */
//    public function findByMenu($menuId): ?Formula
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.menus = :val')
//            ->setParameter('val', $menuId)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Formula
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
