<?php
include_once __DIR__ . "/../vendor/autoload.php";

// 初始化
use Duomai\CpsClient\Client;
use Duomai\CpsClient\Endpoints\Products;

$config = [
    "host" => "https://platform.duomai.com/apis/",
    "auth" => [
        "app_key" => "",
        "app_secret" => "",
    ]
];
$client = new Client($config);

// 获取推广链接
//$data = $client->chanLinkForUrl(27, "https://item.jd.com/44034746681.html");
//$data = $client->chanLinkForAds(27, 61);
//$data = $client->chanLink(27, 0, 61, "https://item.jd.com/53272656742.html", [
//    "coupon" => "https://coupon.m.jd.com/coupons/show.action?linkKey=AAROH_xIpeffAs_-naABEFoe4cBnSa8GxbSbocVNklnakmZjGOpm7ZvMCCXXyopOOQqE2L6xW84IwUhIMTLFasNb53j1eg",
//    "euid" => "test",
//], true);
//print_r($data);
//die;
// 获取短链接
//$url = $client->shortLink("https://union-click.jd.com/jdc?e=16282&p=AyIGZRtSFgQUB1ISUhIyFgVWHVgSBhUBUBhrUV1KWQorAlBHU0VeBUVOWk1RAk8ECllHGAdFBwtaV1MJBAJQXk8JF0EfGQYQBFMYXBEFFAJWDBsZdWt7Nm8SQFxlfj1%2FL2ZXRWcKbC1iYWVEI2k7cWJmbBBsOXFgcl5VXCxsdndkMXtddXBuVyJvOxNiYGMNbBJ%2BXWYFMXsvTGFFYB18JHV2YkUCTTBecVt7U2wibVFxZD5ELHxmQmcMbBp1WnF1IkI4S2FaZwZ7AWpAZn4PfS9hfVV%2FLEk5YXFbQiNyM3F1WmdBGS4lYVtsK1sMEXxyDjMZA28cGlNcQyMTch4LZRxeEgQbDlAfaxUFEQ5WK1sUBRYGUh5YJQITNxR1WxQCFA5VG1slAyIHURNeFgsbA1wfWREKIgddHGvBl7nf3owJVEDLt%2FDN8bsyIjdWK1sSARsEZStbFjIRNwt1WkYCGlNdTlx7WEBTCRMOTAF8BFIeWxQBEwVlGVoUABA%3D
//");
//print_r($url);
// 多麦链接加解密
//$url = $client->encryptLink("https://c.duomai.com/track.php?site_id=27&lid=99&pf=dxk&skuid=53272656742&aid=61&euid=test&t=https%3A%2F%2Fcoupon.m.jd.com%2Fcoupons%2Fshow.action%3FlinkKey%3DAAROH_xIpeffAs_-naABEFoe4cBnSa8GxbSbocVNklnakmZjGOpm7ZvMCCXXyopOOQqE2L6xW84IwUhIMTLFasNb53j1eg
//");
//print_r($url."\n");
//$url = $client->decryptLink($url);
//print_r($url."\n");
// 京东商品
//$data = $client->productList([
//    "query"=>"可乐"
//]);
//print_r($data);
// 1688商品
//$data = $client->productList([
//    "query"=>"可乐"
//],Products::PLATFORM_1688);
//print_r($data);
// 有赞商品列表
//$data = $client->productList([], Products::PLATFORM_YOUZAN);
//print_r($data);
// 拼多多商品列表
//$data = $client->productList([
//    "query"=>"可乐"
//], Products::PLATFORM_PDD);
//print_r($data);
// 考拉商品列表
//$data = $client->productList([
//    "query"=>"可乐"
//], Products::PLATFORM_KAOLA);
//print_r($data);
// 唯品会商品列表
//$data = $client->productList([
//    "query"=>"可乐"
//], Products::PLATFORM_VIP);
//print_r($data);
// 苏宁商品列表
//$data = $client->productList([
//    "query"=>"可乐"
//], Products::PLATFORM_SUNING);
//print_r($data);