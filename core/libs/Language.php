<?php
/**
 * Castle Language Class
 * Last Update: 2020/02/27
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_Lang {
 
 /**
  * 设置面板获取语言配置列表
  *
  * @return $output
  */
 public static function getList() {
  //获取所有语言配置
  $langList = glob(Helper::options()->themeFile(Castle_Libs::getTheme(), "core/lang/*.json"));

  //如果没有任何语言配置
  if (!$langList) { return false; }

  for ($i=0; $i<count($langList); $i++) {
   $file = $langList[$i];
   $file_get = file_get_contents($file, true);
   $data = json_decode($file_get, true);
   $name = $data['name'];
   $output[$file] = $name;
  }

  return $output;
 }

 /**
  * 获取语言
  */
 public static function getLang() {
  $setting = Helper::options()->Language;
  $file = ($setting) ? $setting : Helper::options()->themeFile(Castle_Libs::getTheme(), "core/lang/zh-CN.json");
  $output = json_decode(file_get_contents($file), true);
  return $output;
 }
}