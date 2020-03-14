<?php
/**
 * 友链页
 *
 * @package custom
 */
/**
 * Castle Links
 * Last Update: 2020/03/14
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (@$_SERVER['HTTP_X_PJAX'] == true) {
 header('HTTP/1.1 200 OK');
 echo '<title>'.Castle_Header::title($this, '', ' - ', true, false).'</title>';
 echo '<div id="moe-pjax-content"'.Castle_Header::cardTransparent().'>';
}else{
 $this->need('core/inc/header.php');
}

//懒得解决分页问题，直接 9999 （光速逃
Helper::options()->commentsPageSize = 9999;

$BloggerAvatar = (Helper::options()->siteAvatar) ? Helper::options()->siteAvatar : Castle_Libs::resources('static/img/avatar.jpg');
?>

   <div id="links-view"  data-view="<?php echo Castle_Contents::PostView($this); ?>"></div>
   <main class="moe-links-box">
    <div class="mdui-row-sm-2 mdui-row-md-4">


     <div class="mdui-col">
      <a class="moe-links-href" mdui-dialog="{target: '#links-dialog', history: false, modal: true}" no-go>
       <div class="mdui-card moe-links-card mdui-hoverable">
        <div class="mdui-card-media">
         <main class="lazyload" data-src="<?php echo $BloggerAvatar; ?>" style="background-image: url('');"></main>
        </div>
        <div class="mdui-card-actions mdui-text-center">
         <img src="<?php echo $BloggerAvatar; ?>" data-original="<?php echo $BloggerAvatar; ?>" class="moe-links-avatar"/><br>
         <span class="moe-links-title">申请友链</span>
         <span class="moe-links-description">点此进行申请</span>
        </div>
       </div>
      </a>
     </div>

     <?php
      if (Castle_Libs::hasPlugin('Links')) {
       $Links = Links_Plugin::output('<div class="mdui-col">
       <a class="moe-links-href" href="{url}" title="{title}" target="_blank">
        <div class="mdui-card moe-links-card mdui-hoverable">
         <div class="mdui-card-media">
          <main class="lazyload" data-src="{image}" style="background-image: url(\'\');"></main>
         </div>
         <div class="mdui-card-actions mdui-text-center">
          <img src="{image}" data-original="{image}" class="moe-links-avatar"/><br>
          <span class="moe-links-title">{name}</span>
          <span class="moe-links-description">{description}</span>
         </div>
        </div>
       </a>
      </div>');

      if (Helper::options()->pageLinks && in_array('rand', Helper::options()->pageLinks)) {
       shuffle($Links);
      }
      for ($i=0;$i<count($Links);$i++) { echo $Links[$i]; }
     }else{
      echo '<div class="mdui-col">
      <a class="moe-links-href" no-go>
       <div class="mdui-card moe-links-card mdui-hoverable">
        <div class="mdui-card-media">
         <main class="lazyload" data-src="'.$BloggerAvatar.'" style="background-image: url(\'\');"></main>
        </div>
        <div class="mdui-card-actions mdui-text-center">
         <img src="'.$BloggerAvatar.'" data-original="'.$BloggerAvatar.'" class="moe-links-avatar"/><br>
         <span class="moe-links-title">友链插件未启用</span>
         <span class="moe-links-description">请安装 Links 插件并启用</span>
        </div>
       </div>
      </a>
     </div>';
     }
     ?>

    </div>
   </main>

   <div class="mdui-dialog" id="links-dialog">
    <div class="mdui-card moe-post-card">
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

     <div class="mdui-divider"></div>

     <div class="moe-card-content">
      <?php $this->content(); ?>
     </div>
    </div>
    <?php $this->need('core/inc/comments.php'); ?>

    <button class="mdui-btn mdui-btn-icon mdui-color-theme mdui-hoverable" id="links-close" mdui-dialog-close><i class="mdui-icon material-icons">&#xe5cd;</i></button>
   </div>

<?php
if (@$_SERVER['HTTP_X_PJAX'] == true) {
 echo '</div>';
}else{
 $this->need('core/inc/footer.php');
}
?>