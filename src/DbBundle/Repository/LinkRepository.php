<?php

namespace DbBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * LinkRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LinkRepository extends EntityRepository
{
    /**
     * @return Link[] Returns an array of Link objects
    */
    public function findByIdJiha($idJiha,$mostawaTadribi)
    {
        $date = new \DateTime();
        $Jiha = [$idJiha , 25];
        return $this->createQueryBuilder('l')
            ->where('l.actif = 1')
            ->andWhere('l.dateDebInscrit <= :dateDeb')
            ->setParameter('dateDeb', $date)
            ->andWhere('l.dateFinInscrit >= :dateFin')
            ->setParameter('dateFin', $date)
            ->innerJoin('l.jihas', 'j')
            ->andWhere('j.id IN (:jihas)')
            ->setParameter('jihas', $Jiha)

            
            
//            ->innerJoin('l.mostawaTadribis', 'm')
//            ->andWhere('m.id in :mostawa')
//            ->setParameter('mostawa', $mostawaTadribi)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
}
