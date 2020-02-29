<?php
/**
 * Castle Page
 * Last Update: 2020/02/14
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (@$_SERVER['HTTP_X_PJAX'] == true) {
 header('HTTP/1.1 200 OK');
 echo '<title>'.Castle_Header::title($this, '', ' - ', true, false).'</title>';
 echo '<div id="moe-pjax-content"'.Castle_Header::cardTransparent().'>';
}else{
 $this->need('core/inc/header.php');
}
Typecho_Widget::widget('Widget_Security')->to($security);
?>
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

    <div class="mdui-card-header">
     <img class="mdui-card-header-avatar" src="<?php echo (Helper::options()->siteAvatar) ? Helper::options()->siteAvatar : Castle_Libs::resources('static/img/avatar.jpg'); ?>"/>
     <div class="mdui-card-header-title"><?php $this->author(); ?></div>
     <div class="mdui-card-header-subtitle"><?php $this->date($GLOBALS['CastleLang']['page']['time']); ?></div>
     <div class="mdui-card-menu">
      <?php if($this->user->hasLogin()){
       echo '<button class="mdui-btn mdui-btn-icon" mdui-menu="{target: \'#postEditMenu\', align: \'right\', position: \'top\'}"><i class="mdui-icon material-icons">edit</i></button>';
       echo '<ul class="mdui-menu" id="postEditMenu">
              <li class="mdui-menu-item">
               <a href="'.$this->options->adminUrl.'write-page.php?cid='.$this->cid.'" class="mdui-ripple" target="_blank">
                <i class="mdui-menu-item-icon mdui-icon material-icons">edit</i>'.$GLOBALS['CastleLang']['page']['menu']['edit']['edit'].'
               </a>
              </li>

              <li class="mdui-menu-item">
               <a data-delUrl="'.$security->getIndex('/action/contents-page-edit?do=delete&cid='.$this->cid).'" class="mdui-ripple mdui-text-color-red-accent" onclick="return CastlePost.delPost(this, \''.$this->title.'\');">
                <i class="mdui-menu-item-icon mdui-icon material-icons mdui-text-color-red-accent">delete</i>'.$GLOBALS['CastleLang']['page']['menu']['edit']['edit'].'
               </a>
              </li>
             </ul>';
      } ?>
     </div>
    </div>

    <div class="mdui-divider"></div>

    <div class="moe-card-content">
     <?php $this->content(); ?>

     <blockquote class="moe-post-card-copy">
      <?php
       $text = str_replace('{author}', Castle_Libs::getUserScreenName($this->stack[0]['authorId']), $GLOBALS['CastleLang']['page']['copy']);
       $text = str_replace('{link}', '<a href="'.$this->permalink.'">'.$this->permalink.'</a>', $text);
       $text = str_replace('{time}', date('Y-m-d H:i:s', $this->modified), $text);
       $text = str_replace('{protocol}', '<a href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.zh" target="_blank">CC BY-NC-SA 4.0</a>', $text);
       echo $text
      ?>
     </blockquote>
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