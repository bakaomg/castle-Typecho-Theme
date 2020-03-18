<?php
/**
 * Castle Theme Config Notice
 * Last Update: 2020/03/18
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_Notice {

 /**
  * Success Notice
  *
  * @param  string $text  提示文字
  * @return string $str   输出完整的提示框结构
  */
 public static function success($text) {
  $str  = '<p class="moe-notice moe-notice-success">';
  $str .= ($text) ? $text : NULL;
  $str .= '</p>';

  return $str;
 }

 /**
  * Error Notice
  *
  * @param  string $text  提示文字
  * @return string $str   输出完整的提示框结构
  */
 public static function error($text) {
  $str  = '<p class="moe-notice moe-notice-error">';
  $str .= ($text) ? $text : NULL;
  $str .= '</p>';

  return $str;
 }

}