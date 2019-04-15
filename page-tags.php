<?php
/**
 * 标签云
 *
 * @package custom
 */
/**
 * Tag标签页
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
 $this->widget('Widget_Metas_Tag_Cloud', 'sort=mid&ignoreZeroCount=1&desc=0&limit=30')->to($tags);
 $tagNum = 0;
 while($tags->next()){$tagNum++;}
?>
  <!-- 本页被浏览 <?php echo PostView($this) ?> 次 -->
   <div class="moe-tag-card mdui-card moe-card-tr">
    <div class="moe-tag-title"><?php echo lang('tags', 'title'); ?></div>
	<div class="moe-tag-num"><?php echo sprintf(lang('tags', 'tagAllNum'), $tagNum); ?></div>
	<div class="mdui-divider moe-tag-d"></div>
	<div id="moe-all-tags">
	 <?php while ($tags->next()): ?>
	 <a class="moe-tag-a <?php echo randColor(); ?>" href="<?php $tags->permalink(); ?>" style="font-size: <?php echo fTag('f', $tags); ?>px;"><?php $tags->name(); ?></a>
	 <?php endwhile; ?>
	</div>
   </div>
<?php 
if (isset($_GET['_pjax'])) {
 echo '</div>';
} else {
 $this->need('includes/footer.php');
}
?>