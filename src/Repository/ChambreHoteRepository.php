<?php

namespace App\Repository;

use App\Entity\ChambreHote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<ChambreHote>
 *
 * @method ChambreHote|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChambreHote|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChambreHote[]    findAll()
 * @method ChambreHote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChambreHoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChambreHote::class);
    }

//    /**
//     * @return ChambreHote[] Returns an array of ChambreHote objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ChambreHote
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function recherche ($s)
   {
     return $this->createQueryBuilder('m')
     -> where ('m.nomChambre like :critere')
     ->setParameter('critere', '%'.$s.'%')
     ->getQuery()
     ->getResult();

   }

}
