<?php
/**
 * Page
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
   <div class="mdui-card moe-card-page moe-card-tr">
    <div class="mdui-card-media moe-card-media">
	 <main class="moe-card-img" data-original="<?php $wzimg = $this->fields->wzimg;
	 if(!empty($wzimg)){
      echo $this->fields->wzimg;
	 }else{
	  echo randPic();
	 }?>" style="background-image: url('<?php echo themeResource('others/img/loading.gif'); ?>');"></main>
	 <div class="mdui-card-media-covered">
	  <div class="mdui-card-primary">
	   <div class="mdui-card-primary-title moe-card-title moe-text-ellipsis"><?php $this->title() ?></div>
       <div class="mdui-card-primary-subtitle"><?php echo sprintf(lang('page', 'view'), PostView($this)); ?> | <?php echo sprintf(lang('page', 'comment'), $this->commentsNum); ?></div>
      </div>
     </div>
    </div>
	
	<div class="mdui-card-header">
     <img class="mdui-card-header-avatar moe-headimg-xz" data-original="<?php echo siteHeadimg('pauthor', $this); ?>" src="<?php echo themeResource('others/img/loading.gif'); ?>">
     <div class="mdui-card-header-title"><?php $this->author(); ?></div>
     <div class="mdui-card-header-subtitle"><?php $this->date(lang('page', 'time')); ?></div>
     <div class="mdui-card-menu"> 
<?php if ($this->options->page && in_array('share', $this->options->page)): ?>	  <!-- Share -->
	  <button class="mdui-btn mdui-btn-icon" mdui-tooltip="{content: '<?php echo lang('page', 'share'); ?>'}" mdui-menu="{target: '#share', align: 'right', position: 'top'}"><i class="mdui-icon material-icons mdui-text-color-grey-700">share</i></button>
	  <ul class="mdui-menu" id="share">
       <?php echo Pshare('page', $this); ?>
      </ul><?php endif; ?>
	 </div>
    </div>
	
	<div class="mdui-divider"></div>
	
	<div class="moe-p-c">
	 <?php echo Castle::parseAll($this->content); ?>
<?php if ($this->options->page && in_array('copy', $this->options->page)): ?>	 <div class="moe-blockquote-top"></div>
	 <blockquote class="moe-blockquote-copy">
	  本文作者: <?php $this->author(); ?><br>
	  本文链接: <a href="<?php $this->permalink(); ?>"><?php $this->permalink(); ?></a><br>
	  最后修改时间: <?php echo date('Y-m-d H:i:s', $this->modified);?><br>
	  本站未注明转载的文章均为原创，并采用 <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.zh" target="_blank">CC BY-NC-SA 4.0</a> 授权协议，转载请注明来源，谢谢！<br>
	 </blockquote><?php endif; ?>
	</div>
	
	<div class="mdui-divider moe-c-d"></div>
   </div>
<?php $this->need('includes/comments.php'); ?>
   <div class="moe-margin-top-page"></div>
   <script>
    var commentUrl = '<?php $this->commentUrl() ?>';
    var commentID = '<?php echo $this->respondId(); ?>';
   </script>
<?php
if (isset($_GET['_pjax'])) {
 echo '</div>';
} else {
 $this->need('includes/footer.php');
}
?>