<?php
/**
 * OwO表情选择框
 * Author: ohmyga
 * Version: 2019/06/02 V1.0
 * Link: https://ohmyga.cn/
 * GitHub: https://github.com/ohmyga233
 **/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
   <div class="moe-owo" id="owoBox">
    <div class="moe-owo-box">
     <div class="moe-owo-top">
	  <div class="moe-owo-title"><i class="mdui-icon material-icons"><?php echo Smile::randIcon(); ?></i></div>
      <button onclick="closeSmile()" class="mdui-btn mdui-btn-icon mdui-float-right moe-owo-close-btn"><i class="mdui-icon material-icons">close</i></button>
	 </div>
	 <div class="moe-dialog-body mdui-dialog-content" id="smiliesbox">
	  <?php Smile::getOwO(); ?>
	 </div>
     <div class="moe-owo-tab">
	  <div class="mdui-tab mdui-tab-full-width" id="OwO-tab" mdui-tab>
       <?php Smile::getTitle(); ?>
      </div>
	 </div>
	</div>
   </div>