<?php
/**
 * Castle Avatar Class
 * Last Update: 2020/02/12
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_Avatar {
 
 /**
  * 获取 QQ 头像链接
  *
  */
 public static function qq($num, int $size = 100, $useType = NULL) {
  //$setting = Helper::options()->qqAvatar;
  $useType = empty($useType) ? Helper::options()->qqAvatar_Type : $useType;

  if ($useType == '0') {
   $avatar = 'https://q.qlogo.cn/g?b=qq&nk='.$num.'&s='.$size;

  }elseif ($useType == '1') {
   $httpHead = extension_loaded('openssl') ? 'https' : 'http';
   $reqUrl = '://ptlogin2.qq.com/getface?&imgtype=1&uin=';
   $getUserInfo = file_get_contents($httpHead.$reqUrl.$num);
   $str1 = explode('&k=', $getUserInfo);
   $str2 = explode('&s=', $str1[1]);

   $avatar = 'https://q.qlogo.cn/g?b=qq&k='.$str2[0].'&s='.$size;

  }elseif ($useType == '2') {
   $avatar = Castle_Libs::index('?action=qqAvatar&content='.base64_encode($num).'&size='.$size);
  }

  return $avatar;
 }

 /**
  * 获取 Gravatar 头像链接
  */
 public static function gravatar($email, int $size = 100, int $useCDN = NULL) {
  $useCDN = empty($useCDN) ? Helper::options()->Gravatar_CDN : $useCDN;
  
  //MD5 EMail
  $email = md5($email);
  
  if ($useCDN == '0') {
   //Gravatar www
   $avatar = 'https://www.gravatar.com/avatar/'.$email.'?s='.$size;
  }elseif ($useCDN == '1') {
   //Gravatar secure
   $avatar = 'https://secure.gravatar.com/avatar/'.$email.'?s='.$size;
  }elseif ($useCDN == '2') {
   //Gravatar CN
   $avatar = 'https://cn.gravatar.com/avatar/'.$email.'?s='.$size;
  }elseif ($useCDN == '3') {
   //V2EX
   $avatar = 'https://cdn.v2ex.com/gravatar/'.$email.'?s='.$size;
  }elseif ($useCDN == '4') {
   //Loli.net
   $avatar = 'https://gravatar.loli.net/avatar/'.$email.'?s='.$size;
  }

  return $avatar;
 }

 /**
  * 获取评论者邮箱
  */
 public static function getCommentAvatar($email, int $size = 100) {
  //Hash
  $email_hash = md5(strtolower($email));

  //EMail
  $email = strtolower($email);

  //如果是 QQ 邮箱
  $email_qq = str_replace('@qq.com','',$email);
  if(strstr($email,"qq.com") && is_numeric($email_qq) && strlen($email_qq) < 11 && strlen($email_qq) > 4) {
   $avatar = self::qq($email_qq, $size);
  }else{
   $avatar = self::gravatar($email, $size);
  }

  return $avatar;
 }
}