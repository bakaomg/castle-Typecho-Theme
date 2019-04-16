<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
   <div class="moe-archive-<?php $this->archiveTitle(array('category'=>_t('Category'),'search'=>_t('Search'),'tag'=>_t('Tags'),'author'=> _t('Author')), '', ''); ?>">
    <div class="moe-archive-card mdui-card moe-card-tr">
	 <span><?php
	 $this->archiveTitle(array(
      'category'  =>  _t('分类 <i>%s</i> 下的文章'),
      'search'    =>  _t('包含关键字 <i>%s</i> 的文章'),
      'tag'       =>  _t('标签 <i>%s</i> 下的文章'),
      'author'    =>  _t('<i>%s</i> 发布的文章')), '', '');
	 ?></span>
	</div>
	
	<?php if ($this->have()): ?>
    <div id="moe-post">
     <?php while($this->next()): ?>
	 <?php $PostType = $this->fields->PostType;
     if($PostType == "nopic"){ ?>
	 <div class="mdui-card moe-card moe-card-day moe-card-tr">
	  <div class="moe-card-day-icon moe-headimg-xz"><i class="mdui-icon material-icons"><?php if(!empty(PSetting('Dicon'))) { echo PSetting('Dicon'); }else{ echo 'message'; } ?></i></div>
	  <h2 class="moe-day-title"><a href="<?php $this->permalink() ?>" title="<?php echo sprintf(lang('archive', 'FloatingTitle'), $this->title); ?>"><?php $this->title() ?></a></h2>
	  <span class="moe-day-d"><?php $this->excerpt(100); ?></span>
	  <div class="mdui-divider"></div>
	  <div class="moe-day-info">
	   <i class="mdui-icon material-icons moe-author-icon">account_circle</i>
	   <span class="moe-author"><?php $this->author(); ?></span>
	   <i class="mdui-icon material-icons moe-time-icon">access_time</i>
	   <span class="moe-time"><?php $this->date(lang('archive', 'time')); ?></span>
	   <i class="mdui-icon material-icons moe-comments-t">forum</i>
	   <span class="moe-comments moe-comments-t"><?php echo sprintf(lang('archive', 'commentNopic'), $this->commentsNum); ?></span>
	  </div>
	 </div>
	 <?php }elseif($PostType == "dynamic"){?>
	 <div class="mdui-card moe-card-day2 moe-card-tr">
	  <div class="moe-day2">
	   <i class="mdui-icon material-icons">autorenew</i>
	   <span class="moe-body">
	    <span class="moe-t"><?php if(!empty(PSetting('Dtitle'))) { echo PSetting('Dtitle'); }else{ $this->title(); } ?>（<a href="<?php $this->permalink() ?>"><?php echo lang('archive', 'LinkDynamic'); ?></a>）</span>
	    <span class="moe-info"><?php $this->date(lang('archive', 'time')); ?> • <?php echo sprintf(lang('archive', 'commentDynamic'), $this->commentsNum); ?> • <?php echo sprintf(lang('archive', 'viewDynamic'), PostView($this)); ?></span>
	   </span>
	  </div>
	 </div>
	 <?php }else{ ?>
     <div class="mdui-card moe-card mdui-hoverable moe-card-tr">
      <div class="mdui-card-media moe-card-media">
	   <main class="moe-card-img" data-original="<?php $wzimg = $this->fields->wzimg;
	  if(!empty($wzimg)){
       echo $this->fields->wzimg;
	  }else{
	   echo randPic();
	  }?>" style="background-image: url('<?php echo themeResource('others/img/loading.gif'); ?>');"></main>
	   <div class="mdui-card-media-covered">
	    <div class="mdui-card-primary">
	     <a href="<?php $this->permalink() ?>" class="mdui-card-primary-title moe-card-title moe-text-ellipsis" title="<?php echo sprintf(lang('archive', 'FloatingTitle'), $this->title); ?>"><?php $this->title() ?></a>
		 <div class="mdui-card-primary-subtitle"><?php echo sprintf(lang('archive', 'view'), PostView($this)); ?> | <?php echo sprintf(lang('archive', 'comment'), $this->commentsNum); ?></div>
        </div>
	   </div>
	  </div>
	 
	  <div class="mdui-card-actions">
	   <div class="moe-post-margin"></div>
	   <span class="moe-post-text">
	    <?php $this->excerpt(100); ?>
	   </span>
	   <div class="moe-post-margin"></div>
	  </div>
	 
	  <div class="mdui-divider"></div>
	 
	  <div class="mdui-card-header">
	   <img class="mdui-card-header-avatar moe-headimg-xz" data-original="<?php echo siteHeadimg('pauthor', $this); ?>" src="<?php echo themeResource('others/img/loading.gif'); ?>">
	   <div class="mdui-card-header-title"><?php $this->author(); ?></div>
	   <div class="mdui-card-header-subtitle"><?php $this->date(lang('archive', 'time')); ?></div>
	   <div class="mdui-card-menu">
	    <a href="<?php $this->permalink() ?>" class="mdui-btn mdui-text-color-theme"><?php echo lang('archive', 'ViewLink'); ?></a>
	   </div>
	  </div>
     </div>
	 <?php } ?>
     <?php endwhile; ?>
     <div class="moe-margin-card-top"></div>
	 <div class="moe-page-div">
	  <?php $this->pageLink('<button class="mdui-btn mdui-btn-icon mdui-ripple mdui-color-theme-accent mdui-shadow-5 moe-prev"><i class="mdui-icon material-icons">navigate_before</i></button>','prev'); ?>
	  <button class="mdui-btn moe-number" disabled><span class=""><?php if($this->_currentPage>1) echo $this->_currentPage;  else echo 1;?> / <?php echo ceil($this->getTotal() / $this->parameter->pageSize); ?></span></button>
	  <?php $this->pageLink('<button class="mdui-btn mdui-btn-icon mdui-ripple mdui-color-theme-accent mdui-shadow-5 moe-next"><i class="mdui-icon material-icons">navigate_next</i></button>','next'); ?>
     </div>
    </div>
	<?php else: ?>
	<div class="moe-card moe-archive-nofound mdui-card mdui-color-red">
	 <span><?php echo lang('archive', 'nofound'); ?></span>
	</div>
	<?php endif; ?>
   </div>