<?php
/**
 * Created by PhpStorm.
 * User: backen
 * Date: 29.10.18
 * Time: 20:24
 *
 * Example class for check tags is working
 */

namespace AppBundle\Services;

use AppBundle\Interfaces\OnPublishPost;
use AppBundle\Interfaces\ThirdPartyPublish;

class SendNotification implements OnPublishPost
{

    public function setThirdPartyPublish(ThirdPartyPublish $ThirdPartyPublish)
    {
        // TODO: Implement setThirdPartyPublish() method.
    }

    public function action()
    {
        // TODO: Implement action() method.
    }
}
