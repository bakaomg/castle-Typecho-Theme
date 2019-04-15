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
  echo '<script src="'.themeResource('others/js/jquery3.3.1.min.js').'"></script>
  <script>
  $.ajax({
   type: "GET",
   url: "'.themeUpdate('ajaxURL').'",
   beforeSend: function(xhr) {
    $(\'#newVer\').html(\'正在获取新版本中...\');
    $(\'#acGet\').html(\'正在获取公告中...\');
   },
   success: function(data) {
    $(\'#newVer\').html(data.version);
	$(\'#acGet\').html(data.announcement);
   },
   error: function(xhr, textStatus, errorThrown) {
    $(\'#newVer\').html(\'新版本获取出错\');
    $(\'#acGet\').html(\'公告获取出错\');
   }
  });
  </script>';
  echo '<div class="moe-panel">
   <span class="moe-title">Castle 设置面板</span>
   <span class="moe-current-ver">本地版本: '.themeVer('current').'</span>
   <span class="moe-new-ver">云端版本: <span id="newVer">正在获取新版本中...</span></span>
   <span class="moe-announcement">公告: <span id="acGet">正在获取公告中...</span></span>
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
  
  $cardt = new Typecho_Widget_Helper_Form_Element_Select('cardt',array(
    '0' => '不透明',
	'10' => '10%',
	'20' => '20%',
	'30' => '30%',
  ),
  '0',
  _t('卡片透明度'),
  _t('全部卡片透明度，开启透明度夜间模式将无效(隐藏)'));
  $form->addInput($cardt->multiMode());
  
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
  
  $comment = new Typecho_Widget_Helper_Form_Element_Checkbox('comment', array(
	'userUA' => _t('显示评论者UA'),
	'ajax' => _t('启用ajax提交评论'),
	'link' => _t('显示链接填写按钮')
  ),
  array('userUA', 'ajax', 'link'), _t('评论设置'));
  $form->addInput($comment->multiMode());
  
  $other = new Typecho_Widget_Helper_Form_Element_Checkbox('other', array(
	'copy' => _t('复制内容提示'),
	'pjax' => _t('启用PJAX无刷新'),
	'gotop' => _t('右下返回顶部按钮'),
	'title' => _t('失去/恢复焦点标题变化'),
	'html' => _t('启用HTML压缩 (代码来自<a href="https://www.linpx.com/p/pinghsu-subject-integration-code-compression.html" target="_blank">LiNPX</A>，可能有部分插件不兼容)')
  ),
  array('copy', 'pjax', 'gotop'), _t('其他设置'));
  $form->addInput($other->multiMode());
  
  $headimg = new Typecho_Widget_Helper_Form_Element_Text('headimg', NULL, NULL, _t('站点图标'), _t('作者/博主全站头像'));
  $form->addInput($headimg);
  
  $bgp = new Typecho_Widget_Helper_Form_Element_Text('bgp', NULL, '', _t('宽屏背景'), _t('宽度大于600PX的设备显示的壁纸，不填默认将以灰色代替'));
  $form->addInput($bgp);
  
  $bgs = new Typecho_Widget_Helper_Form_Element_Text('bgs', NULL, '', _t('小屏背景'), _t('宽度小于或等于600PX的设备显示的壁纸，如果宽屏不填默认将以灰色代替'));
  $form->addInput($bgs);
  
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
  
  $advancedSetting = new Typecho_Widget_Helper_Form_Element_Textarea('advancedSetting', NULL, '{
 "setting": {
  "leave": {
   "title": "悄悄藏好 (/ω＼) ",
   "icon": ""
  },
  "return": {
   "title": "被找到惹 Σ(っ °Д °;)っ ",
   "icon": ""
  },
  "copyPrompt": {
   "text": "转载请保留相应版权！",
   "title": "警告"
  },
  "toTopText": "回到顶部~"
 }
}', _t('高级设置'), _t('主题高级设置，用法参考文档'));
  $form->addInput($advancedSetting);
}