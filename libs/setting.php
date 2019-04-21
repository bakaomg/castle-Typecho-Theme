<?php
/**
 * ThemeSetting
 * 
 * @author ohmyga
 * @link https://ohmyga.net/
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function themeConfig($form) {
  /* 模板设置备份功能来自QQdie( https://qqdie.com/ ) 
   * 稍微的魔改了一下下提示~
   */
  $db = Typecho_Db::get();
  $sjdq=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.getTheme().''));
  $ysj = $sjdq['value'];
  if(isset($_POST['type'])){ 
   if($_POST["type"]=="备份模板数据"){
    if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:CastleBackup'))){
     $update = $db->update('table.options')->rows(array('value'=>$ysj))->where('name = ?', 'theme:CastleBackup');
     $updateRows= $db->query($update);
     echo '<div class="message popup success moe-a" style="position: absolute; top: 36px; display: block;">备份已更新，请等待自动刷新！如果等不到请点击 <a href="'.Helper::options()->adminUrl.'options-theme.php">这里</a></div>
           <script language="JavaScript">window.setTimeout("location=\''.Helper::options()->adminUrl.'options-theme.php\'", 2500);</script>';
    }else{
     if($ysj){
      $insert = $db->insert('table.options')->rows(array('name' => 'theme:CastleBackup','user' => '0','value' => $ysj));
      $insertId = $db->query($insert);
      echo '<div class="message popup success moe-a" style="position: absolute; top: 36px; display: block;">备份完成，请等待自动刷新！如果等不到请点击 <a href="'.Helper::options()->adminUrl.'options-theme.php">这里</a></div>
            <script language="JavaScript">window.setTimeout("location=\''.Helper::options()->adminUrl.'options-theme.php\'", 2500);</script>';
     }
    }
   }
   if($_POST["type"]=="还原模板数据"){
    if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:CastleBackup'))){
    $sjdub=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:CastleBackup'));
    $bsj = $sjdub['value'];
    $update = $db->update('table.options')->rows(array('value'=>$bsj))->where('name = ?', 'theme:'.getTheme().'');
    $updateRows= $db->query($update);
    echo '<div class="message popup success moe-a" style="position: absolute; top: 36px; display: block;">检测到模板备份数据，恢复完成，请等待自动刷新！如果等不到请点击 <a href="'.Helper::options()->adminUrl.'options-theme.php">这里</a></div>
          <script language="JavaScript">window.setTimeout("location=\''.Helper::options()->adminUrl.'options-theme.php\'", 2000);</script>';
   }else{
    echo '<div class="message popup success moe-a" style="position: absolute; top: 36px; display: block;" id="del-error">恢复失败，因为你没备份过设置哇（；´д｀）ゞ</div>
	    <script language="JavaScript">
		 setTimeout( function(){$(\'#del-error\').removeClass(\'moe-a\');$(\'#del-error\').addClass(\'moe-a-off\');}, 2100 );
		 setTimeout( function(){$(\'#del-error\').attr(\'style\', \'display: none;\');}, 2300 );
		</script>';
  }
 }
 if($_POST["type"] == "删除备份数据"){
  if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:CastleBackup'))){
   $delete = $db->delete('table.options')->where ('name = ?', 'theme:CastleBackup');
   $deletedRows = $db->query($delete);
   echo '<div class="message popup success moe-a" style="position: absolute; top: 36px; display: block;">删除成功，请等待自动刷新，如果等不到请点击 <a href="'.Helper::options()->adminUrl.'options-theme.php">这里</a></div>
         <script language="JavaScript">window.setTimeout("location=\''.Helper::options()->adminUrl.'options-theme.php\'", 2500);</script>';
  }else{
   echo '<div class="message popup success moe-a" style="position: absolute; top: 36px; display: block;" id="del-error">删除失败，检测不到备份ㄟ( ▔, ▔ )ㄏ</div>
        <script language="JavaScript">
		 setTimeout( function(){$(\'#del-error\').removeClass(\'moe-a\');$(\'#del-error\').addClass(\'moe-a-off\');}, 2100 );
		 setTimeout( function(){$(\'#del-error\').attr(\'style\', \'display: none;\');}, 2300 );
		</script>';
  }
 }
}
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
    $(\'#newVer\').html(data.message);
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
   <form class="protected" action="?CastleBackup" method="post">
    <input type="submit" name="type" class="btn btn-s" value="备份模板数据" />&nbsp;&nbsp;
	<input type="submit" name="type" class="btn btn-s" value="还原模板数据" />&nbsp;&nbsp;
	<input type="submit" name="type" class="btn btn-s" value="删除备份数据" />
   </form>
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
  _t('主题语言配置文件 (如想自定义语言配置请参考文档)'));
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
	'api.ohmyga.cn' => 'api.ohmyga.cn'
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
  
  $qqheadimg = new Typecho_Widget_Helper_Form_Element_Select('qqheadimg',array(
    '0' => '默认',
	'1' => 'Base64',
	'2' => 'QQ自带加密'
  ),
  '0',
  _t('QQ头像源'),
  _t('QQ头像源(评论区)，详细参考文档'));
  $form->addInput($qqheadimg->multiMode());
  
  $post = new Typecho_Widget_Helper_Form_Element_Checkbox('post', array(
	'share' => _t('启用分享按钮'),
	'tags' => _t('启用文章标签按钮'),
	'cate' => _t('启用文章分类按钮'),
	'copy' => _t('启用文章底部版权 (如需修改内容请在语言配置文件内修改)')
  ),
  array('share', 'cate', 'copy'), _t('文章设置'));
  $form->addInput($post->multiMode());
  
  $page = new Typecho_Widget_Helper_Form_Element_Checkbox('page', array(
	'share' => _t('启用分享按钮'),
	'copy' => _t('启用文章底部版权 (如需修改内容请在语言配置文件内修改)')
  ),
  array('share', 'copy'), _t('独立页设置'));
  $form->addInput($page->multiMode());
  
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
  
  $sidebarBG = new Typecho_Widget_Helper_Form_Element_Text('sidebarBG', NULL, '', _t('侧边抽屉头图'), _t('不填将显示默认图片'));
  $form->addInput($sidebarBG);
  
  $miibeian = new Typecho_Widget_Helper_Form_Element_Text('miibeian', NULL, '', _t('备案号'), _t('输入备案号，不填写将不显示'));
  $form->addInput($miibeian);
  
  $apipass = new Typecho_Widget_Helper_Form_Element_Text('apipass', NULL, Typecho_Common::randString(32), _t('* API接口保护'), _t('加盐保护API不被滥用，自动生成无需修改（如果为空请重新启用主题 - <strong>主题设置会清空注意备份</strong>）'));
  $form->addInput($apipass);
  
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

/**
 * 既然你找到了版权在这，那么请保留。
 * 保留版权就是对作者最大的支持。
 * 在此对某些喜欢删版权的说（针对喜欢删或改版权的某些人）：留着版权会死？如果那么喜欢删那么就别用这个主题（笑）
 **/
function foinfo() {
 if (Helper::options()->miibeian){ $beian = '<a href="http://www.beian.miit.gov.cn" target="_blank">'.Helper::options()->miibeian.'</a><br>'; }else{ $beian = ''; }
 $output = 'This <span class="mdui-list-item-content"><a href="https://github.com/ohmyga233/castle-Typecho-Theme" target="_blank">Theme</a> By <a href="https://ohmyga.cn/" target="_blank">ohmyga</a></span><br>
      '.$beian.'
      Powered By <a href="http://typecho.org/" target="_blank">Typecho</a>';
 return $output;
}