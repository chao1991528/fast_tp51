<?php

namespace app\common\behavior;

use think\facade\Config;
use think\facade\Env;
use think\facade\Lang;
use think\Request;
use think\Loader;

class Common
{

    public function moduleInit(Request $request)
    {
        // 设置mbstring字符编码
        mb_internal_encoding("UTF-8");

        // 如果修改了index.php入口地址，则需要手动修改cdnurl的值
        $url = preg_replace("/\/(\w+)\.php$/i", '', $request->root());
        // 如果未设置__CDN__则自动匹配得出
        if (!Config::get('view_replace_str.__CDN__'))
        {
            Config::set('view_replace_str.__CDN__', $url);
        }
        // 如果未设置__PUBLIC__则自动匹配得出
        if (!Config::get('view_replace_str.__PUBLIC__'))
        {
            Config::set('view_replace_str.__PUBLIC__', $url . '/');
        }
        // 如果未设置__ROOT__则自动匹配得出
        if (!Config::get('view_replace_str.__ROOT__'))
        {
            Config::set('view_replace_str.__ROOT__', preg_replace("/\/public\/$/", '', $url . '/'));
        }
        // 如果未设置cdnurl则自动匹配得出
        if (!Config::get('site.cdnurl'))
        {
            Config::set('site.cdnurl', $url);
        }
        // 如果未设置cdnurl则自动匹配得出
        if (!Config::get('upload.cdnurl'))
        {
            Config::set('upload.cdnurl', $url);
        }
        if (Config::get('app_debug'))
        {
            // 如果是调试模式将version置为当前的时间戳可避免缓存
            Config::set('site.version', time());
            // 如果是开发模式那么将异常模板修改成官方的
            Config::set('exception_tmpl', Env::get('think_path') . 'tpl' . DIRECTORY_SEPARATOR . 'think_exception.tpl');
        }
        // 如果是trace模式且Ajax的情况下关闭trace
        if (Config::get('app_trace') && $request->isAjax())
        {
            Config::set('app_trace', false);
        }
        // 切换多语言
        if (Config::get('lang_switch_on') && $request->get('lang'))
        {
            \think\facade\Cookie::set('think_var', $request->get('lang'));
        }
        // Form别名
        class_alias('fast\\Form', 'Form');
    }

    public function addonBegin(&$request)
    {
        // 加载插件语言包
        Lang::load([
            Env::get('app_path') . 'common' . DS . 'lang' . DS . $request->langset() . DS . 'addon.php',
        ]);
        $this->moduleInit($request);
    }

}
