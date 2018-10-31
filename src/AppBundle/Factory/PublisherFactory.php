<?php
/**
 * Created by PhpStorm.
 * User: backen
 * Date: 30.10.18
 * Time: 19:40
 */

namespace AppBundle\Factory;


use AppBundle\Exception\TargetNotExistsException;
use AppBundle\Services\BlogPostPublisher;
use AppBundle\Interfaces\PublisherFactory as PublisherFactoryInterface;

class PublisherFactory implements PublisherFactoryInterface
{
    private $tags;

    public function __construct(iterable $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param $target
     * @return BlogPostPublisher
     * @throws TargetNotExistsException
     */
    public function createPublisher(string $target)
    {
        if(!class_exists($target)) {
            throw new TargetNotExistsException();
        }

        $newsletterManager = new BlogPostPublisher(new $target, $this->tags);
        return $newsletterManager;
    }
}
