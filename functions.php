<?php
/**
 * Castle Functions
 * Last Update: 2020/01/25
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

//不存在的错误
//error_reporting(0);

//设置时区 [上海]
//如果时间显示有误请注解
date_default_timezone_set("Asia/Shanghai");

//引用核心文件
require_once __DIR__ .'/core/libs/libs.php';

//常量
define('CASTLE_VERSION', Castle_Libs::getThemeVersion());

//引用文件
Castle_Libs::requireFile(__DIR__ .'/core/libs/', 'php');
$GLOBALS['CastleLang'] = Castle_Lang::getLang();

//向编辑界面添加按钮
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Castle_Libs', 'addButtons');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Castle_Libs', 'addButtons');
//内容解析
Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('Castle_Contents', 'contentEx');

/**
 * Theme Init
 * 
 * @param $archive  Widget_Archive
 */
function themeInit($archive) {
 Helper::options()->commentsAntiSpam = false; //关闭评论反垃圾(否则与PJAX冲突)
 Helper::options()->commentsMarkdown = true; //启用评论可使用MarkDown语法
 Helper::options()->commentsCheckReferer = false; //关闭检查评论来源URL与文章链接是否一致判断(否则会无法评论)
 Helper::options()->commentsPageBreak = true; //是否开启评论分页
 Helper::options()->commentsPageSize = 5; //评论每页显示条数
 Helper::options()->commentsPageDisplay = 'first'; //默认显示第一页
 Helper::options()->commentsOrder = 'DESC'; //将较新的评论展示在第一页
 Helper::options()->commentsMaxNestingLevels = 999; //最大回复层数
 Helper::options()->commentsHTMLTagAllowed = '<a href=""> <img src=""> <img src="" class=""> <code> <del>'; //评论允许使用的标签

 //站点配置文件
 if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$_GET["action"] == 'siteConfig') {
  Castle_API::siteConfig();
  die();
 }

 //登陆

 if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$_GET["action"] == 'login' && @$_GET['_'] != NULL && Helper::options()->sidebarToolsBar && in_array('login', Helper::options()->sidebarToolsBar)) {
  header('Content-type: application/json');
  echo json_encode((new TypechoLogin())->Login());
  die();
 }

 //退出登录
 if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$_GET["action"] == 'logout' && @$_GET['_'] != NULL && Helper::options()->sidebarToolsBar && in_array('login', Helper::options()->sidebarToolsBar)) {
  header('Content-type: application/json');
  echo json_encode((new TypechoLogin())->Logout());
  die();
 }

 //获取登陆状态
 if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$_GET["action"] == 'hasLogin') {
  Typecho_Widget::widget('Widget_User')->to($user);
  if ($user->hasLogin()) {
   $arr['status'] = true;
  }else{
   $arr['status'] = false;
  }
  header('Content-type: application/json');
  echo json_encode($arr);
  die();
 }

 //获取评论者头像
 if ($_SERVER['REQUEST_METHOD'] == 'GET' && @$_GET["action"] == 'ajax_get_avatar') {
  echo Castle_Avatar::getCommentAvatar($_GET['email'], 100);
  die();
 }
}

/**
 * 自定义字段
 */
function themeFields($layout) {
 $excerpt = new Typecho_Widget_Helper_Form_Element_Textarea('excerpt', null, null, '文章摘要', '自定义简介摘要，如不填将自动摘取前 100 字。');
 $layout->addItem($excerpt);

 $cover = new Typecho_Widget_Helper_Form_Element_Text('cover', NULL, NULL, _t('文章封面图'), _t('自定义封面，如不填将显示随机封面图。'));
 $layout->addItem($cover);

 //对于魔改的后台模板不保证能正常判断
 preg_match('/write-post.php/', $_SERVER['SCRIPT_NAME'], $post);

 //咕咕咕咕咕咕咕咕咕咕咕咕咕咕咕咕咕咕咕咕
 /*if(@$post[0] == 'write-post.php') {
  $PostType = new Typecho_Widget_Helper_Form_Element_Select('PostType',
   array(
	'post'=>'文章(默认)',
	'nopic'=>'无图',
	'dynamic'=>'日常'
   ),
  'post','文章类型','设置发表的文章的类型(仅对文章有效)。');
  $layout->addItem($PostType);
 }*/

 $advancedSettings = new Typecho_Widget_Helper_Form_Element_Textarea('advancedSettings', NULL, NULL,
 '高级设置', '文章/独立页高级设置，如果不懂此有何用请勿填写。');
 $layout->addItem($advancedSettings);
}

/**
 * HTML 压缩
 * 
 * @author LiNPX
 * @link https://www.linpx.com/p/pinghsu-subject-integration-code-compression.html
 */
function compressHtml($html_source) {
 $chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
 $compress = '';
 foreach ($chunks as $c) {
  if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
   $c = substr($c, 19, strlen($c) - 19 - 20);
   $compress .= $c;
   continue;
  }else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
   $c = substr($c, 12, strlen($c) - 12 - 13);
   $compress .= $c;
   continue;
  }elseif (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
   $compress .= $c;
   continue;
  }elseif (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
   $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
   $c = '';
   foreach ($tmps as $tmp) {
    if (strpos($tmp, '//') !== false) {
     if (substr(trim($tmp), 0, 2) == '//') {
      continue;
     }
     $chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
     $is_quot = $is_apos = false;
     foreach ($chars as $key => $char) {
      if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
       $is_quot = !$is_quot;
      }elseif ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
       $is_apos = !$is_apos;
      }elseif ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
       $tmp = substr($tmp, 0, $key);
       break;
      }
     }
    }
    $c .= $tmp;
   }
  }
  $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
  $c = preg_replace('/\\s{2,}/', ' ', $c);
  $c = preg_replace('/>\\s</', '> <', $c);
  $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
  $c = preg_replace('/<!--[^!]*-->/', '', $c);
  $compress .= $c;
 }
 return $compress;
}