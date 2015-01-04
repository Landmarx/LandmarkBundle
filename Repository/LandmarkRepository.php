<?php
namespace Landmarx\Bundle\LandmarkBundle\Repository;

class LandmarkRepository extends \Landmarx\Bundle\CoreBundle\Doctrine\ODM\MongoDB\DocumentRepository
{
    /**
     * Find recent landmarks
     * @param integer $limit
     * @return mixed
     */
    public function findRecentLandmarks($limit = 20)
    {
        return $this->getQueryBuilder()
                ->setMaxResults($limit)
                ->orderBy('l.updatedAt', 'desc')
                ->getQuery()
                -getResult();
    }
    
    /**
     * Find by radius
     * @param float $radius
     * @param array $coordinates
     * @return mixed
     */
    public function findByRadius($radius, array $coordinates)
    {
        return $this->createQueryBuilder('l')
                ->field('location.coordinates')
                ->geoNear(
                    $coordinates['latitude'],
                    $coordinates['longitude']
                )
                ->spherical(true)
                ->distanceMultiplier(3963.192) // 3963.192 for miles |  6378.137 for km
                ->maxDistance($radius);
    }
}
