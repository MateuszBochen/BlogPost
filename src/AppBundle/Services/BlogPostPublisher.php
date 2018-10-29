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

    private $blogPostRepository;
    private $handlersServices;

    /**
     * BlogPostPublisher constructor.
     * @param iterable $handlersServices
     * @param BlogPostRepository $blogPostRepository
     */
    public function __construct(iterable $handlersServices, BlogPostRepository $blogPostRepository)
    {
        $this->handlersServices = $handlersServices;
        $this->blogPostRepository = $blogPostRepository;
    }

    /**
     * @param ThirdPartyPublish $thirdPartyPublishService
     * @param BlogPost $blogPost
     * @throws BlogPostPublisherException
     */
    public function publish(ThirdPartyPublish $thirdPartyPublishService, BlogPost $blogPost) {
        if(!$thirdPartyPublishService->publicPost($blogPost)) {
            throw new BlogPostPublisherException('Unable add post');
        }
        $this->runAllTaggedServices($thirdPartyPublishService);
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
