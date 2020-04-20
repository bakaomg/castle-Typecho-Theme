<?php
/**
 * Castle Short Code Class
 * Last Update: 2020/04/20
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_ShortCode {
 private static $isFeed;

 /**
  * 短代码解析入口
  *
  * @access public
  * @param  $content  需解析的内容
  * @param  $isFeed   请求的类型
  * @return $content  解析后的内容
  */
 public static function parseAll($content, $isFeed = false) {
  $content = self::parsePanel($content, $isFeed);
  $content = self::parseHidden($content, $isFeed);
  $content = self::parseTextCenter($content, $isFeed);
  
  return $content;
 }

 /**
  * 隐藏文字
  *
  * @param  $isFeed   true：将隐藏替换为删除线，false：正常解析
  * @param  $content  传入的待解析内容
  * @return $new      解析后的结果
  * @access public
  */
 public static function parseHidden($content, $isFeed) {
  $reg = self::get_shortcode_regex(['hidden']);
  $rp = ($isFeed === true) ? '<del>${5}</del>' :'<span class="moe-short-code-hidden">${5}</span>';
  $new = preg_replace("/$reg/s", $rp, $content);
  return $new;
 }

 /**
  * 文字居中
  *
  * @param  $isFeed   true：换成<center>，false：正常解析
  * @param  $content  传入的待解析内容
  * @return $new      解析后的结果
  * @access public
  */
 public static function parseTextCenter($content, $isFeed) {
  $reg = self::get_shortcode_regex(['center']);
  $rp = ($isFeed === true) ? '<center>>${1}</center>' :'<span class="moe-short-code-text-center">${1}</span>';
  $new = preg_replace("/$reg/s", $rp, $content);
  return $new;
 }

 /**
  * 可折叠面板
  *
  * @param  $isFeed   true：隐藏面板，false：正常解析
  * @param  $content  传入的待解析内容
  * @return $new      解析后的结果
  * @access public
  */
 public static function parsePanel($content, $isFeed) {
  self::$isFeed = $isFeed;
  $pattern = self::get_shortcode_regex(array('panel'));
  $new = preg_replace_callback("/$pattern/",['Castle_ShortCode', 'parsePanelCallback'] , $content);
  return $new;
 }

 /**
  * 可折叠面板回调函数
  *
  * @param  $matches  传入的待解析内容数组
  * @return $panel    解析后的结果
  * @access private
  */
 private static function parsePanelCallback($matches) {
  static $data = [];
  $data = self::shortcode_parse_atts($matches[3]);

  if (self::$isFeed === true && !empty($matches)) {
   return '<strong>这是一个折叠面板，请在浏览器中查看</strong>';
  }

  $title   = (!empty($data['title'])) ? $data['title'] : '';
  $summary = (!empty($data['summary'])) ? $data['summary'] : '';
  $content = (!empty($matches[5])) ? $matches[5] : '';
  $open    = (!empty($data['open']) && @$data['open'] == 'true') ? ' mdui-panel-item-open' : '';
  $popout  = (!empty($data['popout']) && @$data['popout'] == 'true') ? ' mdui-panel-popout' : '';

  $panel = '<div class="mdui-panel" mdui-panel>
   <div class="mdui-panel-item'.$open.$popout.'">
    <div class="mdui-panel-item-header">
     <div class="mdui-panel-item-title">'.$title.'</div>
     <div class="mdui-panel-item-summary">'.$summary.'</div>
     <i class="mdui-panel-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
    </div>

    <div class="mdui-panel-item-body">'.$content.'</div>
   </div>
  </div>';

  return $panel;
 }

 /**
  * 短代码参数解析
  *
  * @access private
  * https://github.com/WordPress/WordPress/blob/master/wp-includes/shortcodes.php#L508
  */
 private static function shortcode_parse_atts($text) {
  $atts = array();
  $pattern = '/([\w-]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w-]+)\s*=\s*\'([^\']*)\'(?:\s|$)|([\w-]+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
  $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
  if (preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
   foreach ($match as $m) {
    if (!empty($m[1])) {
     $atts[strtolower($m[1])] = stripcslashes($m[2]);
    } elseif (!empty($m[3])) {
     $atts[strtolower($m[3])] = stripcslashes($m[4]);
    } elseif (!empty($m[5])) {
     $atts[strtolower($m[5])] = stripcslashes($m[6]);
    } elseif (isset($m[7]) && strlen($m[7])) {
     $atts[] = stripcslashes($m[7]);
    } elseif (isset($m[8])) {
     $atts[] = stripcslashes($m[8]);
    }
   }
 
   foreach ($atts as &$value) {
    if (false !== strpos($value, '<')) {
     if (1 !== preg_match('/^[^<]*+(?:<[^>]*+>[^<]*+)*+$/', $value)) {
      $value = '';
     }
    }
   }
  } else {
   $atts = ltrim($text);
  }
  return $atts;
 }

 /**
  * 短代码参数解析
  *
  * @access private
  * https://github.com/WordPress/WordPress/blob/master/wp-includes/shortcodes.php#L254
  */
 private static function get_shortcode_regex($tagnames = null) {
  $tagregexp = join('|', array_map('preg_quote', $tagnames));
  return '\[(\[?)('.$tagregexp.')(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
 }
}