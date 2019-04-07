<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
$this->need('includes/header.php');
?>
   <div class="mdui-card moe-card-post">
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
       <div class="mdui-card-primary-subtitle"><?php echo sprintf(lang('post', 'view'), PostView($this)); ?> | <?php echo sprintf(lang('post', 'comment'), $this->commentsNum); ?></div>
      </div>
     </div>
    </div>
	
	<div class="mdui-card-header">
     <img class="mdui-card-header-avatar moe-headimg-xz" data-original="<?php echo siteHeadimg('pauthor', $this); ?>" src="<?php echo themeResource('others/img/loading.gif'); ?>">
     <div class="mdui-card-header-title"><?php $this->author(); ?></div>
     <div class="mdui-card-header-subtitle"><?php $this->date(lang('post', 'time')); ?></div>
     <div class="mdui-card-menu">
	  <!-- Tags -->
	  <button class="mdui-btn mdui-btn-icon" mdui-tooltip="{content: '<?php echo lang('post', 'tag'); ?>'}" mdui-menu="{target: '#tag', align: 'right', position: 'top'}"><i class="mdui-icon material-icons mdui-text-color-grey-700">local_offer</i></button>
      <ul class="mdui-menu" id="tag">
	   <?php array_map(function($v){echo '<li class="mdui-menu-item"><a href="'.$v['permalink'].' "class="mdui-ripple"><strong>'.$v['name'].'</strong></a></li>';},$this->tags) ?>
	  </ul>
	  
	  <!-- Categories -->
	  <button class="mdui-btn mdui-btn-icon" mdui-tooltip="{content: '<?php echo lang('post', 'categories'); ?>'}" mdui-menu="{target: '#classification', align: 'right', position: 'top'}"><i class="mdui-icon material-icons mdui-text-color-grey-700">bookmark</i></button>
	  <ul class="mdui-menu" id="classification">
	   <?php array_map(function($v){echo '<li class="mdui-menu-item"><a href="'.$v['permalink'].' "class="mdui-ripple"><strong>'.$v['name'].'</strong></a></li>';},$this->categories) ?>
	  </ul>
	  
	  <!-- Share -->
	  <button class="mdui-btn mdui-btn-icon" mdui-tooltip="{content: '<?php echo lang('post', 'share'); ?>'}" mdui-menu="{target: '#share', align: 'right', position: 'top'}"><i class="mdui-icon material-icons mdui-text-color-grey-700">share</i></button>
	  <ul class="mdui-menu" id="share">
       <?php echo Pshare('post', $this); ?>
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
   <div class="moe-nav">
   <div class="mdui-divider moe-c-d"></div>
    <div class="mdui-container">
     <div class="mdui-row">
      <?php thePrev($this,'<div class="mdui-ripple mdui-col-xs-2 mdui-col-sm-6 moe-nav-left">
       <div class="moe-nav-text">
        <i class="mdui-icon material-icons">arrow_back</i>
        <span class="moe-nav-direction mdui-hidden-xs-down">'.lang('post', 'prev').'</span>
        <div class="moe-nav-chapter mdui-hidden-xs-down">'.lang('post', 'prevNo').'</div>
       </div>
      </div>'); ?>
      <?php theNext($this,'<div class="mdui-ripple mdui-col-xs-10 mdui-col-sm-6 moe-nav-right">
       <div class="moe-nav-text">
        <i class="mdui-icon material-icons">arrow_forward</i>
        <span class="moe-nav-direction">'.lang('post', 'next').'</span>
        <div class="moe-nav-chapter">'.lang('post', 'nextNo').'</div>
       </div>
      </div>'); ?>
     </div>
    </div>
   </div>
   <script>
    var commentUrl = '<?php $this->commentUrl() ?>';
    var commentID = '<?php echo $this->respondId(); ?>';
   </script>
<?php $this->need('includes/footer.php'); ?>