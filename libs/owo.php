<?php
/**
 * OwO Class
 * Author: ohmyga
 * Version: 2019/06/02 V1.0
 * Link: https://ohmyga.cn/
 * GitHub: https://github.com/ohmyga233
 **/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Smile {

 public static function owo($icon, $text) {
  $output = '<a href="javascript:Smilies.grin(\''.htmlspecialchars($text).'\');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2">'.$icon.'</span></a>';
  return $output;
 }
 
 public static function tieba($icon, $img) {
  $output = '<a href="javascript:Smilies.grin(\''.$icon.'\');"><div class="moe-owo-tieba mdui-card mdui-btn"><img src="'.themeResource('others/img/OwO/tieba/'.$img).'"></div></a>';
  return $output;
 }
 
 public static function huaji($icon, $img) {
  $output = '<a href="javascript:Smilies.grin(\''.$icon.'\');"><div class="moe-owo-hj mdui-card mdui-btn"><img src="'.themeResource('others/img/OwO/huaji/'.$img).'"></div></a>';
  return $output;
 }
 
 public static function qwq($icon, $img) {
  $output = '<a href="javascript:Smilies.grin(\''.$icon.'\');"><div class="moe-owo-qwq mdui-card mdui-btn"><img src="'.themeResource('others/img/OwO/qwq/'.$img).'"></div></a>';
  return $output;
 }
 
 public static function emoji($icon, $text) {
  $output = '<a href="javascript:Smilies.grin(\''.$icon.'\');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>'.$text.'</span></a>';
  return $output;
 }

 public static function getOwO() {
  $getJson =file_get_contents(Helper::options()->siteUrl.'usr/themes/'.getTheme().'/libs/owo.json');
  $owoArray = json_decode($getJson, true);
  $owoName = array_keys($owoArray);
  for ($i=0; $i<count($owoName); $i++) {
   $smileName = $owoName[$i];
   $smileType = $owoArray[$smileName]['type'];
   if ($smileType == 'tieba') {
    echo '<div id="'.$owoName[$i].'" class="mdui-p-a-2">';
    for ($to=0; $to<count($owoArray[$smileName]['content']); $to++) {
     echo self::tieba($owoArray[$smileName]['content'][$to]['icon'], $owoArray[$smileName]['content'][$to]['img']);
    }
	echo '</div>';
   }elseif ($smileType == 'owo') {
    echo '<div id="'.$owoName[$i].'" class="mdui-p-a-2">';
	for ($to=0; $to<count($owoArray[$smileName]['content']); $to++) {
     echo self::owo($owoArray[$smileName]['content'][$to]['icon'], $owoArray[$smileName]['content'][$to]['text']);
    }
	echo '</div>';
   }elseif ($smileType == 'huaji') {
    echo '<div id="'.$owoName[$i].'" class="mdui-p-a-2">';
	for ($to=0; $to<count($owoArray[$smileName]['content']); $to++) {
     echo self::huaji($owoArray[$smileName]['content'][$to]['icon'], $owoArray[$smileName]['content'][$to]['img']);
    }
	echo '</div>';
   }elseif ($smileType == 'qwq') {
    echo '<div id="'.$owoName[$i].'" class="mdui-p-a-2">';
	for ($to=0; $to<count($owoArray[$smileName]['content']); $to++) {
     echo self::qwq($owoArray[$smileName]['content'][$to]['icon'], $owoArray[$smileName]['content'][$to]['img']);
    }
	echo '</div>';
   }elseif ($smileType == 'emoji') {
    echo '<div id="'.$owoName[$i].'" class="mdui-p-a-2">';
	for ($to=0; $to<count($owoArray[$smileName]['content']); $to++) {
     echo self::emoji($owoArray[$smileName]['content'][$to]['icon'], $owoArray[$smileName]['content'][$to]['text']);
    }
	echo '</div>';
   }
  }
 }
 
 public static function getTitle() {
  $getJson =file_get_contents(Helper::options()->siteUrl.'usr/themes/'.getTheme().'/libs/owo.json');
  $owoArray = json_decode($getJson, true);
  $owoName = array_keys($owoArray);
  for ($i=0; $i<count($owoName); $i++) {
   echo '<a href="#'.$owoName[$i].'" class="mdui-ripple" no-pgo>'.$owoName[$i].'</a>';
  }
 }
 
 public static function randIcon() {
  $randNum = rand(0,11);
  $iconName = array('tag_faces',
   'face',
   'favorite',
   'insert_emoticon',
   'mood',
   'mood_bad',
   'sentiment_satisfied',
   'sentiment_very_dissatisfied',
   'sentiment_very_satisfied',
   'sentiment_dissatisfied',
   'sentiment_neutral',
   'OωO');
   $output = $iconName[$randNum];
  return $output;
 }

}