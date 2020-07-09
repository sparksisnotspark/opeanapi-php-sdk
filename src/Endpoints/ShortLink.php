<?php

namespace Duomai\CpsClient\Endpoints;

use Duomai\CpsClient\Network\EndpointBase;

/**
 * 短链接
 * @author real<real@goldenname.com>
 * @since 1.0
 * @package Duomai\CpsClient\Endpoints
 */
class ShortLink extends EndpointBase
{
    public function __construct($url)
    {
        $this->params = [
            "url" => $url,
        ];
    }

    public function Service()
    {
        return "base.cpslink/v1/links/short";
    }

    public function Method()
    {
        return "Post";
    }

    public function getResult()
    {
        return $this->data["data"];
    }
}