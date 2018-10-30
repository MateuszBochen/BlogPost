<?php
/**
 * Created by PhpStorm.
 * User: backen
 * Date: 29.10.18
 * Time: 19:36
 */

namespace AppBundle\Services;


use AppBundle\Entity\BlogPost;
use AppBundle\Interfaces\ThirdPartyPublish;

class PublishOnTwitter implements ThirdPartyPublish
{

    public function publicPost(BlogPost $blogPost) : bool
    {
        // TODO: Implement publicPost() method.
        return false;
    }
}
