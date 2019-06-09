<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if ($this->options->other && in_array('pjax', $this->options->other)){ $pjaxStatus = 'true'; }else{ $pjaxStatus = 'false'; }
if ($this->options->other && in_array('gotop', $this->options->other)){ $topStatus = 'true'; }else{ $topStatus = 'false'; }
if ($this->options->other && in_array('title', $this->options->other)){ $titleStatus = 'true'; }else{ $titleStatus = 'false'; }
if ($this->options->other && in_array('copy', $this->options->other)){ $copyStatus = 'true'; }else{ $copyStatus = 'false'; }
if ($this->options->comment && in_array('ajax', $this->options->comment)){ $cajaxStatus = 'true'; }else{ $cajaxStatus = 'false'; }
if ($this->options->other && in_array('night', $this->options->other)){ $nightStatus = 'true'; }else{ $nightStatus = 'false'; }
?>
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
      <?php echo foinfo();?>
	 </div>
    </div>

    <div class="mdui-col-xs-12 mdui-col-md-4 mdui-hidden-md-up" style="text-align:center; margin-top:16px; margin-bottom:16px;">
     <?php echo foinfo();?>
	</div>
   </div>
  </footer>
  
<?php if ($this->options->statistics): ?>
<div class="mdui-hidden">
 <?php $this->options->statistics(); ?>
</div>
<?php endif; ?>

  <script src="<?php echo themeResource('others/js/highlight.min.js'); ?>"></script>
  <script src="<?php echo themeResource('others/js/jquery.lazyload.min.js'); ?>"></script>
  <script src="<?php echo themeResource('others/js/jquery.fancybox.min.js'); ?>"></script>
  <script>
   var siteurl = '<?php $this->options->siteUrl(); ?>';
   <?php if($pjaxStatus == 'true'): ?>var PJAXtimeout = 8000;
   beforePJAX = function() {
    NProgress.start();
   };
   
   afterPJAX = function() {
    NProgress.done();
	mdui.mutation();
	<?php Helper::options()->pjaxRelaod(); ?>
   };<?php endif; ?>
   var themeVer = '<?php echo themeVer('current'); ?>';
   var NowTime = '19:00<?php //echo date('H:i'); ?>';
  </script>
  <script src="<?php echo themeResource('others/js/castle.min.js'); ?>"></script>
  <script>
   var Castle = new CastleSetting ({
    PJAX: <?php echo $pjaxStatus; ?>,
	goTop: <?php echo $topStatus; ?>,
	title: <?php echo $titleStatus; ?>,
	copyPrompt: <?php echo $copyStatus; ?>,
	commentAJAX: <?php echo $cajaxStatus; ?>,
	textareaHTML: true,
	NightOrDay: <?php echo $nightStatus; ?>
   });
   var leaveTitle = '<?php $leaveTitle = adSetting('setting', 'leave', 'title'); if(!empty($leaveTitle)){ echo adSetting('setting', 'leave', 'title'); }else{ echo '???? (/?\) '; } ?>';
   var leaveIcon = '<?php $leaveIcon = adSetting('setting', 'leave', 'icon'); if(!empty($leaveIcon)){ echo adSetting('setting', 'leave', 'icon'); }else{ echo themeResource('others/img/huaji.png'); } ?>';
   var returnTitle = '<?php $returnTitle = adSetting('setting', 'return', 'title'); if(!empty($returnTitle)){ echo adSetting('setting', 'return', 'title'); }else{ echo '???? S(? °? °;)? '; } ?>';
   var returnIcon = '<?php $returnIcon = adSetting('setting', 'return', 'icon'); if(!empty($returnIcon)){ echo adSetting('setting', 'return', 'icon'); }else{ echo themeResource('others/img/OwO/tieba/a.png'); } ?>';
   var OriginIcon = '<?php echo siteHeadimg('ico'); ?>';
   var copyPromptText = '<?php $copyPromptText = adSetting('setting', 'copyPrompt', 'text'); if(!empty($copyPromptText)){ echo adSetting('setting', 'copyPrompt', 'text'); }else{ echo '?????????!'; } ?>';
   var copyPromptTitle = '<?php $copyPromptTitle = adSetting('setting', 'copyPrompt', 'title'); if(!empty($copyPromptTitle)){ echo adSetting('setting', 'copyPrompt', 'title'); }else{ echo '??'; }?>';
   var topText = '<?php $toTopText = adSetting('setting', 'toTopText'); if(!empty($toTopText)){ echo adSetting('setting', 'toTopText'); }else{ echo '????~'; } ?>';
  </script>
  
  <?php $this->footer(''); ?>
 </body>
 
</html><?php if ($this->options->other && in_array('html', $this->options->other)){ $html_source = ob_get_contents(); ob_clean(); print compressHtml($html_source); ob_end_flush(); } ?>