<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$ThemeColor = Typecho_Widget::widget('Widget_Options')->themecolor;
$AccentColor = Typecho_Widget::widget('Widget_Options')->accentcolor;
if($this->options->cardt == '0'){
 $cardtr = '';
}elseif($this->options->cardt == '10'){
 $cardtr = 'moe-card-tr-10';
}elseif($this->options->cardt == '20'){
 $cardtr = 'moe-card-tr-20';
}elseif($this->options->cardt == '30'){
 $cardtr = 'moe-card-tr-30';
}
tcs();
?>
<html>
 <head>
  <meta charset="utf-8">
  <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?></title>
  <script src="<?php echo themeResource('others/js/mdui.min.js'); ?>"></script>
  <script src="<?php echo themeResource('others/js/nprogress.min.js'); ?>"></script>
  <script src="<?php echo themeResource('others/js/jquery3.3.1.min.js'); ?>"></script>
  <?php if ($this->options->other && in_array('pjax', $this->options->other)): ?><script src="<?php echo themeResource('others/js/jquery.pjax.min.js'); ?>"></script><?php endif; ?>
  <link rel="stylesheet" href="<?php echo themeResource('others/css/iconfont.min.css'); ?>" />
  <link rel="stylesheet" href="<?php echo themeResource('others/css/mdui.min.css'); ?>" />
  <link rel="stylesheet" href="<?php echo themeResource('others/css/nprogress.min.css'); ?>" />
  <link rel="stylesheet" href="<?php echo themeResource('others/css/castle.min.css'); ?>" />
  <link rel="stylesheet" href="<?php echo themeResource('others/css/fancybox.min.css'); ?>" />
  <link rel="icon" type="image/x-icon" href="<?php echo siteHeadimg('ico'); ?>" id="Icon-title">
  <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
<?php Castle::exportHead($this); ?>
<?php $this->need('includes/style.php')?>
  <?php $this->header('generator=&pingback=&xmlrpc=&wlw=&commentReply=&description='); ?>
  <script>var bgmURL = "<?php $this->options->siteUrl(); ?>?action=bangumi&bgmID=:id&auth=:auth";</script>
 </head>
 
 <body class="mdui-theme-primary-<?php echo $ThemeColor; ?> mdui-theme-accent-<?php echo $AccentColor; ?> mdui-appbar-with-toolbar">
 <div class="moe-bg" style="background-color: #EEEEEE;"></div>
 <div class="moe-bg-after"></div>
  <header class="mdui-appbar mdui-appbar-fixed moe-head">
   <div class="mdui-toolbar">
    <a class="mdui-btn mdui-btn-icon" mdui-drawer="{target: '#sidebar', swipe: 'true', overlay: 'true'}"><i class="mdui-icon material-icons">menu</i></a>
    <a href="<?php $this->options->siteUrl(); ?>" class="mdui-typo-title"><?php $this->options->title(); ?></a>
    <div class="mdui-toolbar-spacer"></div>
    <a class="mdui-btn mdui-btn-icon" mdui-dialog="{target: '#search-dialog'}"><i class="mdui-icon material-icons">search</i></a>
   </div>
  </header>
  
  <div class="mdui-dialog moe-search-dialog" id="search-dialog">
   <div class="moe-bg" style="background: url('<?php echo themeResource('others/img/search.png'); ?>');"></div>
   <a class="mdui-btn mdui-btn-icon moe-search-btn" mdui-dialog-close><i class="mdui-icon material-icons">close</i></a>
   <div class="moe-body">
    <div class="moe-c">
	 <form id="searchBox" onKeyDown="if(event.keyCode == 13){SerachSubmit();}">
      <i class="mdui-icon material-icons moe-search-icon">search</i>
      <input class="moe-search-input" placeholder="<?php echo lang('head', 'searchInput'); ?>" type="text" id="searchInput"/>
	 </form>
	</div>
	<span class="moe-bottom"></span>
   </div>
  </div>
  
<?php $this->need('includes/sidebar.php'); ?>
  
  <?php if ($this->options->comment && in_array('ajax', $this->options->comment)): ?><input id="linkStatus" type="hidden" value="false"/><?php endif; ?>
  <div id="moe-body" class="<?php echo $cardtr; ?>">