<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
$this->need('includes/header.php');
?>
  <style>footer{display:none;}header{display:none;}.mdui-appbar-with-toolbar{padding-top: 0px;}</style>
  <div class="moe-404-body">
   <div class="mdui-card moe-card-404">
    <div class="mdui-card-media moe-card-media">
	 <main class="moe-card-img" data-original="<?php echo themeResource('others/img/404.jpg'); ?>" style="background-image: url('<?php echo themeResource('others/img/loading.gif'); ?>');"></main>
	 <div class="mdui-card-media-covered">
	  <div class="mdui-card-primary">
	   <div class="mdui-card-primary-title moe-card-title moe-text-ellipsis"><?php $this->options->title(); ?></div>
      </div>
     </div>
    </div>
	
    <div class="moe-404-content">
	 <div class="moe-title">404 Not Found</div>
	 <div class="moe-des">或许你可以试着搜索一下？</div>
	 
	 <form id="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
	 <div class="mdui-textfield moe-search-p">
      <input class="mdui-textfield-input" type="text" name="s" id="searchOuO" placeholder="输入你想搜索的内容吧！"/>
     </div>
	 <button class="mdui-btn mdui-btn-icon mdui-color-theme-accent mdui-ripple moe-btn mdui-btn-raised"><i class="mdui-icon material-icons">search</i></button>
	 </form>
	</div>
	
	<div class="moe-404-btn">
	 <ul class="mdui-list">
      <li class="mdui-list-item mdui-ripple">
       <i class="mdui-list-item-icon mdui-icon material-icons">home</i>
       <div class="mdui-list-item-content">首页</div>
      </li>
	  
	  <li class="mdui-list-item mdui-ripple">
       <i class="mdui-list-item-icon mdui-icon material-icons">account_circle</i>
       <div class="mdui-list-item-content">登录</div>
      </li>
	  
	  <li class="mdui-list-item mdui-ripple">
       <i class="mdui-list-item-icon mdui-icon material-icons">lock</i>
       <div class="mdui-list-item-content">注册</div>
      </li>
     </ul>
	</div>
   </div>
  </div>
  <script>
   $(document).attr("title","<?php echo lang('404', 'title')?>");
   var Search404URL = '<?php $this->options->siteUrl(); ?>';
  </script>
<?php $this->need('includes/footer.php'); ?>