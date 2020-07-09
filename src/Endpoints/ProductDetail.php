<?php


namespace Duomai\CpsClient\Endpoints;


use Duomai\CpsClient\Exceptions\ServiceException;
use Duomai\CpsClient\Network\EndpointBase;

/**
 * 商品详情
 * @author real<real@goldenname.com>
 * @since 1.0
 * @package Duomai\CpsClient\Endpoints
 */
class ProductDetail extends EndpointBase
{
    private $platform = Products::PLATFORM_JDUnion;

    private $itemId;

    /**
     * ProductDetail constructor.
     * @param $itemId
     * @param $platform
     * @throws ServiceException
     */
    public function __construct($itemId, $platform)
    {
        if (empty($itemId)) {
            throw new ServiceException("商品id不能为空");
        }
        $this->platform = $platform;
        $this->itemId = $itemId;
    }

    public function Method()
    {
        return "GET";
    }

    public function Service()
    {
        return "base.cpslink/v1/{$this->platform}/products/{$this->itemId}";
    }

    public function getResult()
    {
        return $this->data["data"];
    }
}