<?php
/**
 * Created by PhpStorm.
 * User: backen
 * Date: 30.10.18
 * Time: 19:40
 */

namespace AppBundle\Factory;


use AppBundle\Services\BlogPostPublisher;


class PublisherFactory
{

    private $tags;

    public function __construct($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param $target
     * @return BlogPostPublisher
     */
    public function createPublisher($target)
    {
        $newsletterManager = new BlogPostPublisher(new $target, $this->tags);
        return $newsletterManager;
    }
}
