<?php
/**
 * Castle Login Class
 * Last Update: 2020/01/26
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

//照搬 te 的登陆部分(大概)
class TypechoLogin extends Widget_Abstract_Users {

 public function __construct() {
  Typecho_Widget::widget('Widget_Init');
  Typecho_Widget::widget('Widget_Options')->to($options);
  Widget_Abstract::__construct($options->request, $options->response);
 }

 public function getLoginUrl() {
  $path = Castle_Libs::index('?action=login&');
  return $this->security->getTokenUrl($path);
 }

 public function getLogoutUrl() {
  $path = Castle_Libs::index('?action=logout&');
  return $this->security->getTokenUrl($path);
 }

 /**
  * 登录组件
  * 照搬 Typecho 的登录组件（去除了安全验证模块（如果有顾虑请到主题设置关闭前台登录））
  */
 public function Login() {
  $username = $this->request->name;
  $password = $this->request->password;
  //如果已经登陆
  if ($this->user->hasLogin()) {
   return [
    'status' => 'ok',
    'hasLogin' => true
   ];
  }

  /** 初始化验证类 */
  $validator = new Typecho_Validate();
  $validator->addRule('name', 'required', _t($GLOBALS['CastleLang']['api']['login']['user']));
  $validator->addRule('password', 'required', _t($GLOBALS['CastleLang']['api']['login']['passwd']));

  /** 截获验证异常 */
  if ($error = $validator->run($this->request->from('name', 'password'))) {
   Typecho_Cookie::set('__typecho_remember_name', $username);
   if(@$error['name'] && @$error['password']) {
    $errors = $error['name'].'<br>'.$error['password'];
   }elseif (@$error['name'] && @!$error['password']) {
    $errors = $error['name'];
   }elseif(@!$error['name'] && @$error['password']) {
    $errors = $error['password'];
   }

   /** 设置提示信息 */
   return [
    'status' => 'error',
    'hasLogin' => false,
    'error' => $errors
   ];
  }

  /** 开始验证用户 **/
  $valid = $this->user->login($username, $password,
  false, 1 == $this->request->remember ? $this->options->time + $this->options->timezone + 30*24*3600 : 0);
  
  /** 比对密码 */
  if (!$valid) {
   /** 防止穷举,休眠3秒 */
   sleep(3);

   $this->pluginHandle()->loginFail($this->user, $username,
   $password, 1 == $this->request->remember);
   Typecho_Cookie::set('__typecho_remember_name', $username);

   return [
    'status' => 'error',
    'hasLogin' => false,
    'error' => $GLOBALS['CastleLang']['api']['login']['wrong']
   ];
  }

  $this->pluginHandle()->loginSucceed($this->user, $username,
  $password, 1 == $this->request->remember);

  /* 验证成功后返回信息 */
  return [
   'status' => 'ok',
   'hasLogin' => true,
   'loginStatus' => true
  ];
 }

 /**
  * 退出登录
  * 同上去掉了安全验证模块
  */
 public function Logout() {
  
  if (!$this->user->hasLogin()) {
   return [
    'status' => 'error',
    'logout' => false,
    'msg' => $GLOBALS['CastleLang']['api']['login']['noLogin']
   ];
  }
  
  $this->user->logout();
  $this->pluginHandle()->logout();
  
  @session_destroy();
  return [
   'status' => 'ok',
   'logout' => true
  ];
 }
}