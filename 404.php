<?php
/**
 * 404 Page
 * Version 0.1.5
 * Author ohmyga( https://ohmyga.cn/ )
 * 2019/04/10
 **/
if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
 if (isset($_GET['_pjax'])) {
  echo '<title>';
  $this->archiveTitle(array('category'=>_t('分类 %s 下的文章'),'search'=>_t('包含关键字 %s 的文章'),'tag'=>_t('标签 %s 下的文章'),'author'=>_t('%s 发布的文章')), '', ' - ');
  echo $this->options->title.'</title>';
  echo '<div id="moe-body">';
 } else {
  $this->need('includes/header.php');
 }
?>
  <style>footer{display:none;}header{display:none;}.mdui-appbar-with-toolbar{padding-top: 0px;}</style>
  <div class="moe-404-body">
   <div class="mdui-card moe-card-404">
    <div class="mdui-card-media moe-card-media">
	 <main class="moe-card-img" data-original="<?php echo themeResource('others/img/404.jpg'); ?>" style="background-image: url('<?php echo themeResource('others/img/loading.gif'); ?>');"></main>
	 <div class="mdui-card-media-covered">
	  <div class="mdui-card-primary">
	   <div class="mdui-card-primary-title moe-card-title moe-text-ellipsis"><?php $this->options->title(); ?></div>
      </div>
     </div>
    </div>
	
    <div class="moe-404-content">
	 <div class="moe-title"><?php echo lang('404', 'no found')?></div>
	 <div class="moe-des"><?php echo lang('404', 'try search')?></div>
	 
	 <form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
	 <div class="mdui-textfield moe-search-p">
      <input class="mdui-textfield-input" type="text" name="s" id="searchOuO" placeholder="<?php echo lang('404', 'search')?>"/>
     </div>
	 <button class="mdui-btn mdui-btn-icon mdui-color-theme-accent mdui-ripple moe-btn mdui-btn-raised"><i class="mdui-icon material-icons">search</i></button>
	 </form>
	</div>
	
	<div class="moe-404-btn">
	 <ul class="mdui-list">
      <a href="<?php $this->options->siteUrl(); ?>" class="mdui-list-item mdui-ripple">
       <i class="mdui-list-item-icon mdui-icon material-icons">home</i>
       <div class="mdui-list-item-content"><?php echo lang('404', 'home')?></div>
      </a>
	  
	  <a href="<?php $this->options->siteUrl('admin'); ?>" target="_blank" class="mdui-list-item mdui-ripple">
       <i class="mdui-list-item-icon mdui-icon material-icons">account_circle</i>
       <div class="mdui-list-item-content"><?php echo lang('404', 'login')?></div>
      </a>
     </ul>
	</div>
   </div>
  </div>
  <script>
   //$(document).attr("title","<?php echo lang('404', 'title')?>");
   var Search404URL = '<?php $this->options->siteUrl(); ?>';
  </script>
<?php
if (isset($_GET['_pjax'])) {
 echo '</div>';
} else {
 $this->need('includes/footer.php');
}
?>