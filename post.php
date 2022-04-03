<?php
/**
 * Castle Post
 * Last Update: 2021/04/18
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (@$_SERVER['HTTP_X_PJAX'] == true) {
   Typecho_Response::getInstance()->setStatus(200);
   echo '<title>' . Castle_Header::title($this, '', ' - ', true, false) . '</title>';
   echo '<div id="moe-pjax-content"' . Castle_Header::cardTransparent() . '>';
} else {
   $this->need('core/inc/header.php');
}
Typecho_Widget::widget('Widget_Security')->to($security);
?>
<div class="mdui-card moe-post-card" <?php if (Helper::options()->TocSwitch == '1') { ?> data-toc="<?php echo ($this->fields->showToc) ? 'true' : 'false'; ?>" <?php
                                                                                                                                                               $postSeting = Castle_Contents::getSetting($this, 'tocPopup');
                                                                                                                                                               $postSeting = (isset($postSeting)) ? $postSeting : [];
                                                                                                                                                               echo ($postSeting === false || $postSeting == 'false') ? ' data-popup="false"' : '';
                                                                                                                                                            } ?>>
   <div class="mdui-card-media">
      <div class="moe-card-cover-image lazyload" data-src="<?php
                                                            $cover = $this->fields->cover;
                                                            if (!empty($cover)) {
                                                               echo $cover;
                                                            } else {
                                                               Castle_Libs::randCover(true);
                                                            }
                                                            ?>" style="background-image:url('');"></div>
      <div class="mdui-card-media-covered">
         <div class="mdui-card-primary">
            <div class="mdui-card-primary-title mdui-text-truncate"><?php $this->title() ?></div>
            <div class="mdui-card-primary-subtitle"><?php echo sprintf($GLOBALS['CastleLang']['post']['view'], Castle_Contents::PostView($this)); ?> | <?php echo sprintf($GLOBALS['CastleLang']['post']['comment'], $this->commentsNum); ?><?php if (Helper::options()->WordsCounterSwitch && in_array('post', Helper::options()->WordsCounterSwitch)) { ?> | <?php echo sprintf($GLOBALS['CastleLang']['post']['wordNum'], Castle_WordCounter::charactersNum($this));
                                                                                                                                                                                                                                                                                                                                                            } ?></div>
         </div>
      </div>
   </div>

   <div class="mdui-card-header">
      <img class="mdui-card-header-avatar" src="<?php echo (Helper::options()->siteAvatar) ? Helper::options()->siteAvatar : Castle_Libs::resources('static/img/avatar.jpg'); ?>" />
      <div class="mdui-card-header-title"><?php $this->author(); ?></div>
      <div class="mdui-card-header-subtitle"><?php $this->date($GLOBALS['CastleLang']['post']['time']); ?></div>
      <div class="mdui-card-menu">
         <?php if ($this->user->hasLogin()) {
            echo '<button class="mdui-btn mdui-btn-icon" mdui-menu="{target: \'#postEditMenu\', align: \'right\'}"><i class="mdui-icon material-icons">edit</i></button>';
            echo '<ul class="mdui-menu" id="postEditMenu">
              <li class="mdui-menu-item">
               <a href="' . $this->options->adminUrl . 'write-post.php?cid=' . $this->cid . '" class="mdui-ripple" target="_blank">
                <i class="mdui-menu-item-icon mdui-icon material-icons">edit</i>' . $GLOBALS['CastleLang']['post']['menu']['edit']['edit'] . '
               </a>
              </li>

              <li class="mdui-menu-item">
               <a data-delUrl="' . $security->getIndex('/action/contents-post-edit?do=delete&cid=' . $this->cid) . '" class="mdui-ripple mdui-text-color-red-accent" onclick="return CastlePost.delPost(this, \'' . $this->title . '\', true);">
                <i class="mdui-menu-item-icon mdui-icon material-icons mdui-text-color-red-accent">delete</i>' . $GLOBALS['CastleLang']['post']['menu']['edit']['delete'] . '
               </a>
              </li>
             </ul>';
         } ?>
         <?php if (Helper::options()->deviceQRSwitch && in_array('post', Helper::options()->deviceQRSwitch)) {
            echo '<button class="mdui-btn mdui-btn-icon" mdui-menu="{target: \'#QRcode\', align: \'right\'}"><i class="mdui-icon material-icons">&#xe1b1;</i></button>';
            echo '<div class="mdui-menu" id="QRcode">
                   <li class="mdui-menu-item"></li>
                  </div>';
         } ?>
      </div>
   </div>

   <div class="mdui-divider"></div>

   <div class="moe-card-content">
      <?php $this->content(); ?>

      <blockquote class="moe-post-card-copy">
         <?php
         $text = str_replace('{author}', Castle_Libs::getUserScreenName($this->stack[0]['authorId']), $GLOBALS['CastleLang']['post']['copy']);
         $text = str_replace('{link}', '<a href="' . $this->permalink . '">' . $this->permalink . '</a>', $text);
         $text = str_replace('{time}', date('Y-m-d H:i:s', $this->modified), $text);
         $text = str_replace('{protocol}', '<a href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.zh" target="_blank">CC BY-NC-SA 4.0</a>', $text);
         echo $text
         ?>
      </blockquote>
   </div>
</div>
<?php $this->need('core/inc/comments.php'); ?>
<?php
//如果有密码且有权限查看则显示导航栏
if (!$this->hidden) { ?>
   <div class="moe-post-nav">
      <div class="mdui-container">
         <div class="mdui-row">
            <?php (new Castle_Contents())->thePrev($this); ?>
            <?php (new Castle_Contents())->theNext($this); ?>
         </div>
      </div>
   </div>
<?php } ?>
<?php
if (@$_SERVER['HTTP_X_PJAX'] == true) {
   echo '</div>';
} else {
   $this->need('core/inc/footer.php');
}
?>