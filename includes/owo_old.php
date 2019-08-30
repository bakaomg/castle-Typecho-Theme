<?php
/**
 * OwO表情选择框
 * Author: ohmyga
 * Version: 2019/04/06 V0.2
 * Link: https://ohmyga.cn/
 * GitHub: https://github.com/ohmyga233
 * 虽然有OwO那个开源项目，但我还是自己用最笨的方式写了表情框233
 **/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$owo_tieba_file = themeResource('others/img/OwO/tieba/');
$owo_huaji_file = themeResource('others/img/OwO/huaji/');
$owo_qwq_file = themeResource('others/img/OwO/qwq/');
?>
 <div class="mdui-dialog" id="OwO-ck">
 <div class="mdui-dialog-title moe-dialog-title">
  <div class="mdui-tab mdui-tab-full-width" id="OwO-tab" mdui-tab>
   <a href="#owo" class="mdui-ripple" no-pgo><?php echo lang('smile', 'OwO'); ?></a>
   <a href="#qwq" class="mdui-ripple" no-pgo><?php echo lang('smile', 'qwq'); ?></a>
   <a href="#emoji" class="mdui-ripple" no-pgo><?php echo lang('smile', 'emoji'); ?></a>
   <a href="#tieba" class="mdui-ripple" no-pgo><?php echo lang('smile', 'tieba'); ?></a>
   <a href="#hj" class="mdui-ripple" no-pgo><?php echo lang('smile', 'huaji'); ?></a>
  </div>
 </div>
 <div class="moe-dialog-body mdui-dialog-content" id="smiliesbox" style="display:block;">
  <div id="owo" class="mdui-p-a-2">
   <a href="javascript:Smilies.grin('OωO');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>OωO</span></a>
   <a href="javascript:Smilies.grin('ヾ(≧∇≦*)ゝ');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>ヾ(≧∇≦*)ゝ</span></a>
   <a href="javascript:Smilies.grin('|´・ω・)ノ');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>|´・ω・)ノ</span></a>
   <a href="javascript:Smilies.grin('(☆ω☆)');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>(☆ω☆)</span></a>
   <a href="javascript:Smilies.grin('（╯‵□′）╯︵┴─┴');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>（╯‵□′）╯︵┴─┴</span></a>
   <a href="javascript:Smilies.grin('￣﹃￣');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>￣﹃￣</span></a>
   <a href="javascript:Smilies.grin('∠( ᐛ 」∠)＿');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>∠( ᐛ 」∠)＿</span></a>
   <a href="javascript:Smilies.grin('(/ω＼)');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>(/ω＼)</span></a>
   <a href="javascript:Smilies.grin('(๑•̀ㅁ•́ฅ)');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>(๑•̀ㅁ•́ฅ)</span></a>
   <a href="javascript:Smilies.grin('୧(๑•̀⌄•́๑)૭');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>୧(๑•̀⌄•́๑)૭</span></a>
   <a href="javascript:Smilies.grin('٩(ˊᗜˋ*)و');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>٩(ˊᗜˋ*)و</span></a>
   <a href="javascript:Smilies.grin('→_→');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>→_→</span></a>
   <a href="javascript:Smilies.grin('(ノ°ο°)ノ');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>(ノ°ο°)ノ</span></a>
   <a href="javascript:Smilies.grin('(´இ皿இ｀)');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>(´இ皿இ｀)</span></a>
   <a href="javascript:Smilies.grin('⌇●﹏●⌇');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>⌇●﹏●⌇</span></a>
   <a href="javascript:Smilies.grin('(ฅ´ω`ฅ)');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>(ฅ´ω`ฅ)</span></a>
   <a href="javascript:Smilies.grin('(╯°A°)╯︵○○○');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>(╯°A°)╯︵○○○</span></a>
   <a href="javascript:Smilies.grin('φ(￣∇￣o)');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>φ(￣∇￣o)</span></a>
   <a href="javascript:Smilies.grin('ヾ(´･ ･｀｡)ノ');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>ヾ(´･ ･｀｡)ノ\"</span></a>
   <a href="javascript:Smilies.grin('( ง ᵒ̌皿ᵒ̌)ง⁼³₌₃');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>( ง ᵒ̌皿ᵒ̌)ง⁼³₌₃</span></a>
   <a href="javascript:Smilies.grin('(ó﹏ò｡)');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>(ó﹏ò｡)</span></a>
   <a href="javascript:Smilies.grin('Σ(っ °Д °;)っ');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>Σ(っ °Д °;)っ</span></a>
   <a href="javascript:Smilies.grin('( ,,´･ω･)ﾉ\\\'\'(´っω･｀｡)');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>( ,,´･ω･)ﾉ\"(´っω･｀｡)</span></a>
   <a href="javascript:Smilies.grin('╮(╯▽╰)╭');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>╮(╯▽╰)╭</span></a>
   <a href="javascript:Smilies.grin('o(*////▽////*)q');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>o(*////▽////*)q</span></a>
   <a href="javascript:Smilies.grin('( ๑´•ω•)\\\'\'(ㆆᴗㆆ)');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>( ๑´•ω•) \"(ㆆᴗㆆ)</span></a>
   <a href="javascript:Smilies.grin('(｡•ˇ‸ˇ•｡)');"><span class="moe-owo-text mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>(｡•ˇ‸ˇ•｡)</span></a>
  </div>
  
  <div id="emoji" class="mdui-p-a-2">
   <a href="javascript:Smilies.grin('😂');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😂</span></a>
   <a href="javascript:Smilies.grin('😀');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😀</span></a>
   <a href="javascript:Smilies.grin('😅');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😅</span></a>
   <a href="javascript:Smilies.grin('😊');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😊</span></a>
   <a href="javascript:Smilies.grin('🙂');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>🙂</span></a>
   <a href="javascript:Smilies.grin('🙃');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>🙃</span></a>
   <a href="javascript:Smilies.grin('😌');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😌</span></a>
   <a href="javascript:Smilies.grin('😍');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😍</span></a>
   <a href="javascript:Smilies.grin('😘');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😘</span></a>
   <a href="javascript:Smilies.grin('😏');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😏</span></a>
   <a href="javascript:Smilies.grin('😒');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😒</span></a>
   <a href="javascript:Smilies.grin('🙄');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>🙄</span></a>
   <a href="javascript:Smilies.grin('😳');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😳</span></a>
   <a href="javascript:Smilies.grin('😡');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😡</span></a>
   <a href="javascript:Smilies.grin('😔');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😔</span></a>
   <a href="javascript:Smilies.grin('😫');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😫</span></a>
   <a href="javascript:Smilies.grin('😱');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😱</span></a>
   <a href="javascript:Smilies.grin('😭');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😭</span></a>
   <a href="javascript:Smilies.grin('💩');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>💩</span></a>
   <a href="javascript:Smilies.grin('👻');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>👻</span></a>
   <a href="javascript:Smilies.grin('🙌');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>🙌</span></a>
   <a href="javascript:Smilies.grin('🖕');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>🖕</span></a>
   <a href="javascript:Smilies.grin('👍');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>👍</span></a>
   <a href="javascript:Smilies.grin('🌝');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>🌝</span></a>
   <a href="javascript:Smilies.grin('🌚');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>🌚</span></a>
   <a href="javascript:Smilies.grin('😶');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😶</span></a>
   <a href="javascript:Smilies.grin('🙏');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>🙏</span></a>
   <a href="javascript:Smilies.grin('😣');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>😣</span></a>
   <a href="javascript:Smilies.grin('💊');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>💊</span></a>
   <a href="javascript:Smilies.grin('🍉');"><span class="moe-owo-emoji mdui-btn mdui-card mdui-shadow-2" mdui-dialog-close>🍉</span></a>
  </div>
  
  <div id="qwq" class="mdui-p-a-2">
   <a href="javascript:Smilies.grin(':qwq1:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq1.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq2:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq2.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq3:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq3.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq4:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq4.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq5:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq5.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq6:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq6.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq7:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq7.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq8:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq8.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq9:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq9.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq10:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq10.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq11:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq11.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq12:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq12.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq13:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq13.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq14:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq14.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq15:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq15.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq16:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq16.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq17:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq17.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq18:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq18.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq19:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq19.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq20:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq20.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq21:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq21.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq22:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq22.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq23:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq23.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq24:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq24.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq25:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq25.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':qwq26:');"><div class="moe-owo-qwq mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_qwq_file.'qwq26.png'; ?>" /></div></a>
  </div>
  
  <div id="tieba" class="mdui-p-a-2">
   <a href="javascript:Smilies.grin(':a:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'a.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':bishi:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'bishi.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':bugaoxing:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'bugaoxing.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':guai:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'guai.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':haha:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'haha.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':han:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'han.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':hehe:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'hehe.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':heixian:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'heixian.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'huaji.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaxin:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'huaxin.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':jingku:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'jingku.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':jingyan:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'jingya.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':landeli:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'landeli.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':lei:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'lei.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':mianqiang:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'mianqiang.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':nidongde:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'nidongde.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':pen:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'pen.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':shuijiao:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'shuijiao.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':suanshuang:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'suanshuang.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':taikaixin:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'taikaixin.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':tushe:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'tushe.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':wabi:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'wabi.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':weiqu:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'weiqu.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':what:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'what.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':wuzuixiao:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'wuzuixiao.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':xiaoguai:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'xiaoguai.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':xiaohonglian:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'xiaohonglian.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':xiaoniao:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'xiaoniao.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':xiaoyan:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'xiaoyan.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':xili:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'xili.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':yamaidei:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'yamaidei.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':yinxian:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'yinxian.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':yiwen:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'yiwen.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':zhenbang:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'zhenbang.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':aixin:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'aixin.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':xinsui:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'xinsui.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':bianbian:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'bianbian.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':caihong:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'caihong.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':damuzhi:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'damuzhi.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':dangao:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'dangao.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':dengpao:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'dengpao.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':honglingjin:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'honglingjin.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':lazhu:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'lazhu.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':liwu:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'liwu.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':meigui:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'meigui.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':OK:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'OK.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':shafa:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'shafa.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':shouzhi:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'shouzhi.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':taiyang:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'taiyang.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':xingxingyueliang:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'xingxingyueliang.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':yaowan:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'yaowan.png'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':yinyue:');"><div class="moe-owo-tieba mdui-card mdui-btn" mdui-dialog-close><img src="<?php echo $owo_tieba_file.'yinyue.png'; ?>" /></div></a>
  </div>
  
  <div id="hj" class="mdui-p-a-2">
   <a href="javascript:Smilies.grin(':huaji8:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji8.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji18:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji18.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji15:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji15.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji27:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji27.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji20:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji20.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji13:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji13.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji23:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji23.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji9:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji9.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji26:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji26.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji12:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji12.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji7:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji7.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji19:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji19.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji21:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji21.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji22:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji22.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji5:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji5.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji3:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji3.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji4:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji4.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji6:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji6.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji1:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji1.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji2:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji2.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji10:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji10.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji11:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji11.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji17:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji17.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji16:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji16.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji14:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji14.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji24:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji24.gif'; ?>" /></div></a>
   <a href="javascript:Smilies.grin(':huaji25:');"><div class="moe-owo-hj mdui-card mdui-btn" mdui-dialog-close><img class="mdui-img-fluid" src="<?php echo $owo_huaji_file.'huaji25.gif'; ?>" /></div></a>
  </div>
 </div>
  <div class="mdui-dialog-actions">
   <button class="mdui-btn mdui-ripple" type="button" mdui-dialog-close><?php echo lang('smile', 'close'); ?></button>
  </div>
 </div>