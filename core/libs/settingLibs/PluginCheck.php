<?php
/**
 * Castle Plugin Check
 * Last Update: 2020/03/18
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_Plugin_Check {

 /**
  * 检查 Links 插件是否存在
  *
  * @return string  结果提示框
  */
 public function links() {
  if (Castle_Libs::hasPlugin('Links')) {
   $str = Castle_Notice::success('检测到您已经安装 Links 插件，可到「管理」→「友情链接」管理友链。');
  }else{
   $str = Castle_Notice::error('检测到您还未安装 Links 插件，请 <a class="mdui-text-color-red-500" href="https://github.com/ohmyga233/castle-Typecho-Theme/releases/download/0.9.3/Links.zip">点此下载</a> 友链插件，否则将无法正常运行友链功能。');
  }

  return $str;
 }

 /**
  * 检查 Pio 插件是否存在
  *
  * @return string  结果提示框
  */
 public function pio() {
  if (Castle_Libs::hasPlugin('Pio')) {
   $str = Castle_Notice::success('检测到您已经安装 Pio 插件，会根据设置项输出暗色样式文件');
  }else{
   $str = Castle_Notice::error('检测到您还未安装 Pio 插件，如果检测结果有误，可尝试设置为「强制输出暗色样式」');
  }

  return $str;
 }

 /**
  * 检查 APlayer 插件是否存在
  *
  * @return string  结果提示框
  */
 public function APlayer() {
  if (Castle_Libs::hasPlugin('Meting')) {
   $str = Castle_Notice::success('检测到您已经安装 APlayer For Typecho 插件，会根据设置项输出暗色样式文件');
  }elseif (Castle_Libs::hasPlugin('APlayerAtBottom')) {
   $str = Castle_Notice::success('检测到您已经安装 APlayer At Bottom 插件，会根据设置项输出暗色样式文件');
  }else{
   $str = Castle_Notice::error('检测到您还未安装 APlayer For Typecho 插件，如果检测结果有误，可尝试设置为「强制输出暗色样式」');
  }

  return $str;
 }

 /**
  * 检查 Castle 配套插件是否存在
  *
  * @return string  结果提示框
  */
 public function Castle() {
  if (Castle_Libs::hasPlugin('Castle')) {
   $str = Castle_Notice::success('检测到您已经安装 Castle 主题配套插件，插件设置请在此设置');
  }else{
   $str = Castle_Notice::error('检测到您还未安装 Castle 主题配套插件，请安装后此面板内的设置才有效');
  }

  return $str;
 }

 //检查文字统计是否存在
 public function WordCounter() {
    if (Castle_Libs::hasPlugin('WordsCounter')) {
        $str = Castle_Notice::success('检测到您已经安装 WordsCounter 插件，可以使用文章字数统计功能')
    }else{
        $str = Castle_Notice::error('检测到您还未安装 WordsCounter 插件，字数统计无法使用，侧边栏可能显示错误！')
    }
    return $str;
 }

}