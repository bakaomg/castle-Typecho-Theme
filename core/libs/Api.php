<?php
/**
 * Castle API Class
 * Last Update: 2020/02/29
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_API {

 /**
  * 站点配置整合输出
  */
 public static function siteConfig() {
  Typecho_Widget::widget('Widget_User')->to($user);
  if ($user->hasLogin()) {
   $hasLogin = true;
  }else{
   $hasLogin = false;
  }

  $arr = [
   
   //Url
   'url' => [
    'site' => Helper::options()->siteUrl,             //站点链接
    'theme' => Helper::options()->themeUrl,           //主题目录链接
    'index' => Helper::options()->index,              //主页路由链接
    'login' => (new TypechoLogin())->getLoginUrl(),   //登陆链接
    'logout' => (new TypechoLogin())->getLogoutUrl()  //退出登陆链接
   ],

   //Info
   'info' => [
    'siteName' => Helper::options()->title,
    'author' => Castle_Libs::getAdminScreenName(),
    'description' => Helper::options()->description
   ],

   //Castle Version
   'CastleVersion' => CASTLE_VERSION,

   //判断
   'is' => [
    'login' => $hasLogin
   ],
   
   //功能开关
   'switch' => [
    //评论
    'comment' => [
     'link' => (Helper::options()->commentsRequireURL) ? true : false,    //评论者是否需要填写链接
     'email' => (Helper::options()->commentsRequireMail) ? true : false,  //评论者是否需要填写邮箱
     'ajax' => true                                                     //是否开启评论 AJAX 提交
    ],

    //暗色
    'dark' => [
     'default' => (Helper::options()->themeDarkColor),  //默认
     'scheme'  => (Helper::options()->themeScheme && in_array('scheme', Helper::options()->themeScheme)) ? true : false  //监听暗色
    ],
    
    //PJAX
    'pjax' => (Helper::options()->PJAX && in_array('PJAX_Switch', Helper::options()->PJAX)) ? true : false,
    
    //侧边抽屉底部工具栏
    'sidebarToolsBar' => [
     'login' => (Helper::options()->sidebarToolsBar && in_array('login', Helper::options()->sidebarToolsBar)) ? true : false,
     'settingBtn' => (Helper::options()->sidebarToolsBar && in_array('settingBtn', Helper::options()->sidebarToolsBar)) ? true : false,
     'darkBtn' => (Helper::options()->sidebarToolsBar && in_array('darkBtn', Helper::options()->sidebarToolsBar)) ? true : false
    ]
   ],

   //设置
   'setting' => [
    'background' => [
     'big'    => (Helper::options()->backgroundBig) ? Helper::options()->backgroundBig : false,     //大屏背景 >600
     'small'  => (Helper::options()->backgroundSmall) ? Helper::options()->backgroundSmall: false,  //小屏背景 <=600
     'color'  => (Helper::options()->backgroundColor) ? Helper::options()->backgroundColor : false  //背景色
    ],

    //侧栏
    'sidebar' => [
     'background' => (Helper::options()->sidebarBG) ? Helper::options()->sidebarBG : Castle_Libs::resources('static/img/sidebar.jpg')
    ],

    //登录框
    'login' => [
     'background'      => (Helper::options()->loginBG) ? Helper::options()->loginBG : false,      //登录框背景图
     'backgroundColor' => (Helper::options()->loginColor) ? Helper::options()->loginColor : false //登录框背景色
    ],

    //头像
    'avatar' => (Helper::options()->siteAvatar) ? Helper::options()->siteAvatar : Castle_Libs::resources('static/img/avatar.jpg'),

    //侧栏菜单
    'sidebarMenu' => (Castle_Sidebar::getMenuList()) ? Castle_Sidebar::getMenuList() : false,
    
    //表情
    'owoList' => (Castle_OwO::getOwOList()) ? Castle_OwO::getOwOList() : false,

    //备案号
    'miibeian' => (Helper::options()->miibeian) ? Helper::options()->miibeian : false   //备案号
   ]
  ];

  $output = "var CastleConfig =".json_encode($arr).";";

  $PJAX = (Helper::options()->PJAX && in_array('PJAX_Switch', Helper::options()->PJAX)) ? true : false;
  if ($PJAX === true) {
   $timeout = (Helper::options()->PJAX_TimeOut) ? Helper::options()->PJAX_TimeOut : 10000;
   $output .= "\n".
   'var PjaxConfig = {timeout: '.$timeout.', before: function() {}, after: function() {'.Helper::options()->PJAX_Reload.'} };';
  }

  /* 语言 */
  $lang = [
   'sidebar' => $GLOBALS['CastleLang']['sidebar'],
   'index' => [
    'FloatingTitle' => $GLOBALS['CastleLang']['index']['FloatTitle']
   ],
   'tips' => $GLOBALS['CastleLang']['tips'],
   'search' => $GLOBALS['CastleLang']['search'],
   'post' => [
    'hidden' => $GLOBALS['CastleLang']['post']['hidden'],
    'delete' => $GLOBALS['CastleLang']['post']['delete']
   ],
   'page' => [
    'delete' => $GLOBALS['CastleLang']['page']['delete']
   ],
   'comment' => $GLOBALS['CastleLang']['api']['comment'],
   'pjax' => $GLOBALS['CastleLang']['pjax']
  ];

  $output .= "\n".'var CastleLang ='.json_encode($lang);

  //设置Header
  header('Content-type: text/javascript');
  echo $output;
 }
}