<?php

/**
 * Castle Header Class
 * Last Update: 2022/04/04
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_Header
{

     /**
      * 站点标题
      *
      * @param $archive    Widget_Archive
      * @param $before     标题前缀
      * @param $end        归档标题与站点标题的间隔符合
      * @param $siteTitle  是否附带站点标题
      * @param $outType    标题输出方式
      **/
     public static function title(Widget_Archive $archive, $before = ' &raquo; ', $end = '', bool $siteTitle = true, bool $outType = false)
     {
          //归档标题
          $ArchiveTitle = $archive->getArchiveTitle();

          //归档类型
          $ArchiveType = $archive->getArchiveType();

          $ArchiveTitleArr = [
               'category'  =>  '分类 %s 下的文章',
               'search'    =>  '包含关键字 %s 的文章',
               'tag'       =>  '标签 %s 下的文章',
               'author'    =>  '%s 发布的文章'
          ];

          //是否输出站点标题
          $siteTitle = $siteTitle === true ? $end . Helper::options()->title : NULL;

          //解析归档标题
          if ($ArchiveTitle) {
               $define = '%s';
               if (is_array($ArchiveTitleArr) && !empty($ArchiveTitleArr[$ArchiveType])) {
                    $define = $ArchiveTitleArr[$ArchiveType];
               }

               $output = $before . sprintf($define, $ArchiveTitle) . $siteTitle;
          } else {
               $output = Helper::options()->title;
          }

          //最终输出
          if ($outType === true) {
               echo $output;
          } else {
               return $output;
          }
     }

     /**
      * 头部输出
      */
     public static function export($header)
     {
          if (Castle_Libs::isDev() === true) {
               $castlePlugin = 'static/css/bangumi.css';
               $castleCss = 'static/css/castle.css';
               $castleNewUICss = 'static/css/castle.newui.css';
               $castleThemeCss = 'static/css/castle.theme.css';
               $castleAplayerCss = 'static/css/APlayer.css';
               $castlePioCss = 'static/css/pio.css';
          } else {
               $castlePlugin = 'static/css/bangumi.min.css';
               $castleCss = 'static/css/castle.min.css';
               $castleNewUICss = 'static/css/castle.newui.min.css';
               $castleThemeCss = 'static/css/castle.theme.min.css';
               $castleAplayerCss = 'static/css/APlayer.min.css';
               $castlePioCss = 'static/css/pio.min.css';
          }

          //MDUI
          echo '<link rel="stylesheet" href="' . Castle_Libs::resources('static/css/mdui.min.css', true) . '">' . "\n  ";

          if (Helper::options()->PJAX && in_array('PJAX_Switch', Helper::options()->PJAX)) {
               //Nprogress
               echo '<link rel="stylesheet" href="' . Castle_Libs::resources('static/css/nprogress.min.css', true) . '">' . "\n  ";
          }

          echo
          //baguetteBox
          '<link rel="stylesheet" href="' . Castle_Libs::resources('static/css/baguetteBox.min.css', true) . '">' . "\n  " .

               //主题配色 Css
               '<link rel="stylesheet" href="' . Castle_Libs::resources($castleThemeCss, true) . '">' . "\n  " .

               //主题核心 Css
               '<link rel="stylesheet" href="' . Castle_Libs::resources($castleCss, true) . '">' . "\n  " .

               //代码高亮
               '<link rel="stylesheet" href="' . Castle_highLight::getFile() . '">' . "\n  ";

          if (Helper::options()->TestSwitch && in_array('newui', Helper::options()->TestSwitch)) {
               // New UI Css
               echo '<link rel="stylesheet" href="' . Castle_Libs::resources($castleNewUICss, true) . '">' . "\n  ";
          }

          if ($header->is("index")) {
               //如果在首页
               $type = 'website'; //站点类型
               $description = Helper::options()->description; //站点简介
          } elseif ($header->is("post") || $header->is("page")) {
               //如果在文章/独立页面
               if ($header->fields->excerpt && $header->fields->excerpt != '') {
                    //如果自定义字段不为空
                    $description = $header->fields->excerpt;
               } else {
                    $description = Typecho_Common::subStr(strip_tags($header->excerpt), 0, 100, "...");
               }
               $type = 'article'; //站点类型
          } else {
               //如果无法判断
               $type = 'archive';
               $description = Helper::options()->description;
          }

          $coverSet = Helper::options()->cover;
          //封面图片
          if ($header->is("index")) {
               $cover = (Helper::options()->siteAvatar) ? Helper::options()->siteAvatar : Castle_Libs::resources('static/img/favicon.png');
          } else if (!empty($coverSet)) {
               $cover = $coverSet;
          } else {
               $cover = Castle_Libs::randCover(false);
          }

          echo '<meta name="description" content="' . $description . '" />' . "\n  " .
               '<meta property="og:title" content="' . self::title($header) . '" />' . "\n  " .
               '<meta name="author" content="' . $header->author->screenName . '" />' . "\n  " .
               '<meta property="og:site_name" content="' . Helper::options()->title . '" />' . "\n  " .
               '<meta property="og:type" content="' . $type . '" />' . "\n  " .
               '<meta property="og:description" content="' . $description . '" />' . "\n  " .
               '<meta property="og:url" content="' . $header->permalink . '" />' . "\n  " .
               '<meta property="og:image" content="' . $cover . '" />' . "\n  " .
               '<meta property="article:published_time" content="' . date('c', $header->created) . '" />' . "\n  " .
               '<meta property="article:modified_time" content="' . date('c', $header->modified) . '" />' . "\n  " .
               '<meta name="twitter:title" content="' . self::title($header) . '" />' . "\n  " .
               '<meta name="twitter:description" content="' . $description . '" />' . "\n  " .
               '<meta name="twitter:card" content="summary_large_image" />' . "\n  " .
               '<meta name="twitter:image" content="' . $cover . '" />' . "\n  ";
          $header->header('generator=&pingback=&xmlrpc=&wlw=&commentReply=&description=&antiSpam=');

          //判断 APlayer 是否启用
          if (Castle_Libs::hasPlugin('Meting') || Castle_Libs::hasPlugin('APlayerAtBottom') || Helper::options()->APlayerStyle == '0') {
               echo "\n  " . '<link rel="stylesheet" href="' . Castle_Libs::resources($castleAplayerCss, true) . '">' . "\n";
          }

          //判断 Pio 是否启用
          if (Castle_Libs::hasPlugin('Pio') || Helper::options()->PioStyle == '0') {
               echo "\n  " . '<link rel="stylesheet" href="' . Castle_Libs::resources($castlePioCss, true) . '">' . "\n";
          }

          //判断 Castle 配套插件是否启用
          if (Castle_Libs::hasPlugin('Castle')) {
               echo "\n  " . '<link rel="stylesheet" href="' . Castle_Libs::resources($castlePlugin, true) . '">' . "\n";
          }
     }

     /**
      * 卡片透明度
      */
     public static function cardTransparent()
     {
          $cardTransparent = Helper::options()->cardTransparent;
          switch ($cardTransparent) {
               case '0':
                    break;

               case '1':
                    return ' class="moe-card-transparent-10"';
                    break;

               case '2':
                    return ' class="moe-card-transparent-20"';
                    break;

               case '3':
                    return ' class="moe-card-transparent-30"';
                    break;

               default:
                    break;
          }
     }
}
