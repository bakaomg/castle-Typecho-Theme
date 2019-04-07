<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
$this->need('includes/header.php');
?>
   <div class="mdui-card moe-card-page">
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
	  <!-- Share -->
	  <button class="mdui-btn mdui-btn-icon" mdui-tooltip="{content: '<?php echo lang('page', 'share'); ?>'}" mdui-menu="{target: '#share', align: 'right', position: 'top'}"><i class="mdui-icon material-icons mdui-text-color-grey-700">share</i></button>
	  <ul class="mdui-menu" id="share">
       <?php echo Pshare('page', $this); ?>
      </ul>
	 </div>
    </div>
	
	<div class="mdui-divider"></div>
	
	<div class="moe-p-c">
	 <?php echo Castle::parseAll($this->content); ?>
	</div>
	
	<div class="mdui-divider moe-c-d"></div>
   </div>
<?php $this->need('includes/comments.php'); ?>
   <div class="moe-margin-top-page">
   <script>
    var commentUrl = '<?php $this->commentUrl() ?>';
    var commentID = '<?php echo $this->respondId(); ?>';
   </script>
<?php $this->need('includes/footer.php'); ?>