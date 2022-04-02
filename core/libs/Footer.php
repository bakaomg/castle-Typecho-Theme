<?php
/**
 * Castle Footer Class
 * Last Update: 2021/04/13
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_Footer
{

  /**
   * 底部输出
   */
  public static function export($footer)
  {
    if (Castle_Libs::isDev() === true) {
      $castleJS = 'static/js/castle.js';
    } else {
      $castleJS = 'static/js/castle.min.js';
    }

    //统计代码
    echo (Helper::options()->statisticsCode) ? '<div class="mdui-hidden">' . Helper::options()->statisticsCode . '</div>' . "\n " : NULL;

    //登录状态
    echo '<script src="' . Castle_Libs::index('/?action=loginStatus', false) . '"></script>' . "\n  ";

    //siteConfig
    if (Castle_Libs::hasPlugin('Castle') && Helper::options()->PluginCache && in_array('siteConfig', Helper::options()->PluginCache)) {
      echo '<script src="' . Castle_Plugin::siteConfig(Castle_API::siteConfig(true)) . '?hash=' . Castle_Plugin::getSiteConfigMd5() . '"></script>' . "\n  ";
    } else {
      echo '<script src="' . Castle_Libs::index('/?action=siteConfig', false) . '"></script>' . "\n  ";
    }

    //MDUI
    echo '<script src="' . Castle_Libs::resources('static/js/mdui.min.js', true) . '"></script>' . "\n  ";

    if (Helper::options()->PJAX && in_array('PJAX_Switch', Helper::options()->PJAX)) {
      //PJAX
      echo '<script src="' . Castle_Libs::resources('static/js/pjax.min.js', true) . '"></script>' . "\n  ";

      //Nprogress
      echo '<script src="' . Castle_Libs::resources('static/js/nprogress.min.js', true) . '"></script>' . "\n  ";
    }

    if (Castle_Libs::hasPlugin('Castle')) {
      $CastlePluginJS = (Castle_Libs::isDev() === true) ? 'static/js/bangumi.js' : 'static/js/bangumi.min.js';
      echo '<script src="' . Castle_Libs::resources($CastlePluginJS, true) . '"></script>' . "\n  ";
    }

    echo
      //baguetteBox
      '<script src="' . Castle_Libs::resources('static/js/baguetteBox.min.js', true) . '"></script>' . "\n  " .

        //Lazyload
        '<script src="' . Castle_Libs::resources('static/js/lazyload.min.js', true) . '"></script>' . "\n  " .

        //HighLight
        '<script src="' . Castle_Libs::resources('static/js/highlight.min.js', true) . '"></script>' . "\n  " .

        //smoothscroll
        '<script src="' . Castle_Libs::resources('static/js/smoothscroll.min.js', true) . '"></script>' . "\n  " .
        
        '<script src="' . Castle_Libs::resources('static/js/qrcode.min.js', true) . '"></script>' . "\n  ";

    if (Helper::options()->TocSwitch == '1') {
      //Tocbot
      echo '<script src="' . Castle_Libs::resources('static/js/tocbot.min.js', true) . '"></script>' . "\n  ";
    }

    //主题核心JS
    echo '<script src="' . Castle_Libs::resources($castleJS, true) . '"></script>' . "\n";
  }

  /**
   * 目录树透明度
   */
  public static function tocTransparent()
  {
    $TocTransparent = Helper::options()->TocTransparent;
    switch ($TocTransparent) {
      case '0':
        break;

      case '1':
        return ' moe-toc-transparent-10';
        break;

      case '2':
        return ' moe-toc-transparent-20';
        break;

      case '3':
        return ' moe-toc-transparent-30';
        break;

      default:
        break;
    }
  }
}
