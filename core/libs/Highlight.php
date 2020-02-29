<?php
/**
 * Castle highLight Class
 * Last Update: 2020/02/29
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_highLight {
 
 /**
  * 获取高亮样式
  *
  * @return $file 高亮文件路径
  */
 public static function getFile() {
  $loaclUrl = Helper::options()->themeUrl.'/core/highlight/';
  $hl = (Helper::options()->highLight) ?  $loaclUrl.Helper::options()->highLight : 'https://cdn.jsdelivr.net/gh/ohmyga233/castle-Typecho-Theme@'.CASTLE_VERSION.'/core/highlight/default.min.css';
  return $hl;
 }

 /**
  * 获取样式路径
  *
  * @return array
  */
 public static function getHighLightConfig() {
  $hltd = Helper::options()->themeFile(Castle_Libs::getTheme(), "core/highlight/default.min.css");
  if (file_exists($hltd)) {
   $hlts = array_map('basename', glob(__DIR__ . '/../highlight/*.css'));
   $hlts = array_combine($hlts, $hlts);
   $texts = '';
  }else{
   $hlts = array('jsdelivr' => '默认');
   $texts = '<small style="color: red;">找不到 \'others/css/highlight/default.min.css\' 故将使用 JSdelivr 上的默认样式</small>';
  }
 
  return [$hlts, $texts];
 }
}