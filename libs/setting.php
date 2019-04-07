<?php
/**
 * ThemeSetting
 * 
 * @author ohmyga
 * @link https://ohmyga.net/
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function themeConfig($form) {
  echo '<style>textarea{ height: 180px; width: 100%;}</style>';
  echo '<link rel="stylesheet" href="'.themeResource('others/css/setting.min.css').'" />';
  echo '<div class="moe-panel">
   <span class="moe-title">Castle 设置面板</span>
   <span class="moe-current-ver">本地版本: '.themeVer('current').'</span>
   <span class="moe-new-ver">云端版本: '.themeUpdate('check').'</span>
   <span class="moe-announcement">公告: '.themeUpdate('announcement').'</span>
   </div>';
  $filenum = 0;
  $openfile = glob(Helper::options()->themeFile(getTheme(), "languages/*.json"));
  foreach ($openfile as $v) {
   if(is_file($v)) {
    $filenum++;
   }
  }
  for ($i=0; $i<=($filenum-1); $i++) {
   $file = $openfile[$i];
   $file_get = file_get_contents($file, true);
   $data = json_decode($file_get, true);
   $name = $data['0']['name'];
   $output[$file] = $name;
  }
  $lang = new Typecho_Widget_Helper_Form_Element_Select('lang', $output, Helper::options()->themeFile(getTheme(), "languages/zh-CN.json"), 
  _t('语言'),
  _t('主题语言配置文件'));
  $form->addInput($lang->multiMode());
  
  $themecolor = new Typecho_Widget_Helper_Form_Element_Select('themecolor',array(
   'red' => 'Red',
   'pink' => 'Pink',
   'purple' => 'Purple',
   'deep-purple' => 'Deep Purple',
   'indigo' => 'Indigo',
   'blue' => 'Blue',
   'light-blue' => 'Light Blue',
   'cyan' => 'Cyan',
   'teal' => 'Teal',
   'green' => 'Green',
   'light-green' => 'Light Green',
   'lime' => 'Lime',
   'yellow' => 'Yellow',
   'amber' => 'Amber',
   'orange' => 'Orange',
   'deep-orange' => 'Deep Orange',
   'brown' => 'Brown',
   'grey' => 'Grey',
   'blue-grey' => 'Blue Grey'
  ),
  'pink',
  _t('主题色'),
  _t('请选择主题的颜色'));
  $form->addInput($themecolor->multiMode());
  
  $accentcolor = new Typecho_Widget_Helper_Form_Element_Select('accentcolor',array(
   'red' => 'Red',
   'pink' => 'Pink',
   'purple' => 'Purple',
   'deep-purple' => 'Deep Purple',
   'indigo' => 'Indigo',
   'blue' => 'Blue',
   'light-blue' => 'Light Blue',
   'cyan' => 'Cyan',
   'teal' => 'Teal',
   'green' => 'Green',
   'light-green' => 'Light Green',
   'lime' => 'Lime',
   'yellow' => 'Yellow',
   'amber' => 'Amber',
   'orange' => 'Orange',
   'deep-orange' => 'Deep Orange'
  ),
  'pink',
  _t('主题强调色'),
  _t('请选择主题的强调颜色'));
  $form->addInput($accentcolor->multiMode());
  
  $themeResource = new Typecho_Widget_Helper_Form_Element_Select('themeResource',array(
    'local' => '本地',
	'jsdelivr' => 'JSdelivr',
	'cdn' => '第三方CDN'
  ),
  'local',
  _t('静态资源'),
  _t('主题静态资源引用'));
  $form->addInput($themeResource->multiMode());
  
  $randimg = new Typecho_Widget_Helper_Form_Element_Select('randimg',array(
    'local' => '本地',
	'api.ohmyga.cn' => 'api.ohmyga.cn',
	'others' => '第三方API'
  ),
  'api.ohmyga.cn',
  _t('封面图源'),
  _t('文章随机封面图源'));
  $form->addInput($randimg->multiMode());
  
  $gravatar_url = new Typecho_Widget_Helper_Form_Element_Select('gravatar_url',array(
    'www.gravatar.com/avatar' => 'Gravatar www源',
	'secure.gravatar.com/avatar' => 'Gravatar secure源',
	'cn.gravatar.com/avatar' => 'Gravatar cn源',
	'cdn.v2ex.com/gravatar' => 'V2EX源'
  ),
  'cdn.v2ex.com/gravatar',
  _t('Gravatar源'),
  _t('请选择Gravatar头像源'));
  $form->addInput($gravatar_url->multiMode());
  
  $headimg = new Typecho_Widget_Helper_Form_Element_Text('headimg', NULL, NULL, _t('站点图标'), _t('作者/博主全站头像'));
  $form->addInput($headimg);
  
  $bgurl = new Typecho_Widget_Helper_Form_Element_Text('bgurl', NULL, NULL, _t('站点背景'), _t('如果不填将用浅灰色代替背景'));
  $form->addInput($bgurl);
  
  $miibeian = new Typecho_Widget_Helper_Form_Element_Text('miibeian', NULL, '', _t('备案号'), _t('输入备案号，不填写将不显示'));
  $form->addInput($miibeian);
  
  $sidebar = new Typecho_Widget_Helper_Form_Element_Textarea('sidebar', NULL, '[{
   "name":"归档",
   "link":"#",
   "icon":"access_time",
   "type":"1"
 },{
   "name":"分类",
   "link":"#",
   "icon":"view_list",
   "type":"2"
 },{
   "name":"页面",
   "link":"#",
   "icon":"view_carousel",
   "type":"3"
 },{
   "type":"5"
 },{
   "type":"6"
 },{
   "type":"5"
 },{
   "type":"7",
   "tes":"1"
 },{
   "type":"7",
   "tes":"2"
 },{
   "type":"7",
   "tes":"3"
 },{
   "type":"7",
   "tes":"4"
}]', _t('侧边抽屉'), _t('侧边抽屉设置，用法参考文档'));
  $form->addInput($sidebar);
  
  $social = new Typecho_Widget_Helper_Form_Element_Textarea('social', NULL, '[{
 "name": "email",
 "icon": "<i class=\"mdui-icon material-icons\">email</i>",
 "link": "#"
}]', _t('底部社交'), _t('底部社交设置，用法参考文档'));
  $form->addInput($social);
  
  $statistics = new Typecho_Widget_Helper_Form_Element_Textarea('statistics', NULL, '', _t('统计代码'), _t('数据统计代码，将不会显示在页面中'));
  $form->addInput($statistics);
  
  $pjaxRelaod = new Typecho_Widget_Helper_Form_Element_Textarea('pjaxRelaod', NULL, '', _t('PJAX重载函数'), _t('将需要重载的函数填在此，一行一条，注意符号'));
  $form->addInput($pjaxRelaod);
}

function foinfo() {
 if (Helper::options()->miibeian){
  $ba = '<a href="http://www.miitbeian.gov.cn/" target="_blank">'.Helper::options()->miibeian.'</a><br>';
 }else{
  $ba = null;
 }
 $output = '
     This <span class="mdui-list-item-content"><a href="https://github.com/ohmyga233/castle-Typecho-Theme" target="_blank">Theme</a> By <a href="https://ohmyga.cn/" target="_blank">ohmyga</a>😋</span><br>
     '.$ba.'
     Powered By <a href="http://typecho.org/" target="_blank">Typecho</a>';
 return $output;
}