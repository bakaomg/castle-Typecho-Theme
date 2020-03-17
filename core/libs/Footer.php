<?php
/**
 * Castle Footer Class
 * Last Update: 2020/03/17
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_Footer {

 /**
  * 底部输出
  */
 public static function export($footer) {
  $resourcesSetting = (Helper::options()->resources_Type) ? Helper::options()->resources_Type : 'local';
  if ($resourcesSetting == 'jsdelivr') {
   $castleJS = 'static/js/castle.min.min.js';
  }else{
   $castleJS = 'static/js/castle.min.js';
  }

  //统计代码
  echo (Helper::options()->statisticsCode) ? '<div class="mdui-hidden">'.Helper::options()->statisticsCode.'</div>'."\n " : NULL;

  //siteConfig
  echo '<script src="'.Castle_Libs::index('/?action=siteConfig', false).'"></script>'."\n  ".

  //MDUI
  '<script src="'.Castle_Libs::resources('static/js/mdui.min.js', true).'"></script>'."\n  ";

  if (Helper::options()->PJAX && in_array('PJAX_Switch', Helper::options()->PJAX)) {
   //PJAX
   echo '<script src="'.Castle_Libs::resources('static/js/pjax.min.js', true).'"></script>'."\n  ";
   
   //Nprogress
   echo '<script src="'.Castle_Libs::resources('static/js/nprogress.min.js', true).'"></script>'."\n  ";
  }

  echo
  //baguetteBox
  '<script src="'.Castle_Libs::resources('static/js/baguetteBox.min.js', true).'"></script>'."\n  ".

  //Lazyload
  '<script src="'.Castle_Libs::resources('static/js/lazyload.min.js', true).'"></script>'."\n  ".

  //HighLight
  '<script src="'.Castle_Libs::resources('static/js/highlight.min.js', true).'"></script>'."\n  ".
  
  //Tocbot
  '<script src="'.Castle_Libs::resources('static/js/tocbot.min.js', true).'"></script>'."\n  ".

  //主题核心JS
  '<script src="'.Castle_Libs::resources($castleJS, true).'"></script>'."\n";
 }
}