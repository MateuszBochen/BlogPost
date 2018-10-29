<?php
/**
 * Created by PhpStorm.
 * User: backen
 * Date: 29.10.18
 * Time: 19:30
 */

namespace AppBundle\Services;


use AppBundle\Entity\BlogPost;
use AppBundle\Interfaces\ThirdPartyPublish;

class PublishOnFacebook implements ThirdPartyPublish
{

    public function publicPost(BlogPost $blogPost)
    {
        // TODO: Implement publicPost() method.

        return true;
    }
}
