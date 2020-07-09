<?php

namespace Duomai\CpsClient\Network\Http;

use Duomai\CpsClient\Exceptions\ServiceException;
use Duomai\CpsClient\Network\Interfaces\ClientInterface;
use Duomai\CpsClient\Network\Interfaces\EndpointInterface;
use GuzzleHttp\Exception\ClientException;

/**
 * Class Client
 * @author real<real@goldenname.com>
 * @since 1.0
 * @package Duomai\CpsClient\Network\Client
 */
class Client extends \GuzzleHttp\Client implements ClientInterface
{
    protected $appKey;

    protected $appSecret;

    /**
     * Client constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (isset($config["auth"])) {
            $this->appKey = isset($config["auth"]["app_key"]) ? $config["auth"]["app_key"] : "";
            $this->appSecret = isset($config["auth"]["app_secret"]) ? $config["auth"]["app_secret"] : "";
        }
        unset($config["auth"]);
        parent::__construct($config);
    }


    /**
     * @param EndpointInterface $ser
     * @return EndpointInterface
     * @throws ServiceException
     */
    public function doService(EndpointInterface $ser)
    {
        $header = [
            "Content-Type" => "application/json"
        ];
        $requestParams = [
            "verify" => false,
            "headers" => $header,
        ];
        $query = [
            "app_key" => $this->appKey,
            "timestamp" => time(),
        ];
        $body = $ser->getBody();
        $bodyStr = json_encode($body);
        if (strtolower($ser->Method()) == "get") {
            $query = array_merge($body, $query);
            $bodyStr = "";
        } else {
            $requestParams["json"] = $body;
        }
        ksort($query);
        $signStr = '';
        foreach ($query as $kev => $val) {
            $signStr .= $kev . $val;
        }
        $query["sign"] = strtoupper(md5($this->appSecret . $signStr . $bodyStr . $this->appSecret));
        $requestParams["query"] = $query;
        try {
            $response = $this->request($ser->Method(), $ser->Service(), $requestParams);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            $response = $e->getResponse();
        }
        $ser->SetHttpResult($response);
        return $ser;
    }
}