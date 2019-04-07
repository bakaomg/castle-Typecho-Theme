<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
  <div class="mdui-drawer mdui-drawer-full-height mdui-drawer-close moe-sidebar" id="sidebar">
   <div class="moe-sidebar-bg" style="background: url(<?php echo themeResource('others/img/sidebar.jpg'); ?>);">
    <img src="<?php echo siteHeadimg('ico'); ?>" class="moe-sidebar-headimg mdui-shadow-6 moe-headimg-xz">
	<span class="moe-sidebar-author moe-sidebar-text-shadow">
	 <?php echo Castle::getAdminScreenName(); ?><br>
	 <span class="moe-sidebar-description"><?php $this->options->description() ?></span>
	</span>
   </div>
   <ul class="mdui-list" mdui-collapse="{accordion: true}">
    <a href="<?php $this->options->siteUrl(); ?>" class="mdui-list-item mdui-ripple" mdui-drawer-close>
     <i class="mdui-icon material-icons mdui-list-item-icon">home</i>
     <div class="mdui-list-item-content"><?php echo lang('sidebar', 'home'); ?></div>
    </a>
	
	<?php DrawerMenu(); ?>
   </ul>
  </div>