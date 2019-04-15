<?php
/**
 * Functions
 * Version 0.1.5
 * Author ohmyga( https://ohmyga.cn/ )
 * 2019/04/10
 **/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

define("THEME_NAME", "Castle");
define("CASTLE_VERSION", "0.1.0");

require_once("libs/setting.php");

/* 文章or页面类型 */
function themeFields($layout) {
?>
<style>#custom-field input{ width:100%; }textarea{ height: 180px; width: 100%;}</style>
<?php
 $wzimg = new Typecho_Widget_Helper_Form_Element_Text('wzimg', NULL, NULL, _t('文章/独立页面封面图'), _t('如果不填将显示随机封面图'));
 $layout->addItem($wzimg);
 
 $PostType = new Typecho_Widget_Helper_Form_Element_Select('PostType',
   array(
	'post'=>'文章',
	'nopic'=>'无图',
	'dynamic'=>'日常'
   ),
  'post','文章类型','设置发表的文章的类型(仅对文章有效)');
 $layout->addItem($PostType);
 
/* $PageType = new Typecho_Widget_Helper_Form_Element_Select('PageType',
   array(
	'page'=>'默认',
	'links'=>'友链',
	'bangumi'=>'追番'
   ),
  'page','独立页面类型','请根据页面模板选择类型，普通页面保持默认即可(仅对页面有效)');
 $layout->addItem($PageType);*/
 
/* $PSetting = new Typecho_Widget_Helper_Form_Element_Textarea('PSetting', NULL, NULL,
 '高级设置', '文章/独立页高级设置，如果不懂此有何用请勿填写。');
 $layout->addItem($PSetting);*/
}

function themeInit($comment) {
 Helper::options()->commentsAntiSpam = false; //关闭评论反垃圾(否则与PJAX冲突)
 Helper::options()->commentsHTMLTagAllowed = '<a href=""> <img src=""> <img src="" class=""> <code> <del>'; //评论允许使用的标签
 Helper::options()->commentsMarkdown = true; //启用评论可使用MarkDown语法
 Helper::options()->commentsCheckReferer = false; //关闭检查评论来源URL与文章链接是否一致判断(否则会无法评论)
 Helper::options()->commentsPageBreak = true; //是否开启评论分页
 Helper::options()->commentsPageSize = 5; //评论每页显示条数
 Helper::options()->commentsPageDisplay = 'first'; //默认显示第一页
 Helper::options()->commentsOrder = 'DESC'; //将较新的评论展示在第一页

 /* AJAX获取评论者Gravatar头像 */ 
 if(isset($_GET["action"]) == 'ajax_avatar_get' && 'GET' == $_SERVER['REQUEST_METHOD'] ) {
   $host = 'https://cdn.v2ex.com/gravatar/';
   $email = strtolower($_GET['email']);
   $hash = md5($email);
   $qq = str_replace('@qq.com','',$email);
   $sjtx = 'mm';
   if(strstr($email,"qq.com") && is_numeric($qq) && strlen($qq) < 11 && strlen($qq) > 4) {
    $avatar = 'https://q.qlogo.cn/g?b=qq&nk='.$qq.'&s=640';
   }else{
    $avatar = $host.$hash.'?d='.$sjtx;
   }
   echo $avatar; 
   die();
 }else{
   return;
 }
}

/* 文章阅读次数(含Cookie) */
function PostView($archive) {
 $cid    = $archive->cid;
 $db     = Typecho_Db::get();
 $prefix = $db->getPrefix();
 if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
  $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
  echo 0;
  return;
 }
   
 $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
 if ($archive->is('single')) {
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

/* 文章or页面高级设置 */
function PSetting($type) {
 $setting = Typecho_Widget::widget("Widget_Archive")->fields->PSetting;
 if (json_decode($setting) == null) {
  $output = null;
 } else {
  $data = json_decode($setting, true);
  $output = $data[''.$type.''];
 }
 return $output;
}

/* 高级设置 */
function adSetting($a, $b, $c=NULL, $moe=NULL){
 $data = Helper::options()->advancedSetting;
 $set = json_decode($data, true);
 if (!empty($a) && !empty($b) && !empty($c)) {
  $output = $set[$a][$b][$c];
 }elseif (!empty($a) && !empty($b)) {
  $output = $set[$a][$b];
 }elseif (!empty($a)) {
  $output = $set[$a];
 }
 return $output;
}

/* 随机封面图 */
function randPic() {
 $setting = Helper::options()->randimg;
 $rand = rand(0,99); //防止只获取一张图
 if ($setting == 'api.ohmyga.cn') {
  $output = 'https://api.ohmyga.cn/wallpaper/?source=sina&rand='.$rand;
 }elseif ($setting == 'local') {
  $openfile = glob(Helper::options()->themeFile(getTheme(), "random/*.jpg"), GLOB_BRACE);
  $img = array_rand($openfile);
  preg_match('/\/random\/(.*).jpg/', $openfile[$img], $out);
  $output = Helper::options()->siteUrl.'usr/themes/'.getTheme().'/random/'.$out[1].'.jpg';
 }
 return $output;
}

/* 获取主题名称 */
function getTheme() {
 static $themeName = NULL;
 if ($themeName === NULL) {
  $db = Typecho_Db::get();
  $query = $db->select('value')->from('table.options')->where('name = ?', 'theme');
  $result = $db->fetchAll($query);
  $themeName = $result[0]["value"];
 }
 return $themeName;
}

/* 主题检查更新链接 */
function updateURL() {
 if (extension_loaded('openssl')) {
  $url = 'https://api.ohmyga.cc/';
 }else{
  $url = 'http://nossl.api.ohmyga.cc/';
 }
 return $url;
}

/* 主题检查更新&获取公告 */
function themeUpdate($type) {
 if ($type == 'GetNewVer') {
  $get_new_ver = file_get_contents(updateURL().'themes/update/?site='.$_SERVER['HTTP_HOST'].'&v='.CASTLE_VERSION.'&n='.THEME_NAME);
  $array = json_decode($get_new_ver, true);
  $output = $array['version'];
 }elseif ($type == 'check') {
  $get_new_ver = file_get_contents(updateURL().'themes/update/?site='.$_SERVER['HTTP_HOST'].'&v='.CASTLE_VERSION.'&n='.THEME_NAME);
  $array = json_decode($get_new_ver, true);
  $output = $array['message'];
 }elseif ($type == 'announcement') {
  $get_new_ver = file_get_contents(updateURL().'themes/update/?site='.$_SERVER['HTTP_HOST'].'&v='.CASTLE_VERSION.'&n='.THEME_NAME);
  $array = json_decode($get_new_ver, true);
  $output = $array['announcement'];
 }elseif($type == 'ajaxURL') {
  $output = updateURL().'themes/update/?site='.$_SERVER['HTTP_HOST'].'&v='.CASTLE_VERSION.'&n='.THEME_NAME;
 }
 
 return $output;
}

/* 主题版本 */
function themeVer($type) {
 if ($type == 'current') {
  $ver = CASTLE_VERSION;
 }elseif ($type == 'new'){
  $ver =  themeUpdate('GetNewVer');
 }
 return $ver;
}

/* 读取语言配置文件 */
function lang($type, $name){
 $file = Helper::options()->lang;
 $json_string = file_get_contents($file, true);
 $data = json_decode($json_string, true);
 $output = $data['0'][''.$type.''][''.$name.''];
 return $output;
}

/* 获取主题静态文件引用源 */
function themeResource($content) {
 $setting = Helper::options()->themeResource;
 
 if ($setting == 'local') {
  $output = Helper::options()->themeUrl.'/'.$content;
 }elseif ($setting == 'jsdelivr') {
  $output = 'https://cdn.jsdelivr.net/gh/ohmyga233/castle-Typecho-Theme@'.themeVer('current').'/'.$content;
 }

 return $output;
}

/* 获取Gravatr头像 */
function gravatar($email, $size){
 $urlSetting = 'https://'.Helper::options()->gravatar_url.'/';
 if (!empty($urlSetting)) {
  $url = $urlSetting;
 }else{
  $url = 'https://cdn.v2ex.com/gravatar/';
 }
 
 $host = $url;
 $hash = md5(strtolower($email));
 $output = $host.$hash.'?s='.$size;
 
 return $output;
}

/* 获取站点头像 */
function siteHeadimg($type, $moe=NULL) {
 $setting = Helper::options()->headimg;
 
 if ($type == 'ico') {
  if (!empty($setting)) {
   $headimg = $setting;
  }else{
   $headimg = themeResource('others/img/headimg.png');
  }
 }elseif ($type == 'pauthor') {
  if (!empty($setting)) {
   $headimg = $setting;
  }else{
   $headimg = gravatar($moe->author->mail, '100');
  }
 }
 return $headimg;
}

/* 获取评论者头像 */
function userHeadimg($moe=NULL) {
 $host = Helper::options()->gravatar_url;
 $hash = md5(strtolower($moe->mail));
 $email = strtolower($moe->mail);
 $qq = str_replace('@qq.com','',$email);
 if(strstr($email,"qq.com") && is_numeric($qq) && strlen($qq) < 11 && strlen($qq) > 4) {
  $avatar = 'https://q.qlogo.cn/g?b=qq&nk='.$qq.'&s=640';
 }else{
  $avatar = 'https://'.$host.'/'.$hash.'?s=640';
 }
 
 return $avatar;
}

/* 显示上一篇 */
function thePrev($widget, $default = NULL) {
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
      <a href="'.$content['permalink'].'" class="mdui-ripple mdui-col-xs-2 mdui-col-sm-6 moe-nav-left">
       <div class="moe-nav-text">
        <i class="mdui-icon material-icons">arrow_back</i>
        <span class="moe-nav-direction mdui-hidden-xs-down">'.lang('post', 'prev').'</span>
        <div class="moe-nav-chapter mdui-hidden-xs-down">'.$content['title'].'</div>
       </div>
      </a>';
  echo $link;
 } else {
  echo $default;
 }
}

/* 显示下一篇 */
function theNext($widget, $default = NULL) {
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
      <a href="'.$content['permalink'].'" class="mdui-ripple mdui-col-xs-10 mdui-col-sm-6 moe-nav-right">
       <div class="moe-nav-text">
        <i class="mdui-icon material-icons">arrow_forward</i>
        <span class="moe-nav-direction">'.lang('post', 'next').'</span>
        <div class="moe-nav-chapter">'.$content['title'].'</div>
       </div>
      </a>';
  echo $link;
 } else {
  echo $default;
 }
}

/* Tag随机颜色 */
function randColor() {
 $before = 'mdui-text-color-';
 $randNum1 = rand(0,18);
 $colorArray = array('red','pink','purple','deep-purple','indigo','blue','light-blue','cyan','teal','green','light-green','lime','yellow','amber','orange','deep-orange','brown','grey','blue-grey');
 $output = $before.$colorArray[$randNum1];
 return $output;
}

/* Tag字体大小 */
function fTag($t, $moe=NULL) {
 $num = 14;
 $count = $moe->count;
 if ($count <= 10){
  $output = $num+$count;
 }else{
  $output = $num+$count/2;
 }
 return $output;
}

/* 解析文章/页面作者 */
function Jauthor($moe=NULL) {
 $json = json_encode($moe->author);
 $jsonde = json_decode($json, true);
 $output = $jsonde['stack'][0]['name'];
 return $output;
}

/* 输出文章/页面版权 */
function Pcopy($type, $moe=NULL) {
 if ($type == 'post') {
  $copyText = lang('post', 'copy');
 }elseif ($type == 'page'){
  $copyText = lang('page', 'copy');
 }else{}
 $Tauthor = preg_replace('/%author/', Jauthor($moe), $copyText);
 $Ttime = preg_replace('/%time/', date('Y-m-d H:i:s', $moe->modified), $Tauthor);
 $Tlink = preg_replace('/%link/', $moe->permalink, $Ttime);
 $output = $Tlink;
 return $output;
}

function DrawerMenu() {
 $data = Helper::options()->sidebar;
 if (!empty($data)) {
  $json = json_decode($data, true);
  foreach($json as $i) {
   if ($i['type'] == '0') {
    echo '<a href="'.$i['link'].'" class="mdui-list-item mdui-ripple" mdui-drawer-close>
     <i class="mdui-icon material-icons mdui-list-item-icon">'.$i['icon'].'</i>
     <div class="mdui-list-item-content">'.$i['name'].'</div>
    </a>';
   }elseif ($i['type'] == '1') {
	echo '<li class="mdui-collapse-item">
     <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
      <i class="mdui-icon material-icons mdui-list-item-icon">'.$i['icon'].'</i>
      <div class="mdui-list-item-content">'.$i['name'].'</div>
      <i class="mdui-icon material-icons mdui-list-item-icon mdui-collapse-item-arrow">keyboard_arrow_down</i>
     </div>
     <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">';
	  Typecho_Widget::widget('Widget_Contents_Post_Date', 'type=month&format=F Y')->parse('<a href="{permalink}" class="mdui-list-item mdui-ripple" mdui-drawer-close>{date}</a>');
	echo '</ul>
    </li>';
   }elseif ($i['type'] == '2') {
	echo '<li class="mdui-collapse-item">
     <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
      <i class="mdui-icon material-icons mdui-list-item-icon">'.$i['icon'].'</i>
      <div class="mdui-list-item-content">'.$i['name'].'</div>
      <i class="mdui-icon material-icons mdui-list-item-icon mdui-collapse-item-arrow">keyboard_arrow_down</i>
     </div>
     <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">';
	  Typecho_Widget::widget('Widget_Metas_Category_List')->parse('<a href="{permalink}" class="mdui-list-item mdui-ripple" mdui-drawer-close>{name} &nbsp; <span class="moe-cl-a">{count}</span></a>');
	echo '</ul>
    </li>';
   }elseif ($i['type'] == '3') {
    Typecho_Widget::widget('Widget_Contents_Page_List')->to($pages);
	echo '<li class="mdui-collapse-item">
     <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
      <i class="mdui-icon material-icons mdui-list-item-icon">'.$i['icon'].'</i>
      <div class="mdui-list-item-content">'.$i['name'].'</div>
      <i class="mdui-icon material-icons mdui-list-item-icon mdui-collapse-item-arrow">keyboard_arrow_down</i>
     </div>
     <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">';
	 while($pages->next()){
	  echo '<a class="mdui-list-item mdui-ripple" href="'.$pages->permalink.'" mdui-drawer-close>'.$pages->title.'</a>';
	 }
	echo '</ul>
    </li>';
   }elseif ($i['type'] == '4') {
     echo '<li class="mdui-collapse-item">
     <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
      <i class="mdui-icon material-icons mdui-list-item-icon">'.$i['icon'].'</i>
      <div class="mdui-list-item-content">'.$i['name'].'</div>
      <i class="mdui-icon material-icons mdui-list-item-icon mdui-collapse-item-arrow">keyboard_arrow_down</i>
     </div>
     <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">';
	 foreach($i['list'] as $ii){ echo '<a class="mdui-list-item mdui-ripple" href="'.$ii['link'].'" mdui-drawer-close>'.$ii['name'].'</a>'; }
	echo '</ul>
    </li>';
   }elseif ($i['type'] == '5') {
    echo '<div class="mdui-divider"></div>';
   }elseif ($i['type'] == '6') {
	echo '<a href="'.Helper::options()->siteUrl.'feed" target="_blank" class="mdui-list-item mdui-ripple" mdui-drawer-close>
     <i class="mdui-icon material-icons mdui-list-item-icon">rss_feed</i>
     <div class="mdui-list-item-content">RSS订阅</div>
    </a>';
   }elseif ($i['type'] == '7') {
    Typecho_Widget::widget('Widget_Stat')->to($stat);
    if ($i['tes'] == '1') {
      echo '<li class="mdui-list-item mdui-ripple" disabled>
     <div class="mdui-list-item-content">'.lang('sidebar', 'postAllNumber').'</div>
     <div class="mdui-list mdui-float-right">
      <span class="moe-sidebar-count">'.$stat->publishedPostsNum.'</span>
     </div>
    </li>';
    }elseif ($i['tes'] == '2') {
     echo '<li class="mdui-list-item mdui-ripple" disabled>
     <div class="mdui-list-item-content">'.lang('sidebar', 'pageAllNumber').'</div>
     <div class="mdui-list mdui-float-right">
      <span class="moe-sidebar-count">'.$stat->publishedPagesNum.'</span>
     </div>
    </li>';
	}elseif ($i['tes'] == '3') {
     echo '<li class="mdui-list-item mdui-ripple" disabled>
     <div class="mdui-list-item-content">'.lang('sidebar', 'categoriesAllNumber').'</div>
     <div class="mdui-list mdui-float-right">
      <span class="moe-sidebar-count">'.$stat->categoriesNum.'</span>
     </div>
    </li>';
	}elseif ($i['tes'] == '4') {
     echo '<li class="mdui-list-item mdui-ripple" disabled>
     <div class="mdui-list-item-content">'.lang('sidebar', 'commentAllNumber').'</div>
     <div class="mdui-list mdui-float-right">
      <span class="moe-sidebar-count">'.$stat->publishedCommentsNum.'</span>
     </div>
    </li>';
	}
   }
  }
 }
}

/* 解析底部社交信息 */
function FooterSocial() {
 $data = Helper::options()->social;
 if (!empty($data)) {
  $json = json_decode($data, true);
  foreach($json as $i) {
   echo '<a href="'.$i['link'].'" target="_blank"><button class="mdui-btn mdui-btn-icon mdui-ripple moe-footer-i" mdui-tooltip="{content: \''.$i['name'].'\'}">'.$i['icon'].'</button></a>';
  }
 }
}

/* 文章or独立页分享*/
function Pshare($t,$moe=NULL) {
 $wzimg = '';
 if ($t == 'post'){
  $Pt = 'post';
 }elseif($t == 'page'){
  $Pt = 'page';
 }
 $qq = '<li class="mdui-menu-item">
        <a href="http://connect.qq.com/widget/shareqq/index.html?site='.Helper::options()->title.'&amp;title='.$moe->title.'&amp;summary='.$moe->title.'&amp;pics='.$wzimg.'&amp;url='.$moe->permalink.'" target="_blank" class="mdui-ripple">
         <strong>'.lang($Pt,'shareQQ').'</strong>
        </a>
       </li>';

 $weibo = '<li class="mdui-menu-item">
        <a href="" class="mdui-ripple">
         <strong>'.lang($Pt,'shareWB').'</strong>
        </a>
       </li>';

 $facebook = '<li class="mdui-menu-item">
        <a href="http://www.facebook.com/sharer/sharer.php?u='.$moe->permalink.'" target="_blank" class="mdui-ripple">
         <strong>'.lang($Pt,'shareFB').'</strong>
        </a>
       </li>';

 $twitter = '<li class="mdui-menu-item">
        <a href="https://twitter.com/intent/tweet?text='.$moe->title.';url='.$moe->permalink.';via='.Jauthor($moe).'" target="_blank" class="mdui-ripple">
         <strong>'.lang($Pt,'shareTW').'</strong>
        </a>
       </li>';
 return $qq.$weibo.$twitter.$facebook;
}

/* Original Author 熊猫小A (https://blog.imalan.cn/) */
/* 解析表情、灯箱，获取第一管理员邮箱、名称 */
class Castle {
 public static function getAdminScreenName(){
  $db = Typecho_Db::get();
  $name = $db->fetchRow($db->select()->from('table.users')->where('uid = ?', 1))['screenName'];
  return $name;
 }

 public static function getAdminMail(){
  $db = Typecho_Db::get();
  $mail = $db->fetchRow($db->select()->from('table.users')->where('uid = ?', 1))['mail'];
  return $mail;
}

 static public function parseAll($content,$parseBoard=false){
  $new  = self::parseBiaoQing(self::parseFancyBox(self::parseRuby($content)));
  if($parseBoard){
   return self::parseBoard($new);
  }else{
   return $new;
  }
 }

 static public function parseBiaoQing($content){
  $content = preg_replace_callback('/\:\s*(a|bishi|bugaoxing|guai|haha|han|hehe|heixian|huaji|huanxin|jingku|jingya|landeli|lei|mianqiang|nidongde|pen|shuijiao|suanshuang|taikaixin|tushe|wabi|weiqu|what|what|wuzuixiao|xiaoguai|xiaohonglian|xiaoniao|xiaoyan|xili|yamaidei|yinxian|yiwen|zhenbang|aixin|xinsui|bianbian|caihong|damuzhi|dangao|dengpao|honglingjin|lazhu|liwu|meigui|OK|shafa|shouzhi|taiyang|xingxingyueliang|yaowan|yinyue)\s*\:/is',
   array('Castle', 'parsePaopaoBiaoqingCallback'), $content);
  $content = preg_replace_callback('/\:\s*(huaji1|huaji2|huaji3|huaji4|huaji5|huaji6|huaji7|huaji8|huaji9|huaji10|huaji11|huaji12|huaji13|huaji14|huaji15|huaji16|huaji17|huaji18|huaji19|huaji20|huaji21|huaji22)\s*\:/is',
   array('Castle', 'parseHuajibiaoqingCallback'), $content);
  $content = preg_replace_callback('/\:\s*(qwq1|qwq2|qwq3|qwq4|qwq5|qwq6|qwq7|qwq8|qwq9|qwq10|qwq11|qwq12|qwq13|qwq14|qwq15|qwq16|qwq17|qwq18|qwq19|qwq20|qwq21|qwq22|qwq23|qwq24|qwq25|qwq26)\s*\:/is',
   array('Castle', 'parseqwqbiaoqingCallback'), $content);
  return $content;
 }

 private static function parsePaopaoBiaoqingCallback($match){
  return '<img class="moe-owo-img-tieba" src="'.Helper::options()->themeUrl.'/others/img/OwO/tieba/'.$match[1].'.png">';
 }
	
 private static function parseHuajibiaoqingCallback($match){
  return '<img class="moe-owo-img-hj" src="'.Helper::options()->themeUrl.'/others/img/OwO/huaji/'.$match[1].'.gif">';
 }
 
 private static function parseqwqbiaoqingCallback($match){
  return '<img class="moe-owo-img-qwq" src="'.Helper::options()->themeUrl.'/others/img/OwO/qwq/'.$match[1].'.png">';
 }

 static public function parseFancyBox($content){
  $reg = '/<img(.*?)src="(.*?)"(.*?)>/s';
  $rp = '<a data-fancybox="images" href="${2}"><img${1}src="'.themeResource('others/img/loading.gif').'"${3}data-original="${2}" class="mdui-shadow-3 moe-p-pic"></a>';
  $new = preg_replace($reg,$rp,$content);
  return $new;
}

 static public function parseRuby($string){
  $reg='/\{\{(.*?):(.*?)\}\}/s';
  $rp='<ruby>${1}<rp>(</rp><rt>${2}</rt><rp>)</rp></ruby>';
  $new=preg_replace($reg,$rp,$string);
  return $new;
 }
}

/* 获取浏览器信息 */
function getBrowser($agent) {
 if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
  $name = lang('ua', 'ie');
  $icon = 'icon-IE';
 }elseif (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
  $name = lang('ua', 'firefox');
  $icon = 'icon-firefox';
 }elseif (preg_match('/Maxthon([\d]*)\/([^\s]+)/i', $agent, $regs)) {
  $name = lang('ua', 'aoyou');
  $icon = 'icon-Aoyou_Browser';
 }elseif (preg_match('#SE 2([a-zA-Z0-9.]+)#i', $agent, $regs)) {
  $name = lang('ua', 'sougou');
  $icon = 'icon-Sougou_Browser';
 }elseif (preg_match('#360([a-zA-Z0-9.]+)#i', $agent, $regs)) {
  $name = lang('ua', '360');
  $icon = 'icon-360_Browser';
 }elseif (preg_match('/Edge([\d]*)\/([^\s]+)/i', $agent, $regs)) {
  $name = lang('ua', 'edge');
  $icon = 'icon-edge';
 }elseif (preg_match('/QQ/i', $agent, $regs)||preg_match('/QQBrowser\/([^\s]+)/i', $agent, $regs)) {
  $name = lang('ua', 'qq');
  $icon = 'icon-QQBrowser';
 }elseif (preg_match('/UC/i', $agent)) {
  $name = lang('ua', 'uc');
  $icon = 'icon-UC_Browser';
 }elseif (preg_match('/UBrowser/i', $agent, $regs)) {
  $name = lang('ua', 'ub');
  $icon = 'icon-UC_Browser';
 }elseif (preg_match('/MicroMesseng/i', $agent, $regs)) {
  $name = lang('ua', 'wechat');
  $icon = 'icon-wechat';
 }elseif (preg_match('/WeiBo/i', $agent, $regs)) {
  $name = lang('ua', 'weibo');
  $icon = 'icon-weibo';
 }elseif (preg_match('/BIDU/i', $agent, $regs)) {
  $name = lang('ua', 'baidu');
  $icon = 'icon-Baidu_Browser';
 }elseif (preg_match('/LBBROWSER/i', $agent, $regs)) {
  $name = lang('ua', 'lb');
  $icon = 'icon-LBBROWSER';
 }elseif (preg_match('/TheWorld/i', $agent, $regs)) {
  $name = lang('ua', 'tw');
  $icon = 'icon-TheWorld_Browser';
 }elseif (preg_match('/XiaoMi/i', $agent, $regs)) {
  $name = lang('ua', 'xiaomi');
  $icon = 'icon-xiaomi';
 }elseif (preg_match('/2345Explorer/i', $agent, $regs)) {
  $name = lang('ua', '2345');
  $icon = 'icon-2345_Browser';
 }elseif (preg_match('/YaBrowser/i', $agent, $regs)) {
  $name = lang('ua', 'yandex');
  $icon = 'icon-Yandex_Browser';
 }elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
  $name = lang('ua', 'opera');
  $icon = 'icon-Opera_Browser';
 }elseif (preg_match('/Thunder/i', $agent, $regs)) {
  $name = lang('ua', 'xunlie');
  $icon = 'icon-xunlei';
 }elseif (preg_match('/Chrome([\d]*)\/([^\s]+)/i', $agent, $regs)) {
  $name = lang('ua', 'chrome');
  $icon = 'icon-chrome';
 }elseif (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
  $name = lang('ua', 'safari');
  $icon = 'icon-safari';
 }else{
  $name = lang('ua', 'other');
  $icon = 'icon-Browser';
 }
 echo '<i class="iconfont '.$icon.' moe-comments-ua" mdui-tooltip="{content: \''.$name.'\'}"></i>';
}

/* 获取操作系统 */
function getOs($agent) {
 if (preg_match('/win/i', $agent)) {
  if (preg_match('/nt 5.1/i', $agent)) {
   $name = lang('os', 'windows xp');
   $icon = 'icon-windows_old';
  }elseif (preg_match('/nt 6.0/i', $agent)) {
   $name = lang('os', 'windows vista');
   $icon = 'icon-windows_old';
  }elseif (preg_match('/nt 6.1/i', $agent)) {
   $name = lang('os', 'windows 7');
   $icon = 'icon-windows_old';
  }elseif (preg_match('/nt 6.2/i', $agent)) {
   $name = lang('os', 'windows 8');
   $icon = 'icon-windows';
  }elseif (preg_match('/nt 6.3/i', $agent)) {
   $name = lang('os', 'windows 8.1');
   $icon = 'icon-windows';
  }elseif (preg_match('/nt 10.0/i', $agent)) {
   $name = lang('os', 'windows 10');
   $icon = 'icon-windows';
  }else{
   $name = lang('os', 'windows xp');
   $icon = 'icon-windows';
  }
 }elseif (preg_match('/android/i', $agent)) {
  if (preg_match('/android 5/i', $agent)) {
   $name = lang('os', 'android l');
   $icon = 'icon-android';
  }elseif (preg_match('/android 6/i', $agent)) {
   $name = lang('os', 'android m');
   $icon = 'icon-android';
  }elseif (preg_match('/android 7/i', $agent)) {
   $name = lang('os', 'android n');
   $icon = 'icon-android';
  }elseif (preg_match('/android 8/i', $agent)) {
   $name = lang('os', 'android o');
   $icon = 'icon-android';
  }elseif (preg_match('/android 9/i', $agent)) {
   $name = lang('os', 'android p');
   $icon = 'icon-android';
  }else{
   $name = lang('os', 'android');
   $icon = 'icon-android';
  }
 }elseif (preg_match('/linux/i', $agent)) {
  $name = lang('os', 'linux');
  $icon = 'icon-linux';
 }elseif (preg_match('/iPhone/i', $agent)) {
  $name = lang('os', 'iphone');
  $icon = 'icon-ios';
 }elseif (preg_match('/iPad/i', $agent)) {
  $name = lang('os', 'ipad');
  $icon = 'icon-ios';
 }elseif (preg_match('/mac/i', $agent)) {
  $name = lang('os', 'mac os');
  $icon = 'icon-osx';
 }else{
  $name = lang('os', 'other');
  $icon = 'icon-os';
 }
 echo '<i class="iconfont '.$icon.' moe-comments-ua" mdui-tooltip="{content: \''.$name.'\'}"></i>';
}

/* HTML压缩 */
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
    } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
      $compress .= $c;
      continue;
    }else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
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
            }else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
               $is_apos = !$is_apos;
            }else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
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