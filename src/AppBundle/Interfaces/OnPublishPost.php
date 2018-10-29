<?php
/**
 * Created by PhpStorm.
 * User: backen
 * Date: 29.10.18
 * Time: 19:21
 */

namespace AppBundle\Interfaces;


interface OnPublishPost
{
    public function setThirdPartyPublish(ThirdPartyPublish $ThirdPartyPublish);

    public function action();
}
