<?php
/**
 * 追番页
 *
 * @package custom
 */
/**
 * Castle Bangumi Page
 * Last Update: 2020/03/24
 * Author: SatoSouta
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

if (@$_SERVER['HTTP_X_PJAX'] == true) {
 header('HTTP/1.1 200 OK');
 echo '<title>'.Castle_Header::title($this, '', ' - ', true, false).'</title>';
 echo '<div id="moe-pjax-content"'.Castle_Header::cardTransparent().'>';
}else{
 $this->need('core/inc/header.php');
}
?>
   <div class="mdui-card moe-post-card moe-bangumi-card">
    <div class="mdui-card-media">
     <div class="moe-card-cover-image lazyload" data-src="<?php
       $cover = $this->fields->cover;
       if (!empty($cover)) {
        echo $cover;
       }else{
        Castle_Libs::randCover(true);
       }
      ?>" style="background-image:url('');"></div>
     <div class="mdui-card-media-covered">
      <div class="mdui-card-primary">
       <div class="mdui-card-primary-title mdui-text-truncate"><?php $this->title() ?></div>
       <div class="mdui-card-primary-subtitle"><?php echo sprintf($GLOBALS['CastleLang']['page']['view'], Castle_Contents::PostView($this)); ?> | <?php echo sprintf($GLOBALS['CastleLang']['page']['comment'], $this->commentsNum); ?></div>
      </div>
     </div>
    </div>

    <div class="moe-card-content">
<?php if (Castle_Libs::hasPlugin('Castle')): ?>
     <div class="mdui-row" id="bangumi-box"></div>
<?php else: ?>
     <div class="bangumi-plugin-disable">
      <span>配套插件未启用！</span>
     </div>
<?php endif; ?>
    </div>

   </div>

<?php $this->need('core/inc/comments.php'); ?>
<?php
if (@$_SERVER['HTTP_X_PJAX'] == true) {
 echo '</div>';
}else{
 $this->need('core/inc/footer.php');
}
?>