<?php
/**
 * Created by PhpStorm.
 * User: backen
 * Date: 29.10.18
 * Time: 17:48
 */

namespace AppBundle\Manager;


use AppBundle\Entity\BlogPost;
use AppBundle\Entity\Repository\BlogPostRepository;

class BlogPostManager
{

    private $blogPostRepository;

    /**
     * BlogPostManager constructor.
     * @param BlogPostRepository $blogPostRepository
     */
    public function __construct(BlogPostRepository $blogPostRepository)
    {
        $this->blogPostRepository = $blogPostRepository;
    }

    /**
     * @param BlogPost $blogPost
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addNew(BlogPost $blogPost)
    {
        $this->blogPostRepository->save($blogPost);

        //  do more staff if needed after adding new post
    }

    /**
     * @param BlogPost $blogPost
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function edit(BlogPost $blogPost)
    {
        $this->blogPostRepository->update($blogPost);

        //  do more staff if needed after updating
    }
}
