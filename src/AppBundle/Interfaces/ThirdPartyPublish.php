<?php
/**
 * Created by PhpStorm.
 * User: backen
 * Date: 29.10.18
 * Time: 19:00
 */

namespace AppBundle\Interfaces;


use AppBundle\Entity\BlogPost;

interface ThirdPartyPublish
{
    public function publicPost(BlogPost $blogPost);
}
