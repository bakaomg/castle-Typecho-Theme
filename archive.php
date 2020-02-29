<?php
/**
 * Castle Archive
 * Last Update: 2020/02/09
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
   <main id="moe-post-list">

    <div class="mdui-card moe-archive-top-card">
     <main><?php
	 $this->archiveTitle(array(
      'category'  =>  _t('分类 <i>%s</i> 下的文章'),
      'search'    =>  _t('包含关键字 <i>%s</i> 的文章'),
      'tag'       =>  _t('标签 <i>%s</i> 下的文章'),
      'author'    =>  _t('<i>%s</i> 发布的文章')), '', '');
	 ?></main>
    </div>

<?php while($this->next()): ?>
    <div class="mdui-card mdui-hoverable moe-default-card">
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
        <a href="<?php $this->permalink() ?>" class="mdui-card-primary-title mdui-text-truncate"><?php $this->title() ?></a>
        <div class="mdui-card-primary-subtitle"><?php echo sprintf($GLOBALS['CastleLang']['index']['view'], Castle_Contents::PostView($this)); ?> | <?php echo sprintf($GLOBALS['CastleLang']['index']['comment'], $this->commentsNum); ?></div>
       </div>
      </div>
     </div>

     <div class="mdui-card-actions">
      <div class="moe-card-excerpt">
       <?php if (!$this->excerpt && !$this->fields->excerpt) {
        echo $GLOBALS['CastleLang']['index']['excerptEmpty'];
       } elseif ($this->fields->excerpt) {
        echo Castle_Contents::parseOwO($this->fields->excerpt);
       } else {
        $this->excerpt(100);
       } ?>
      </div>
     </div>

     <div class="mdui-divider"></div>

     <div class="mdui-card-header">
      <img class="mdui-card-header-avatar" src="<?php echo (Helper::options()->siteAvatar) ? Helper::options()->siteAvatar : Castle_Libs::resources('static/img/avatar.jpg'); ?>"/>
      <div class="mdui-card-header-title"><?php $this->author(); ?></div>
      <div class="mdui-card-header-subtitle"><?php $this->date($GLOBALS['CastleLang']['index']['time']); ?></div>
      <div class="mdui-card-menu">
	   <a href="<?php $this->permalink() ?>" class="mdui-btn mdui-text-color-theme"><?php echo $GLOBALS['CastleLang']['index']['viewLink']; ?></a>
	  </div>
     </div>
    </div>
<?php endwhile; ?>

    
    <div class="moe-pagination">
     <?php if ($this->_currentPage>1){ ?>
      <?php $this->pageLink('<button class="mdui-btn mdui-btn-icon mdui-ripple mdui-color-theme-accent mdui-shadow-5 moe-prev"><i class="mdui-icon material-icons">navigate_before</i></button>','prev'); ?>
     <?php }else{ ?>
      <button class="mdui-btn mdui-btn-icon mdui-ripple mdui-color-theme-accent mdui-shadow-5 mdui-btn-raised moe-prev" disabled><i class="mdui-icon material-icons">navigate_before</i></button>
     <?php } ?>

     <button class="mdui-btn moe-page-number"><span class=""><?php if($this->_currentPage>1) echo $this->_currentPage;  else echo 1;?> / <?php echo ceil($this->getTotal() / $this->parameter->pageSize); ?></span></button>

     <?php if ($this->_currentPage<ceil($this->getTotal()/$this->parameter->pageSize)){ ?>
      <?php $this->pageLink('<button class="mdui-btn mdui-btn-icon mdui-ripple mdui-color-theme-accent mdui-shadow-5 moe-next"><i class="mdui-icon material-icons">navigate_next</i></button>','next'); ?>
     <?php } else { ?>
      <button class="mdui-btn mdui-btn-icon mdui-ripple mdui-color-theme-accent mdui-btn-raised mdui-shadow-5 moe-next" disabled><i class="mdui-icon material-icons">navigate_next</i></button>
     <?php } ?>
    </div>
   </main>
<?php
if (@$_SERVER['HTTP_X_PJAX'] == true) {
 echo '</div>';
}else{
 $this->need('core/inc/footer.php');
}
?>