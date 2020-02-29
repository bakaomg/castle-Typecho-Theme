<?php
/**
 * Castle Theme Config
 * Last Update: 2020/02/14
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

//引用设置组件
Castle_Libs::requireFile(__DIR__ .'/settingLibs/', 'php');

function themeConfig($form) {
 themeBackup();
 $Component = new Castle_Component($form);
 /* 信息面板 */
 echo $Component->themePanel();
 $Component->main(
  /* 置顶文章 */
  $Component->card(NULL, NULL,
   $Component->input('StickyArticle', '置顶文章', '置顶的文章cid，按照排序输入, 请以半角逗号或空格分隔。')
  ).

  /* 主题外观 */
  $Component->panel('主题外观', NULL,
   $Component->panel('站点头像', NULL,
    $Component->input('siteAvatar', '站点头像', '填入头像链接，不填显示默认头像（有效范围：侧栏头像、状态栏图标）。', NULL)
   ).
   
   $Component->panel('主题配色', NULL,
    $Component->panel('主题色', NULL,
     $Component->radio("themeColor", "主题主色", '主题主色',
      ['red'          => 'Red',
       'pink'         => 'Pink',
       'purple'       => 'Purple',
       'deep-purple'  => 'Deep Purple',
       'indigo'       => 'Indigo',
       'blue'         => 'Blue',
       'light-blue'   => 'Light Blue',
       'cyan'         => 'Cyan',
       'teal'         => 'Teal',
       'green'        => 'Green',
       'light-green'  => 'Light Green',
       'lime'         => 'Lime',
       'yellow'       => 'Yellow',
       'amber'        => 'Amber',
       'orange'       => 'Orange',
       'deep-orange'  => 'Deep Orange',
       'brown'        => 'Brown',
       'grey'         => 'Grey',
       'blue-grey'    => 'Blue Grey'
      ],
     'pink')
    ).

    $Component->panel('主题强调色', NULL,
     $Component->radio("themeAccentColor", "主题强调色", '主题强调色(如超链接颜色等)',
      ['red'         => 'Red',
       'pink'        => 'Pink',
       'purple'      => 'Purple',
       'deep-purple' => 'Deep Purple',
       'indigo'      => 'Indigo',
       'blue'        => 'Blue',
       'light-blue'  => 'Light Blue',
       'cyan'        => 'Cyan',
       'teal'        => 'Teal',
       'green'       => 'Green',
       'light-green' => 'Light Green',
       'lime'        => 'Lime',
       'yellow'      => 'Yellow',
       'amber'       => 'Amber',
       'orange'      => 'Orange',
       'deep-orange' => 'Deep Orange'
      ],
     'pink')
    ).

    $Component->panel('主题默认色', NULL,
     $Component->radio("themeDarkColor", "主题默认色", '主题默认色',
      ['light'  => '亮色(默认)',
       'dark'   => '暗色(夜间)'
      ],
     'light').

     $Component->checkbox('themeScheme', '跟随系统切换默认色', NULL,
      ['scheme' =>  '跟随系统切换默认色'
      ],
      NULL
     ).
     '<br/>※ 如果开启跟随系统配色切换，默认色的优先级将会低于跟随，但用户设置优先级永远最高。'
    ).

    $Component->panel('卡片透明度', NULL,
     $Component->radio("cardTransparent", "卡片透明度", '卡片透明度',
      [0   => '不透明',
       1   => '10%',
       2   => '20%',
       3   => '30%'
      ],
     0).
     '<br><small>※ 为了保证可阅读性，最高只能透明 30% ，如需透明建议只开 10% 。</small>'
    )
   ).

   $Component->panel('背景设置', NULL,
    $Component->input('backgroundColor', '背景色', '填入十六进制颜色，留空默认浅灰。', NULL).
    $Component->input('backgroundBig', '宽屏背景', '当屏幕宽度 >600 px 时显示的背景，留空显示浅灰或上面设置的背景色。', NULL).
    $Component->input('backgroundSmall', '小屏背景', '当屏幕宽度 <=600 px 时显示的背景，留空显示宽屏背景（如有设置）或上面设置的背景色。', NULL)
   ).

   $Component->panel('Android Chrome 地址栏颜色', NULL, $Component->input('ChromeThemeColor', 'Android Chrome 地址栏颜色', '填入十六进制颜色，留空则不设置。', '#424242')).

   $Component->panel('侧边抽屉', NULL,
    $Component->input('sidebarBG', '侧边抽屉头图', '留空则显示默认图片。', NULL)
   ).

   $Component->panel('前台登录', NULL,
    $Component->input('loginColor', '前台登录背景色', '十六进制颜色，留空默认白色。', '#424242').
    $Component->input('loginBG', '前台登录背景图', '留空显示背景色。', NULL)
   ).

   $Component->panel('404 页面', NULL,
    $Component->input('Cover404', '404 页面卡片封面', '留空显示默认封面。', NULL)
   )
  ).

  /*  功能设置 */
  $Component->panel('功能设置', NULL, 
   $Component->panel('语言设置', NULL,
    $Component->radio("Language", NULL, NULL,
     Castle_Lang::getList(),
     Helper::options()->themeFile(Castle_Libs::getTheme(), "core/lang/zh-CN.json")
    )
   ).
   
   $Component->panel('功能开关', NULL,
    $Component->checkbox('switch', '功能开关', NULL,
     ['baguetteBox' =>  '图片灯箱',
      'target'      =>  '站外链接新标签页打开',
      'html'        =>  'HTML 压缩（代码来自 <a href="https://www.linpx.com/p/pinghsu-subject-integration-code-compression.html">LiNPX</a> ，可能有部分插件不兼容）'
     ],
     ['baguetteBox', 'target']
    )
   ).

   $Component->panel('侧边抽屉', NULL,
    $Component->panel('抽屉菜单', NULL,
     $Component->textarea('sidebarMenu', '侧边抽屉菜单', '侧边抽屉内容设置，写法参考文档。', file_get_contents(__DIR__ .'/settingLibs/menu.json'), 10)
    ).

    $Component->panel('侧边抽屉工具栏', NULL,
     $Component->checkbox('sidebarToolsBar', '功能开关', NULL,
      ['login'       =>  '前台登录(没写完，勾选了也是摆设.jpg)',
       'settingBtn'  =>  '设置面板',
       'darkBtn'     =>  '亮色(白天)/暗色(夜间)切换按钮'
      ],
      ['login', 'settingBtn', 'darkBtn']
     )
    )
   ).

   $Component->panel('独立页面', NULL,
    $Component->panel('友链页面', NULL,
     $Component->checkbox('pageLinks', NULL, NULL,
      ['rand'  =>  '友链随机排序'],
      ['rand']
     )
    )
   ).

   $Component->panel('评论设置', NULL,
    $Component->checkbox('commentSwitch', '评论开关', NULL,
     ['ajaxSubmit'     =>   'AJAX 提交评论',
      'displayLinkBtn' =>   '默认显示链接填写框'
     ],
     ['ajaxSubmit']
    ).

    $Component->input('commentTips', '评论提示', '显示在评论框的一句话。', '与本文无关评论请发留言板。请不要水评论，谢谢。')
   ).

   $Component->panel('统计代码', NULL,
    $Component->textarea('statisticsCode', '统计代码', '统计代码，需填 '.htmlspecialchars('<script></script>').'标签。', NULL)
   ).

   $Component->panel('PJAX 设置', NULL,
    $Component->checkbox('PJAX', '功能开关', NULL,
     ['PJAX_Switch' =>  'PJAX 无刷新加载'],
     ['PJAX_Switch']
    ).
    
    $Component->input('PJAX_TimeOut', 'PJAX 超时时间', '单位 [ms] 默认 10000ms(10s) 。', 10000).
    $Component->textarea('PJAX_Reload', 'PJAX 重载函数', '重载 PJAX 刷新后失效的 Js，不需要填 '.htmlspecialchars('<script></script>').'标签。', NULL)
   ).

   $Component->panel('静态资源(CDN)', NULL,
    $Component->select('resources_Type', '静态资源', NULL,
     ['local'    =>   '本地',
      'jsdelivr' =>   'Jsdelivr',
      'cdn'      =>   '第三方 CDN'
     ],
     'local'
    ).

    $Component->input('CDNLink', 'CDN', '<br/>当静态资源选择为「第三方 CDN」时此设置有效。<br/>创建一个文件夹，把 <b>static</b> 文件夹放进去，上传到到你的 CDN 储存空间根目录下<br/>
    填入你的 CDN 地址, 如 <b>https://cdn.example.com/CastleStatic</b> 或 <b>https://root.example.com</b>
    <br/><b>※ 链接末尾不需要加 / </b>', NULL, true)
   ).

   $Component->panel('封面图源', NULL,
    $Component->select('coverType', '封面图源', NULL,
     ['oapi'         =>  'O\'s API(api.ohmyga.cn)',
      'local'        =>  '本地图源',
      'external'     =>  '第三方 API',
      'externalRand' =>  '第三方 API（附加随机参数）'
     ],
     'oapi'
    ).
    $Component->input('coverExternal', '第三方 API', '当图源选择为「第三方 API（附加随机参数）」时此设置有效。', NULL).
    $Component->input('loaclCoverFormat', '本地图源支持的格式', '<br/>本地图源支持的图片格式。<br/>输入多个格式时请用分隔符 & 进行分割（例如 jpg&png&webp）<br/>不填默认仅[.jpg/.png]格式的图片会识别到。当图源选择为「本地」时此设置有效。', 'jpg&jpeg&png&webp&bmp', true)
   ).

   $Component->panel('头像设置', NULL,
    $Component->panel('QQ', NULL,
     $Component->radio("qqAvatar_Type", "QQ 头像源", 'QQ 头像源(评论区)',
      [0 => "默认",
       1 => 'QQ 自带加密(有可能拖慢服务器响应速度 不推荐使用)'],
     0)
    ).
    $Component->panel('Gravatar', NULL,
     $Component->radio("Gravatar_CDN", "Gravatar 源", 'Gravatar 头像源',
      [0 => "Gravatar www",
       1 => 'Gravatar secure',
       2 => 'Gravatar CN',
       3 => 'V2EX'
      ],
     0)
    )
   ).

   $Component->panel('页脚设置', NULL,
    $Component->input('miibeian', '备案号', '如果不填备案号将不会显示在页脚。', NULL)
   ).

   $Component->panel('高级设置', NULL,
    $Component->textarea('CastleSettings', '高级设置', '<!-- 主题根目录下有一份 demo 照着改吧。 -->这个暂时无用。', NULL)
   )

  ).

  /* 后台设置 */
  $Component->panel('主题设置界面', NULL,
   $Component->textarea('themeConfigBG', '后台设置页面背景', '不填将使用默认背景', NULL)
  )
 );
}

function themeBackup() {
 $db = Typecho_Db::get();
  $sjdq=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.Castle_Libs::getTheme().''));
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
    $update = $db->update('table.options')->rows(array('value'=>$bsj))->where('name = ?', 'theme:'.Castle_Libs::getTheme().'');
    $updateRows= $db->query($update);
    echo '<div class="message popup success moe-a" style="position: absolute; top: 36px; display: block;">检测到模板备份数据，恢复完成，请等待自动刷新！如果等不到请点击 <a href="'.Helper::options()->adminUrl.'options-theme.php">这里</a></div>
          <script language="JavaScript">window.setTimeout("location=\''.Helper::options()->adminUrl.'options-theme.php\'", 2000);</script>';
   }else{
    echo '<div class="message popup error moe-a" style="position: absolute; top: 36px; display: block;" id="del-error">恢复失败，因为你没备份过设置哇（；´д｀）ゞ</div>
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
   echo '<div class="message popup error moe-a" style="position: absolute; top: 36px; display: block;" id="del-error">删除失败，检测不到备份ㄟ( ▔, ▔ )ㄏ</div>
        <script language="JavaScript">
		 setTimeout( function(){$(\'#del-error\').removeClass(\'moe-a\');$(\'#del-error\').addClass(\'moe-a-off\');}, 2100 );
		 setTimeout( function(){$(\'#del-error\').attr(\'style\', \'display: none;\');}, 2300 );
		</script>';
  }
 }
}
}