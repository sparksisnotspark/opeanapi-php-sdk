<?php
namespace Duomai\CpsClient;

use Duomai\CpsClient\Endpoints\ChanLink;
use Duomai\CpsClient\Endpoints\DecryptLink;
use Duomai\CpsClient\Endpoints\EncryptLink;
use Duomai\CpsClient\Endpoints\ProductDetail;
use Duomai\CpsClient\Endpoints\Products;
use Duomai\CpsClient\Endpoints\ShortLink;
use Duomai\CpsClient\Exceptions\ServiceException;
use Duomai\CpsClient\Network\Http\Client as NetClient;
use Duomai\CpsClient\Network\Interfaces\ClientInterface;
use Duomai\CpsClient\Network\Interfaces\EndpointInterface;

/**
 * 开发接口请求客户端工厂
 * @author real<real@goldenname.com>
 * @since 1.0
 * @package Duomai\CpsClient
 */
class Client
{
    /**
     * @var ClientInterface|null
     */
    protected $client;

    /**
     * @param $config
     * @return NetClient
     */
    private function getHttpClient($config)
    {
        return new NetClient($config);
    }

    /**
     * @param $rpc
     * @param $host
     * @param float $timeout
     * @param null $auth
     * @return NetClient|null
     */
    protected function getClient($rpc, $host, $timeout = 5.0, $auth = null)
    {
        switch ($rpc) {
            case "http":
                return $this->getHttpClient([
                    'base_uri' => $host,
                    'timeout' => $timeout,
                    "auth" => $auth,
                ]);
            default:
                return null;
        }
    }

    /**
     * 初始化
     * AlimamaService constructor.
     * @throws ServiceException
     */
    public function __construct($config)
    {
        if(empty($config["rpc"])){
            $config["rpc"] = "http";
        }
        if(empty($config["auth"])){
            throw new ServiceException("service config auth is empty");
        }
        if (empty($config["host"]) || empty($config["rpc"])) {
            throw new ServiceException("service config host is empty");
        }
        $this->client = $this->GetClient($config["rpc"], $config["host"],30, $config["auth"]);
        if (empty($this->client)) {
            throw new ServiceException("client init error");
        }
    }

    /**
     * 请求服务
     * @param EndpointInterface $ser
     * @return array
     * @throws ServiceException
     */
    public function doService(EndpointInterface $ser)
    {
        $response = $this->client->doService($ser);
        if ($response->IsSuccess()) {
            return $response->getResult();
        } else {
            throw new ServiceException($response->Error());
        }
    }

    /**
     * 获取推广链接 url productID adsID 可选择传入。 url优先解析，adsId会强制修正计划
     * @param string $siteID 推广位id
     * @param int $productID 多麦商品id
     * @param int $adsID 多麦推广计划id
     * @param string $url 支持商家的单品链接。支持 京东首页店铺活动 pdd活动店铺 淘口令 等
     * @param array $ext 接受 coupon 与 euid字段 ["coupon"=>"", "euid"=>""]
     * @param bool $original 是否需要原始链接 需要原始链接会花费更多时间
     * @return array
     * @throws ServiceException
     */
    public function chanLink($siteID, $productID = 0, $adsID = 0, $url = "", $ext = [], $original = false)
    {
        $endpoint = new ChanLink($siteID, $productID, $adsID, $url, $original, $ext);
        return $this->doService($endpoint);
    }

    /**
     * 根据url获取推广链接
     * @param $siteID
     * @param $url
     * @param $ext
     * @return array
     * @throws ServiceException
     */
    public function chanLinkForUrl($siteID, $url, $ext = [])
    {
        return $this->chanLink($siteID, 0, 0, $url, $ext);
    }

    /**
     * 根据计划获取推广链接
     * @param $siteID
     * @param $adsId
     * @param $ext
     * @return array
     * @throws ServiceException
     */
    public function chanLinkForAds($siteID, $adsId, $ext = [])
    {
        return $this->chanLink($siteID, 0, $adsId, "", $ext);
    }

    /**
     * 根据多麦商品库id获取推广链接
     * @param $siteID
     * @param $productId
     * @param $ext
     * @return array
     * @throws ServiceException
     */
    public function chanLinkForProduct($siteID, $productId, $ext = [])
    {
        return $this->chanLink($siteID, $productId, 0, "", $ext);
    }


    /**
     * 转短链
     * @param $url
     * @return array
     * @throws ServiceException
     */
    public function shortLink($url)
    {
        $endpoint = new ShortLink($url);
        return $this->doService($endpoint);
    }

    /**
     * 解密链接
     * @param $url
     * @return array
     * @throws ServiceException
     */
    public function decryptLink($url)
    {
        $endpoint = new DecryptLink($url);
        return $this->doService($endpoint);
    }

    /**
     * 加密链接
     * @param $url
     * @return array
     * @throws ServiceException
     */
    public function encryptLink($url)
    {
        $endpoint = new EncryptLink($url);
        return $this->doService($endpoint);
    }

    /**
     * 商品列表
     * @param $queryParams
     * @param string $platform
     * @return array
     * @throws ServiceException
     */
    public function productList($queryParams, $platform=Products::PLATFORM_JDUnion)
    {
        $endpoint = new Products($queryParams, $platform);
        return $this->doService($endpoint);
    }

    /**
     * 商品详情
     * @param $itemId
     * @param string $platform
     * @return array
     * @throws ServiceException
     */
    public function productDetail($itemId, $platform=Products::PLATFORM_JDUnion)
    {
        $endpoint = new ProductDetail($itemId, $platform);
        return $this->doService($endpoint);
    }
}