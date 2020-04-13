<?php
/**
 * Castle Content Class
 * Last Update: 2020/04/13
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
//大部分修改搬自 AlanDecode[https://github.com/AlanDecode] 的主题 VOID
//非常感谢 AlanDecode Dalao!

class Castle_Contents {
 
 /**
  * 内容解析
  */
 public static function contentEx($data, $widget, $last) {
  $text = empty($last) ? $data : $last;
  if ($widget instanceof Widget_Archive) {
   $text = self::parseBaguetteBox($text, $widget->parameter->__get('type') == 'feed');
   $text = self::parseOwO($text);
   $text = self::parseTable($text);
   $text = self::parseTitle($text);
   $text = self::parseRuby($text);
   $text = self::shortCode($text);
  }
  
  return $text;
 }

 /**
  * 短代码入口
  */
 public static function shortCode($content) {
  $content = self::parseCodeHidden($content);
  $content = self::parseCodeTextCenter($content);

  return $content;
 }

 /**
  * 解析 OwO 表情
  */
 public static function parseOwO($content) {
  $owoList = (Castle_OwO::getOwOList()) ? Castle_OwO::getOwOList() : NULL;

  //如果没有表情包则不解析
  if(!$owoList) { return $content; }

  for ($owoNum=0; $owoNum<count($owoList); $owoNum++) {
   //如果是 Text 或者 emoji //没必要返回
   if ($owoList[$owoNum]['type'] == 'text' || $owoList[$owoNum]['type'] == 'emoji') { $content = $content; }

   //如果是图片
   if ($owoList[$owoNum]['type'] == 'picture') {
    //判断有无图片
    if ($owoList[$owoNum]['content']) {
     for($i=0; $i<count($owoList[$owoNum]['content']); $i++) {
      $new = '<img src="'.$owoList[$owoNum]['dir'].$owoList[$owoNum]['content'][$i]['file'].'" class="moe-owo-picture moe-owo" />';
      $content = str_replace($owoList[$owoNum]['content'][$i]['data'], $new, $content);
     }
    }
   }

   //如果是小表情
   if ($owoList[$owoNum]['type'] == 'smallPicture') {
    //判断有无图片
    if ($owoList[$owoNum]['content']) {
     for($i=0; $i<count($owoList[$owoNum]['content']); $i++) {
      $new = '<img src="'.$owoList[$owoNum]['dir'].$owoList[$owoNum]['content'][$i]['file'].'" class="moe-owo-smallPicture moe-owo" />';
      $content = str_replace($owoList[$owoNum]['content'][$i]['data'], $new, $content);
     }
    }
   }
  }

  return $content;
 }

 /**
  * 解析 baguetteBox
  *
  * @param photoMode false: 普通解析，true: RSS(不包裹 a 标签)
  */
 static private $photoMode = false;
 public static function parseBaguetteBox($content, $photoMode = false) {
  $reg = '/<img.*?src="(.*?)".*?alt="(.*?)".*?>/s';
  self::$photoMode = $photoMode;
  $new = preg_replace_callback($reg, ['Castle_Contents', 'parseBaguetteBox_Callback'], $content);
  return $new;
 }

 /**
  * baguetteBox 回调函数
  * 解析图片（正常文章）
  */
 private static function parseBaguetteBox_Callback($match) {
  // 普通解析
  if(!self::$photoMode) {
   $imgHead = '<a data-baguettebox="photo" data-caption="'.$match[2].'" href="'.$match[1].'" data-baguettebox="photo" no-go no-pgo no-pjax>';
   $imgFoot = '</a>';
  }

  $img = '<img class="lazyload" alt="'.$match[2].'" src="" data-src="'.$match[1].'">';

  return (self::$photoMode) ? $img : $imgHead.$img.$imgFoot;
 }

 /**
  * 表格解析
  *
  * @param  string $content  文章内容
  * @return string $new      解析表格后的内容
  */
 static public function parseTable($content){
  $reg = '/<table>(.*?)<\/table>/s';
  $rp = '<div class="mdui-table-fluid"><table class="mdui-table mdui-table-hoverable">${1}</table></div>';
  $new = preg_replace($reg,$rp,$content);
  return $new;
 }

 /**
  * 解析 H1 ~ H6
  */
 public static function parseTitle($content) {
  $reg='/\<h([1-6])(.*?)\>(.*?)\<\/h.*?\>/s';
  $new = preg_replace_callback($reg, ['Castle_Contents', 'parseTitleCallback'], $content);
  return $new;
 }

 /**
  * 标题解析回调函数（H1 ~ H6）
  */
 static private $CurrentTocID = 0;
 public static function parseTitleCallback($matchs) {
  $id = 'toc_'.(self::$CurrentTocID++);
  return '<h'.$matchs[1].$matchs[2].' id="'.$id.'">'.$matchs[3].'</h'.$matchs[1].'>';
 }

 /**
  * 解析 ruby
  */
 public static function parseRuby($string) {
  $reg = '/\{\{(.*?):(.*?)\}\}/s';
  $rp = '<ruby>${1}<rp>(</rp><rt>${2}</rt><rp>)</rp></ruby>';
  $new = preg_replace($reg, $rp, $string);
  return $new;
 }

 /**
  * 隐藏文字 [短代码]
  */
 public static function parseCodeHidden($content) {
  $reg = '/\[hidden\](.*?)\[\/hidden\]/s';
  $rp = '<span class="moe-short-code-hidden">${1}</span>';
  $new = preg_replace($reg, $rp, $content);
  return $new;
 }

 /**
  * 文字居中
  */
 public static function parseCodeTextCenter($content) {
  $reg = '/\[center\](.*?)\[\/center\]/s';
  $rp = '<span class="moe-short-code-text-center">${1}</span>';
  $new = preg_replace($reg, $rp, $content);
  return $new;
 }

 /**
  * Markdown
  */
 public static function markdown($text) {
  if (0 == strpos($text, '<!--markdown-->')) {
   $text = str_replace("```objective-c", "```objectivec", $text);
   $text = str_replace("```c++", "```cpp", $text);
   $text = str_replace("```c#", "```csharp", $text);
   $text = str_replace("```f#", "```fsharp", $text);
   $text = str_replace("```F#", "```Fsharp", $text);
   $text = Markdown::convert($text);
  }

  return $text;
 }

 /**
  * 文章阅读数
  *
  * @param  $widget
  * @return $row['views']
  */
 public static function PostView($widget) {
  $cid    = $widget->cid;
  $db     = Typecho_Db::get();
  $prefix = $db->getPrefix();
  if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
   $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
   echo 0;
   return;
  }
   
  $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
  if ($widget->is('single')) {
   $views = Typecho_Cookie::get('extend_contents_views');
   if(empty($views)){
    $views = array();
   }else{
    $views = explode(',', $views);
   }
   if(!in_array($cid,$views)){
    $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
    array_push($views, $cid);
    $views = implode(',', $views);
    Typecho_Cookie::set('extend_contents_views', $views);
   }
  }
  return $row['views'];
 }

 /**
  * 显示上一篇
  */
 public function thePrev($widget) {
  $db = Typecho_Db::get();
  $sql = $db->select()->from('table.contents')
   ->where('table.contents.created < ?', $widget->created)
   ->where('table.contents.status = ?', 'publish')
   ->where('table.contents.type = ?', $widget->type)
   ->where('table.contents.password IS NULL')
   ->order('table.contents.created', Typecho_Db::SORT_DESC)
   ->limit(1);
  $content = $db->fetchRow($sql);
  if ($content) {
   $content = $widget->filter($content);
   $link = '
      <a href="'.$content['permalink'].'" class="mdui-ripple mdui-ripple-white mdui-col-xs-2 mdui-col-sm-6 moe-post-nav-left">
       <div class="moe-post-nav-text">
        <i class="mdui-icon material-icons">arrow_back</i>
        <span class="moe-post-nav-direction mdui-hidden-xs-down">'.$GLOBALS['CastleLang']['post']['nav']['prev'].'</span>
        <div class="moe-post-nav-chapter mdui-hidden-xs-down">'.$content['title'].'</div>
       </div>
      </a>';
   echo $link;
  } else {
   $default = '<div class="mdui-ripple mdui-ripple-white mdui-col-xs-2 mdui-col-sm-6 moe-post-nav-left">
       <div class="moe-post-nav-text">
        <i class="mdui-icon material-icons">arrow_back</i>
        <span class="moe-post-nav-direction mdui-hidden-xs-down">'.$GLOBALS['CastleLang']['post']['nav']['prev'].'</span>
        <div class="moe-post-nav-chapter mdui-hidden-xs-down">'.$GLOBALS['CastleLang']['post']['nav']['empty'].'</div>
       </div>
      </div>';
   echo $default;
  }
 }

 /**
  * 显示下一篇
  */
 public function theNext($widget) {
  $db = Typecho_Db::get();
  $sql = $db->select()->from('table.contents')
   ->where('table.contents.created > ?', $widget->created)
   ->where('table.contents.status = ?', 'publish')
   ->where('table.contents.type = ?', $widget->type)
   ->where('table.contents.password IS NULL')
   ->order('table.contents.created', Typecho_Db::SORT_ASC)
   ->limit(1);
  $content = $db->fetchRow($sql);
  if ($content) {
   $content = $widget->filter($content);
   $link = '
      <a href="'.$content['permalink'].'" class="mdui-ripple mdui-ripple-white mdui-col-xs-10 mdui-col-sm-6 moe-post-nav-right">
       <div class="moe-post-nav-text">
        <i class="mdui-icon material-icons">arrow_forward</i>
        <span class="moe-post-nav-direction">'.$GLOBALS['CastleLang']['post']['nav']['next'].'</span>
        <div class="moe-post-nav-chapter">'.$content['title'].'</div>
       </div>
      </a>';
   echo $link;
  } else {
   $default = '<div class="mdui-ripple mdui-ripple-white mdui-col-xs-10 mdui-col-sm-6 moe-post-nav-right">
       <div class="moe-post-nav-text">
        <i class="mdui-icon material-icons">arrow_forward</i>
        <span class="moe-post-nav-direction">'.$GLOBALS['CastleLang']['post']['nav']['next'].'</span>
        <div class="moe-post-nav-chapter">'.$GLOBALS['CastleLang']['post']['nav']['empty'].'</div>
       </div>
      </div>';
   echo $default;
  }
 }

 /**
  * 判断文章是否有密码
  */
 public function hasPassword($widget) {
  $db = Typecho_Db::get();
  $sql = $db->select()->from('table.contents')
   ->where('table.contents.cid = ?', $widget->cid)
   ->limit(1);
  $content = $db->fetchRow($sql);

  return ($content['password']) ? true : false;
 }

 /**
  * 内容归档
  */
 public static function archives($widget) {
  $db = Typecho_Db::get();
  $rows = $db->fetchAll($db->select()
   ->from('table.contents')
   ->order('table.contents.created', Typecho_Db::SORT_DESC)
   ->where('table.contents.type = ?', 'post')
   ->where('table.contents.status = ?', 'publish'));
        
  $stat = array();
  foreach ($rows as $row) {
   $row = $widget->filter($row);
   $arr = array(
    'title' => $row['title'],
    'permalink' => $row['permalink']);

   $stat[date('Y', $row['created'])][$row['created']] = $arr;
  }
  return $stat;
 }

 /**
  * 获取文章二维码
  */
 public static function QRcode($widget) {
  $setting = Helper::options()->deviceQRAPI;

  switch($setting) {
   case '0':
    defaultAPI:
    $link = 'https://api.ohmyga.cn/qrcode?url='.$widget->permalink;
    break;
   
   case '1':
    $link = 'https://api.fczbl.vip/qr/?m=1&e=H&p=4.86&url='.$widget->permalink;
    break;
   
   case '2':
    $link = 'https://api.imjad.cn/qrcode/?size=170&level=H&text='.$widget->permalink;
    break;
   
   case '3':
    $link = 'https://www.wandoujia.com/api/qr?s=7&c='.$widget->permalink;
    break;
   
   case '4':
    $link = 'https://chart.googleapis.com/chart?chs=170x170&cht=qr&chld=H|1&chl='.$widget->permalink;
    break;

   case '5':
    $link = 'https://my.tv.sohu.com/user/a/wvideo/getQRCode.do?text='.$widget->permalink;
    break;

   case '6':
    $link = 'https://www.kuaizhan.com/common/encode-png?large=true&data='.$widget->permalink;
    break;
   
   case '7':
    $link = str_replace('{permalink}', $widget->permalink, Helper::options()->deviceQR_DIY_API);
    break;

   default:
    goto defaultAPI;
  }

  return $link;
 }
}