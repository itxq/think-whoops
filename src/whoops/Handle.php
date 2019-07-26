<?php
/**
 *  ==================================================================
 *        文 件 名: Handle.php
 *        概    要: Whoops系统异常处理类
 *        作    者: IT小强
 *        创建时间: 2019-07-26 13:56
 *        修改时间:
 *        copyright (c) 2016 - 2019 mail@xqitw.cn
 *  ==================================================================
 */
declare(strict_types=1);

namespace itxq\whoops;

use Whoops\Run;
use Throwable;
use think\App;
use think\Response;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use think\exception\HttpException;
use think\exception\ValidateException;

/**
 * Whoops系统异常处理类
 * Class Handle
 * @package itxq\whoops
 */
class Handle extends \think\exception\Handle
{
    /**
     * @var \itxq\whoops\Whoops
     */
    private $whoops;

    /**
     * Handle constructor.
     * @param \think\App  $app
     * @param \Whoops\Run $run
     */
    public function __construct(App $app, Run $run)
    {
        parent::__construct($app);
        $this->whoops = new Whoops($run);
    }

    /**
     * Render an exception into an HTTP response.
     * @param \think\Request $request
     * @param \Throwable     $e
     * @return \think\Response
     */
    public function render($request, Throwable $e): Response
    {
        // 参数验证错误
        if ($e instanceof ValidateException) {
            return json($e->getError(), 422);
        }

        if (!$this->app->isDebug()) {
            // 其他错误交给系统处理
            return parent::render($request, $e);
        }

        // 请求异常
        $this->whoops->pushHandler(new PrettyPageHandler());
        if ($e instanceof HttpException && $request->isAjax()) {
            $this->whoops->pushHandler(new JsonResponseHandler());
        }
        $content = $this->whoops->getHandleException($e);
        return Response::create(
            $content,
            'view',
            (int)$e->getStatusCode()
        );
    }
}