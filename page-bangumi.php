<?php
/**
 * 追番页
 *
 * @package custom
 */
/**
 * 追番页
 * Version 0.2.5
 * Author ohmyga( https://ohmyga.cn/ )
 * 2019/04/20
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
 if(Helper::options()->apipass) {
  $bgmKey = Helper::options()->apipass;
 }else{
  $bgmKey = 'babff6a3d9521693097debb2f0063a2f';
 }
 $userID = $this->fields->bgmid;
 if(!empty($userID)){
  $uid = $this->fields->bgmid;
  $utext = '';
 }else{
  $uid = '9999999999999';
  $utext = '<span class="moe-bgm-error moe-card-a">未填写Bangumi ID</span>';
 }
?>
   <div class="moe-bgm-card mdui-card">
    <div class="mdui-card-media moe-card-media">
	 <main class="moe-card-img" data-original="<?php $wzimg = $this->fields->wzimg;
	 if(!empty($wzimg)){
      echo $this->fields->wzimg;
	 }else{
	  echo randPic();
	 }?>" style="background-image: url('<?php echo themeResource('others/img/loading.gif'); ?>');"></main>
	 <div class="mdui-card-media-covered">
	  <div class="mdui-card-primary-title moe-card-title moe-text-ellipsis"><?php $this->title() ?><br><span><?php echo sprintf(lang('page', 'view'), PostView($this)); ?> | <a href="<?php $this->permalink(); ?>#<?php $this->respondId(); ?>"><?php echo sprintf(lang('page', 'comment'), $this->commentsNum); ?></a><span></div>
     </div>
    </div>
	
    <div class="moe-bgmBox">
	 <div class="mdui-row-sm-2 mdui-row-md-2">
	 <center><div class="mdui-progress" id="bgmLoad"><div class="mdui-progress-indeterminate"></div></div></center>
	 <div id="bgmBox" data-id="<?php echo $uid; ?>" data-key="<?php echo $bgmKey; ?>">
	 </div><?php echo $utext; ?>
	 </div>
    </div>
	<div class="mdui-divider"></div>
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