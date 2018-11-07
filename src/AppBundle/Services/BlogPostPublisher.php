<?php
/**
 * Created by PhpStorm.
 * User: backen
 * Date: 29.10.18
 * Time: 19:08
 */

namespace AppBundle\Services;


use AppBundle\Entity\BlogPost;
use AppBundle\Exception\BlogPostPublisherException;
use AppBundle\Exception\TargetIsNotCompatibleException;
use AppBundle\Exception\TargetNotExistsException;
use AppBundle\Interfaces\OnPublishPost;
use AppBundle\Interfaces\ThirdPartyPublish;
use Psr\Container\ContainerInterface;

class BlogPostPublisher
{
    private $handlersServices;

    /** @var ThirdPartyPublish */
    private $target;

    /** @var ContainerInterface */
    private $container;

    /**
     * BlogPostPublisher constructor.
     * @param ContainerInterface $container
     * @param iterable $handlersServices
     */
    public function __construct(ContainerInterface $container, iterable $handlersServices)
    {
        $this->handlersServices = $handlersServices;
        $this->container = $container;
    }

    /**
     * @param string $target
     * @throws TargetNotExistsException
     * @throws TargetIsNotCompatibleException
     */
    public function setTarget(string $target) {
        if($this->container->has($target)) {
            $this->target = $this->container->get($target);
            if (!($this->target instanceof ThirdPartyPublish)) {
                throw new TargetIsNotCompatibleException();
            }
        } else {
            throw new TargetNotExistsException();
        }
    }

    /**
     * @param BlogPost $blogPost
     * @throws BlogPostPublisherException
     */
    public function publish(BlogPost $blogPost) {
        if (!$this->target->publicPost($blogPost)) {
            throw new BlogPostPublisherException();
        }
        $this->runAllTaggedServices($this->target);
    }

    /**
     * This method calling all services with tag 'OnPublishPost'
     * so we haven't modify this class when we wanna add new events
     * @param ThirdPartyPublish $thirdPartyPublish
     */
    private function runAllTaggedServices(ThirdPartyPublish $thirdPartyPublish)
    {
        /** @var OnPublishPost $service */
        foreach ($this->handlersServices as $service) {
            if ($service instanceof OnPublishPost) {
                $service->setThirdPartyPublish($thirdPartyPublish);
                $service->action();
            }
        }
    }
}
