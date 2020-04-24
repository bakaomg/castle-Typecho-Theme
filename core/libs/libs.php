<?php
/**
 * Castle Libs Class
 * Last Update: 2020/04/24
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_Libs {

 /**
  * 静态资源引用
  *
  * @param $path     文件路径
  * @param $outType  链接输出方式
  **/
 public static function resources($path, bool $version = false, bool $outType = false) {
  //获取静态源设置
  $resourcesSetting = Helper::options()->resources_Type;

  //主题链接
  $themeURL = Helper::options()->themeUrl;

  //附加版本号
  $version = ($version === true) ? '?v='.CASTLE_VERSION : NULL;

  switch ($resourcesSetting) {
   case 'local':
    local:
    $output = $themeURL.'/'.$path.$version;
   break;

   case 'jsdelivr':
    $output = 'https://cdn.jsdelivr.net/gh/ohmyga233/castle-Typecho-Theme@'.CASTLE_VERSION.'/'.$path;
   break;

   case 'cdn':
    $output = Helper::options()->CDNLink.'/'.$path;
   break;

   default:
    goto local;
  }

  //最终输出
  if ($outType === true) { echo $output; }else{ return $output; }
 }

 /**
  * 随机封面图片
  */
 public static function randCover(bool $outType = false) {
  $randCoverSettig = Helper::options()->coverType;

  switch($randCoverSettig) {
   case 'oapi':
    //O's API
    defaultCover:
    $output = 'https://api.ohmyga.cn/wallpaper/?rand='.mt_rand(0,1000);
    break;

   case 'shota':
    $output = 'https://api.9jojo.cn/acgpic/?rand='.mt_rand(0,1000);
    break;

   case 'local':
    //本地图片
    $CoverFormat = str_replace("&", ",", (Helper::options()->loaclCoverFormat) ? Helper::options()->loaclCoverFormat : 'jpg&jpeg&png&webp&bmp');
    $getFile = glob(Helper::options()->themeFile(Castle_Libs::getTheme(), "core/cover/*.{".$CoverFormat."}"), GLOB_BRACE);
    if (!$getFile){ $output = 'https://api.ohmyga.cn/wallpaper/?rand='.mt_rand(0,1000); break; }
    preg_match('/\/core\/cover\/(.*)/', $getFile[mt_rand(0, count($getFile)-1)], $out);
    $output =  Helper::options()->themeUrl.'/core/cover/'.$out[1];
    break;
   
   case 'external':
    //自定义第三方 API [无附加随机参数]
    $output = Helper::options()->coverExternal;
    break;

   case 'externalRand':
    //自定义第三方 API [附加随机参数]
    $output = Helper::options()->coverExternal.'?rand='.mt_rand(0,1000);
    break;
   
   default:
    goto defaultCover;
  }

  //最终输出
  if ($outType === true) { echo $output; }else{ return $output; }
 }

 /**
  * 输出相对首页路由
  * 自适应伪静态
  *
  * @param $path     路径
  * @param $outType  链接输出方式
  */
 public static function index($path = '', $outType = false) {
  $output = Helper::options()->index.$path;
  
  //最终输出
  if ($outType === true) { echo $output; }else{ return $output; }
 }

 /**
  * 获取主题名称
  *
  * @return $themeName  返回主题名
  */
 public static function getTheme() {
  $db = Typecho_Db::get();
  $query = $db->select('value')->from('table.options')->where('name = ?', 'theme');
  $result = $db->fetchAll($query);
  $themeName = $result[0]["value"];

  return $themeName;
 }

 /**
  * 获取主题版本
  *
  * @return $info['version']  返回主题版本号
  */
 public static function getThemeVersion() {
  $info = Typecho_Plugin::parseInfo(__DIR__ . '/../../index.php');
  return $info['version'];
 }

 /**
  * 根据 UID 获取用户昵称
  *
  * @return $name  返回指定用户用户名
  */
 public static function getUserScreenName(int $userID) {
  $db = Typecho_Db::get();
  $name = $db->fetchRow($db->select()->from('table.users')->where('uid = ?', $userID))['screenName'];
  return $name;
 }

 /**
  * 获取所有者用户名（UID 1）
  *
  * @return $name  返回第一管理员的名称
  */
 public static function getAdminScreenName() {
  $db = Typecho_Db::get();
  $name = $db->fetchRow($db->select()->from('table.users')->where('uid = ?', 1))['screenName'];
  return $name;
 }

 /**
  * 获取所有者邮箱（UID 1）
  *
  * @return $name  返回第一管理员的邮箱
  */
 public static function getAdminMail() {
  $db = Typecho_Db::get();
  $mail = $db->fetchRow($db->select()->from('table.users')->where('uid = ?', 1))['mail'];
  return $mail;
 }

 /**
  * 判断插件是否可用（存在且已激活）
  *
  * @param $name  插件名
  * @return       插件状态
  */
 public static function hasPlugin($name) {
  $plugins = Typecho_Plugin::export();
  $plugins = $plugins['activated'];
  return is_array($plugins) && array_key_exists($name, $plugins);
 }

 /**
  * 批量引用文件
  *
  * @param $path  目录
  * @param $file  文件格式
  */
 public static function requireFile($path, $file) {
  $all = glob($path.'*.'.$file);
  foreach ($all as $file) {
   require_once $file;
  }
 }

 /**
  * 编辑界面添加按钮
  */
 public static function addButtons() {
  $resourcesSetting = (Helper::options()->resources_Type) ? Helper::options()->resources_Type : 'local';
  $owoCss = ($resourcesSetting == 'jsdelivr') ? 'static/css/owo.min.min.css' : 'static/css/owo.min.css';
  $owoJS = ($resourcesSetting == 'jsdelivr') ? 'static/js/owo.min.min.js' : 'static/js/owo.min.js';

  //自定义字段输入框样式
  echo '<style>
  #custom-field { position: relative; }
  #custom-field input{ width:100%; }
  #custom-field textarea{ height: 120px; width: 100%;}
  #custom-field input, #custom-field textarea{ box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;}'.
  
  //编辑器按钮样式修复
  '.wmd-button-row{ height:unset; }'.

  //背景色
  'body {background: #F6F6F3!important;}
  </style>'.

  //MDUI
  '<link rel="stylesheet" href="'.Castle_Libs::resources('static/css/mdui.min.css', true).'">'.
  '<script src="'.Castle_Libs::resources('static/js/mdui.min.js', true).'"></script>'.
  
  //表情选择框
  '<script src="'.Castle_Libs::index('/?action=owoConfig', false).'"></script>'.
  '<link rel="stylesheet" href="'.Castle_Libs::resources($owoCss, true).'" />'.
  '<script src="'.Castle_Libs::resources($owoJS, true).'"></script>'.
  '<script>window.onload = function() { CastleOwO.addOwOBtn(); };</script>';
 }

 /**
  * 获取主题设置
  */
 public static function getThemeOptions($name) {
  static $themeOptions = NULL;
  if ($themeOptions === NULL) {
   $db = Typecho_Db::get();
   $query = $db->select('value')->from('table.options')->where('name = ?', 'theme:' . self::getTheme());
   $result = $db->fetchAll($query);
   $themeOptions = unserialize($result[0]["value"]);
  }

  return ($name === NULL) ? $themeOptions : (isset($themeOptions[$name]) ? $themeOptions[$name] : NULL);
 }
}