<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\BlogPost;
use Doctrine\ORM\EntityRepository;

/**
 * Class BlogPostRepository.
 */
class BlogPostRepository extends EntityRepository
{
    /**
     * @param BlogPost $entity
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(BlogPost $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * @param BlogPost $entity
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(BlogPost $entity)
    {
        $this->_em->merge($entity);
        $this->_em->flush();
    }

    /**
     * @param BlogPost $entity
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(BlogPost $entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
