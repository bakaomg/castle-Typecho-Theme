<?php
/**
 * Castle OwO Class
 * Last Update: 2020/04/11
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_OwO {
 
 /**
  * 获取表情包列表
  */
 public static function getOwOList() {
  //打开文件
  $owoFile = file_get_contents(__DIR__ .'/../owo.json');
  
  //判断是否有表情文件
  if(!file_exists(__DIR__ .'/../owo.json')) return false;
  //判断是否标准 JSON
  if (!is_array(json_decode($owoFile, true))) return false;

  $owoJson = json_decode($owoFile, true);
  $owo = [];
  //键名
  $owoNames = array_keys($owoJson);

  for($owoNum=0; $owoNum<count($owoJson); $owoNum++) {
   $owoName = $owoNames[$owoNum];
   
   //如果是图片/小表情
   if ($owoJson[$owoName]['type'] == 'picture' || $owoJson[$owoName]['type'] == 'smallPicture') {
    $owo[] = [
     'id' => $owoName,
     'name' => $owoJson[$owoName]['title'],
     'type' => $owoJson[$owoName]['type'],
     'dir' => Castle_Libs::resources('static/img/owo/'.$owoName.'/'),
     'content' => $owoJson[$owoName]['content']
    ];
   }

   //如果是文字/Emoji
   if ($owoJson[$owoName]['type'] == 'text' || $owoJson[$owoName]['type'] == 'emoji') {
    $owo[] = [
     'id' => $owoName,
     'name' => $owoJson[$owoName]['title'],
     'type' => $owoJson[$owoName]['type'],
     'content' => $owoJson[$owoName]['content']
    ];
   }

   //如果是外部图片
   if ($owoJson[$owoName]['type'] == 'external') {
    $owo[] = [
     'id' => $owoName,
     'name' => $owoJson[$owoName]['title'],
     'type' => 'picture',
     'dir' => ($owoJson[$owoName]['url']) ? $owoJson[$owoName]['url'] : false,
     'content' => $owoJson[$owoName]['content']
    ];
   }
  }

  return $owo;
 }
}