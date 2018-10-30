<?php
/**
 * Created by PhpStorm.
 * User: backen
 * Date: 29.10.18
 * Time: 19:08
 */

namespace AppBundle\Services;


use AppBundle\Entity\BlogPost;
use AppBundle\Entity\Repository\BlogPostRepository;
use AppBundle\Exception\BlogPostPublisherException;
use AppBundle\Interfaces\OnPublishPost;
use AppBundle\Interfaces\ThirdPartyPublish;

class BlogPostPublisher
{
    private $handlersServices;
    private $target;

    /**
     * BlogPostPublisher constructor.
     * @param ThirdPartyPublish $target
     * @param iterable $handlersServices
     */
    public function __construct(ThirdPartyPublish $target, iterable $handlersServices)
    {
        $this->handlersServices = $handlersServices;
        $this->target = $target;
    }

    public function setTarget(string $target) {
        $this->targrt = new $target();
    }

    /**
     * @param BlogPost $blogPost
     */
    public function publish(BlogPost $blogPost) {
        $this->target->publicPost($blogPost);
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
