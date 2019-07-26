<?php
/**
 *  ==================================================================
 *        文 件 名: Service.php
 *        概    要: 注册 whoops 服务
 *        作    者: IT小强
 *        创建时间: 2019-07-26 14:06
 *        修改时间:
 *        copyright (c) 2016 - 2019 mail@xqitw.cn
 *  ==================================================================
 */
declare(strict_types=1);

namespace itxq\whoops;

/**
 * 注册 whoops 服务
 * Class Service
 * @package itxq\whoops
 */
class Service extends \think\Service
{
    /**
     * 注册服务
     */
    public function register(): void
    {
        $this->app->bind(\think\exception\Handle::class, Handle::class);
    }
}