<?php
/**
 * 友链页
 *
 * @package custom
 */
/**
 * 友情链接页
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
 }else{
   $this->need('includes/header.php');
 }
?>
   <!-- 本页被浏览 <?php echo PostView($this) ?> 次 -->
   <div class="moe-links-box moe-card-a"> 
    <div class="mdui-row-sm-2 mdui-row-md-4">
	 <div class="mdui-col">
      <a onclick="<?php if ($this->options->comment && in_array('ajax', $this->options->comment)){ echo 'openLinks()'; }else{ echo 'openLinksAN()'; }?>" style="cursor:pointer;">
       <div class="mdui-card moe-links-card mdui-hoverable">
        <div class="mdui-card-media" style="overflow: hidden;">
	     <main class="moe-links-bg" data-original="<?php echo siteHeadimg('ico'); ?>" style="background-image: url('<?php echo themeResource('others/img/loading.gif'); ?>');"></main>
        </div>
	    <div class="mdui-card-actions mdui-text-center">
	     <img src="<?php echo themeResource('others/img/loading.gif'); ?>" data-original="<?php echo siteHeadimg('ico'); ?>" class="moe-links-headimg"/>
	     <br>
	     <span class="moe-links-title"><?php echo lang('links', 'Slink'); ?></span>
	     <div style="margin-top: 8px;"></div>
	     <span class="moe-links-d" id="moe-links-des"><?php echo lang('links', 'clickThis'); ?></span>
        </div>
       </div>
      </a>
     </div>
     <?php Links_Plugin::output('<div class="mdui-col">
      <a href="{url}" title="{title}" target="_blank">
       <div class="mdui-card moe-links-card mdui-hoverable">
        <div class="mdui-card-media" style="overflow: hidden;">
	     <main class="moe-links-bg" data-original="{image}" style="background-image: url(\''.themeResource('others/img/loading.gif').'\');"></main>
        </div>
	    <div class="mdui-card-actions mdui-text-center">
	     <img src="'.themeResource('others/img/loading.gif').'" data-original="{image}" class="moe-links-headimg"/>
	     <br>
	     <span class="moe-links-title">{name}</span>
	     <div style="margin-top: 8px;"></div>
	     <span class="moe-links-d" id="moe-links-des">{description}</span>
        </div>
       </div>
      </a>
     </div>'); ?>
    </div>
   </div>

   <div class="moe-links-comment-dialog" id="moe-s-links">
    <div class="moe-links-main mdui-shadow-10">
	<div id="link-top"></div>
     <div class="mdui-card-media moe-card-media">
	  <button class="mdui-btn mdui-btn-icon moe-links-close mdui-shadow-5" onclick="<?php if ($this->options->comment && in_array('ajax', $this->options->comment)){ echo 'closeLinks()'; }else{ echo 'closeLinksAN()'; }?>"><i class="mdui-icon material-icons">close</i></button>
	  <main class="moe-card-img" data-original="<?php $wzimg = $this->fields->wzimg;
	  if(!empty($wzimg)){
       echo $this->fields->wzimg;
	  }else{
	   echo randPic();
	  }?>" style="background-image: url('<?php echo themeResource('others/img/loading.gif'); ?>');"></main>
	  <div class="mdui-card-media-covered">
	   <div class="mdui-card-primary">
	    <div class="mdui-card-primary-title moe-card-title moe-text-ellipsis"><?php echo lang('links', 'Slink'); ?></div>
       </div>
	  </div>
	 </div>
	 
	 <div class="moe-p-c">
	  <?php echo Castle::parseAll($this->content); ?>
	 </div>
	 
	 <div class="mdui-divider"></div>
	 <?php $this->need('includes/comments-links.php'); ?>
	 <button class="mdui-fab mdui-fab-mini mdui-ripple mdui-color-theme moe-links-go-top" onclick="document.getElementsByClassName('moe-links-main')[0].scroll({ top: 0, left: 0, behavior: 'smooth' });"><i class="mdui-icon material-icons">arrow_upward</i></button>
	</div>
   </div>
   <?php if($this->allow('comment')){$this->need("includes/owo.php");}else{} ?>
   <script>
    var commentUrl = '<?php $this->commentUrl() ?>';
    var commentID = '<?php echo $this->respondId(); ?>';
	<?php if ($this->options->comment && in_array('ajax', $this->options->comment)): ?><?php else: ?>function getCookie(cname){
     var name = cname + "=";
     var ca = document.cookie.split(';');
     for(var i=0; i<ca.length; i++) {
      var c = ca[i].trim();
      if (c.indexOf(name)==0) return c.substring(name.length,c.length);
     }
     return false;
    }
	
    if(getCookie('links')){
     $('#moe-s-links').attr('style', 'display: block;');
     $('#moe-s-links').addClass('moe-links-comment-open-pjax');
    }<?php endif; ?>
   </script>
<?php 
if (isset($_GET['_pjax'])) {
 echo '</div>';
} else {
 $this->need('includes/footer.php');
}
?>