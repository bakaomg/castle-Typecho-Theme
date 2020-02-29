<?php
/**
 * Castle Header Class
 * Last Update: 2020/01/26
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_Header {

 /**
  * 站点标题
  *
  * @param $archive    Widget_Archive
  * @param $before     标题前缀
  * @param $end        归档标题与站点标题的间隔符合
  * @param $siteTitle  是否附带站点标题
  * @param $outType    标题输出方式
  **/
 public static function title(Widget_Archive $archive, $before = ' &raquo; ', $end = '', bool $siteTitle = true, bool $outType = false) {
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
  $siteTitle = $siteTitle === true ? $end.Helper::options()->title : NULL;

  //解析归档标题
  if ($ArchiveTitle) {
   $define = '%s';
   if (is_array($ArchiveTitleArr) && !empty($ArchiveTitleArr[$ArchiveType])) {
    $define = $ArchiveTitleArr[$ArchiveType];
   }

   $output = $before . sprintf($define, $ArchiveTitle) . $siteTitle;
  }else{
   $output = Helper::options()->title;
  }

  //最终输出
  if ($outType === true) { echo $output; }else{ return $output; }
 }

 /**
  * 头部输出
  */
 public static function export($header) {
  //MDUI
  echo '<link rel="stylesheet" href="'.Castle_Libs::resources('static/css/mdui.min.css', true).'">'."\n  ";

  if (Helper::options()->PJAX && in_array('PJAX_Switch', Helper::options()->PJAX)) {
   //Nprogress
   echo '<link rel="stylesheet" href="'.Castle_Libs::resources('static/css/nprogress.min.css', true).'">'."\n  ";
  }

  echo
  //baguetteBox
  '<link rel="stylesheet" href="'.Castle_Libs::resources('static/css/baguetteBox.min.css', true).'">'."\n  ".
  
  //主题配色 Css
  '<link rel="stylesheet" href="'.Castle_Libs::resources('static/css/castle.theme.min.css', true).'">'."\n  ".

  //代码高亮
  '<link rel="stylesheet" href="'.Castle_highLight::getFile().'">'."\n  ".

  //主题核心 Css
  '<link rel="stylesheet" href="'.Castle_Libs::resources('static/css/castle.min.css', true).'">'."\n";
 }

 /**
  * 卡片透明度
  */
 public static function cardTransparent() {
  $cardTransparent = Helper::options()->cardTransparent;
  switch($cardTransparent) {
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