<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
  </div>
  
  <footer class="moe-footer">
   <div class="mdui-container">
    <div class="mdui-row">
     <div class="mdui-col-xs-12 mdui-col-md-4 mdui-hidden-sm-down" style="float:left; margin-top:16px; margin-bottom:16px;">
      <div style="height:8px;"></div>
      <?php FooterSocial(); ?>
     </div>

     <div class="mdui-col-xs-12 mdui-col-md-4 mdui-hidden-md-up" style="text-align:center; margin-top:16px; margin-bottom:16px;">
      <div style="height:8px;"></div>
      <?php FooterSocial(); ?>
	 </div>    
            
     <div class="mdui-col-xs-12 mdui-col-md-4" style="text-align:center; margin-top:16px; margin-bottom:16px;  ">
      <br class="mdui-hidden-sm-down">
	  <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a> All rights reserved.</strong>
	  <br class="mdui-hidden-sm-down">
     </div>            

     <div class="mdui-col-xs-12 mdui-col-md-4 mdui-hidden-sm-down" style=" text-align:right; margin-top:16px; margin-bottom:16px;">
      <?php print_r(foinfo()); ?>
	 </div>
    </div>

    <div class="mdui-col-xs-12 mdui-col-md-4 mdui-hidden-md-up" style="text-align:center; margin-top:16px; margin-bottom:16px;">
     <?php print_r(foinfo()); ?>
	</div>
   </div>
  </footer>
  
<?php if ($this->options->tjcode): ?>
<div class="mdui-hidden">
 <?php $this->options->tjcode(); ?>
</div>
<?php endif; ?>
  
  <script src="<?php echo themeResource('others/js/jquery.lazyload.min.js'); ?>"></script>
  <script src="<?php echo themeResource('others/js/jquery.fancybox.min.js'); ?>"></script>
  <script>
   var siteurl = '<?php $this->options->siteUrl(); ?>';
   var PJAXtimeout = 8000;
   beforePJAX = function() {
    NProgress.start();
   }
   
   afterPJAX = function() {
    NProgress.done();
	mdui.mutation();
	lazyreload();
	<?php Helper::options()->pjaxRelaod(); ?>
   }
   var themeVer = '<?php echo themeVer('current'); ?>';
  </script>
  <script src="<?php echo themeResource('others/js/castle.min.js'); ?>"></script>
  <script>
   var Castle = new CastleSetting ({
    PJAX: true,
	goTop: true,
	title: true,
	copyPrompt: true,
	commentAJAX: true,
	defaultStyle: true,
	textareaHTML: true
   });
   var leaveTitle = '悄悄藏好 (/ω＼) ';
   var leaveIcon = 'https://ohmyga.cn/usr/themes/CastleME/others/img/huaji.png';
   var returnTitle = '被找到惹 Σ(っ °Д °;)っ ';
   var returnIcon = '<?php echo siteHeadimg('ico'); ?>';
   var copyPromptText = '转载请保留相应版权！';
   var topText = '回到顶部~';
  </script>
  
  <?php $this->footer(''); ?>
 </body>
 
</html>