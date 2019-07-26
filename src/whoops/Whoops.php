<?php
/**
 *  ==================================================================
 *        文 件 名: Whoops.php
 *        概    要: Whoops
 *        作    者: IT小强
 *        创建时间: 2019-07-26 13:52
 *        修改时间:
 *        copyright (c) 2016 - 2019 mail@xqitw.cn
 *  ==================================================================
 */
declare(strict_types=1);

namespace itxq\whoops;

use Whoops\Handler\Handler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Class Whoops
 * @package itxq\whoops
 */
class Whoops
{
    private $run;

    /**
     * Whoops constructor.
     * @param \Whoops\Run $run
     */
    public function __construct(Run $run)
    {
        $this->run = $run;
        $this->run->register();
    }

    public function pushHandler($handler): void
    {
        if (false === $handler instanceof Handler) {
            return;
        }
        if ($handler instanceof PrettyPageHandler) {
            $handler->setPageTitle('哇哦！框架出错了！');
        }
        $this->run->pushHandler($handler);
    }

    public function getHandleException(\Throwable $e): String
    {
        return $this->run->handleException($e);
    }
}