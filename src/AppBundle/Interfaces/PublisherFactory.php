<?php
/**
 * Created by PhpStorm.
 * User: backen
 * Date: 31.10.18
 * Time: 07:23
 */

namespace AppBundle\Interfaces;


interface PublisherFactory
{
    public function __construct(iterable $taggedServices);

    public function createPublisher(string $className);
}