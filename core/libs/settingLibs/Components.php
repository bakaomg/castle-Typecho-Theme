<?php
/**
 * Castle Theme Config Component
 * Last Update: 2020/03/25
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_Component {
 private $form;
 private $token;
 private $security;
 
 public function __construct ($form) {
  $this->form = $form;
  $this->token = md5(CASTLE_VERSION).'@'.$_SERVER['HTTP_HOST'];
  Typecho_Widget::widget('Widget_Security')->to($security);
  $this->security = $security;
 }

 /**
  * Main
  */
 public function main($content = "") {
  //echo "<style>body{background-color:#F5F5F5}@media screen and (min-device-width:1024px){::-webkit-scrollbar-track{background-color:rgba(255,255,255,0)}::-webkit-scrollbar{width:6px;background-color:rgba(255,255,255,0)}::-webkit-scrollbar-thumb{border-radius:3px;background-color:rgba(193,193,193,1)}}.typecho-head-nav{background-color:#673AB7}#typecho-nav-list .focus .parent a,#typecho-nav-list .parent a:hover,#typecho-nav-list .root:hover .parent a{background:RGBA(255,255,255,0)}#typecho-nav-list{display:none}.typecho-head-nav .operate a{border:0;color:rgba(255,255,255,.6)}.typecho-head-nav .operate a:focus,.typecho-head-nav .operate a:hover{color:rgba(255,255,255,.8);background-color:#673AB7;outline:0}.body.container{min-width:100%!important;padding:0}.row{margin:0}.col-mb-12{padding:0!important}.typecho-page-title{height:100px;padding:10px 40px 20px 40px;background-color:#673AB7;color:#FFF;font-size:24px}.typecho-option-tabs{padding:0;margin:0;height:60px;background-color:#512DA8;margin-bottom:40px!important;padding-left:25px}.typecho-option-tabs li{margin:0;border:none;float:left;position:relative;display:block;text-align:center;font-weight:500;font-size:14px;text-transform:uppercase}.typecho-option-tabs a{height:auto;border:0;color:rgba(255,255,255,.6);background-color:rgba(255,255,255,0)!important;padding:17px 24px}.typecho-option-tabs a:hover{color:rgba(255,255,255,.8)}.message{background-color:#673AB7!important;color:#fff}.success{background-color:#673AB7;color:#fff}.current{background-color:#FFF;height:4px;padding:0!important;bottom:0}.current a{color:#FFF}input[type=text],textarea{border:none;border-bottom:1px solid rgba(0,0,0,.6);outline:0;border-radius:0}.typecho-option span{margin-right:0}.typecho-option-submit{position:fixed;right:32px;bottom:32px}.typecho-option-submit button{float:right;background:#00BCD4;box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);color:#FFF}.typecho-page-main .typecho-option textarea{height:149px}.typecho-option label.typecho-label{font-weight:500;margin-bottom:20px;margin-top:10px;font-size:16px;padding-bottom:5px;border-bottom:1px solid rgba(0,0,0,.2)}#use-intro{box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);background-color:#fff;margin:8px;padding:8px;padding-left:20px;margin-bottom:40px}.typecho-foot{padding:16px 40px;color:#9e9e9e;margin-top:80px}botton,form{display:none}.mdui-panel-item-title{width:auto!important}</style>";
  echo '<form class="moe-setting-form" action="'.$this->security->getIndex('/action/themes-edit?config').'" method="post" enctype="application/x-www-form-urlencoded" style="display: block!important">';
  echo $content;
  echo '<button class="typecho-option-submit typecho-option btn primary">保存设置</button>';
  echo '</form>';
 }

 /**
  * Theme Info Panel
  */
 public function themePanel() {
  $themeBG = (Helper::options()->themeConfigBG) ? Helper::options()->themeConfigBG : Castle_Libs::resources('static/img/bg/setting.png', false);
  echo '<link href="https://cdn.jsdelivr.net/npm/mdui@0.4.3/dist/css/mdui.min.css" rel="stylesheet">'.
       '<script src="https://cdn.jsdelivr.net/npm/mdui@0.4.3/dist/js/mdui.min.js"></script>'.
       '<link href="'.Castle_Libs::resources('static/css/castle.setting.min.css', false).'" rel="stylesheet">'.
       '<script>var CastleConfig = {"bgurl": "'.$themeBG.'", "quq": {"open": "'.Castle_Libs::resources('static/img/webp/na.png', false).'", "close": "'.Castle_Libs::resources('static/img/webp/setting.png', false).'"}};</script>'.
       '<script src="'.Castle_Libs::resources('static/js/castle.setting.min.js', false).'"></script>';
       
  
  $string = '';
  $string .= '<div class="mdui-card" id="moe-theme-panel">';
  $string .= '<img src="'.Castle_Libs::resources('static/img/webp/na.webp', false).'" class="moe-quq" onclick="CastleLinkPanel.toggle()"/>';

  //链接面板
  $string .= '<div id="moe-theme-panel-menu" class="moe-menu-open" style="display:block;">
   <div class="moe-menu-title">Links</div>
   <a href="'.Helper::options()->adminUrl.'themes.php">主题列表</a>
   <a href="'.Helper::options()->adminUrl.'theme-editor.php">编辑主题</a>
   <div class="now" disabled>主题设置</div>
  </div>';


  $string .= '<div class="moe-theme-panel-content">
   <div class="mdui-typo-title">主题设置</div>
   <br/>
   <div id="update-msg"><span class="mdui-text-color-pink-accent">正在检查是否有新版本...</span></div>
   <div id="update-data" data-up="'.base64_encode('theme='.Castle_Libs::getTheme().'&version='.CASTLE_VERSION.'&token='.$this->token).'"></div>
   <script>CastleUpdate.AJAXGet();</script>
   相关链接：<a href="https://ohmyga.cn/" target="_blank">O\'s Blog</a> | <a href="https://castle.baka.show/" target="_blank">主题文档</a> | <a href="https://github.com/ohmyga233/castle-Typecho-Theme" target="_blank">GitHub 发布页</a>
   <br/><br/>
   <button class="mdui-btn mdui-btn-dense mdui-btn-raised mdui-color-teal" type="button" onclick="CastlePanel.open();">打开全部面板</button>
   <button class="mdui-btn mdui-btn-dense mdui-btn-raised mdui-color-red" type="button" onclick="CastlePanel.close();">关闭全部面板</button>
   <br/><br/>
   <form class="protected" action="?CastleBackup" method="post" style="display: block!important">
    <input class="mdui-btn mdui-btn-dense mdui-btn-raised mdui-color-teal" type="submit" name="type" value="备份模板数据" />
    <input class="mdui-btn mdui-btn-dense mdui-btn-raised mdui-color-blue-600" type="submit" name="type" value="还原模板数据" />
    <input class="mdui-btn mdui-btn-dense mdui-btn-raised mdui-color-red" type="submit" name="type" value="删除备份数据" />
   </form>
  </div>';
  $string .= '</div>';

  echo $string;
 }

 /**
  * Panel
  */
 public function panel($title = "", $summary = "", $content = "", $gapless = false, $open = false) {
  $gapless = ($gapless) ? " mdui-panel-gapless" : NULL;
  $open = ($open) ? " mdui-panel-item-open" : NULL;
  
  if (is_array($summary)) {
   $summary = '<div class="mdui-panel-item-summary">'.$summary[0].'</div>';
   $summary .= '<div class="mdui-panel-item-summary">'.$summary[1].'</div>';
  }else{
   $summary = $summary;
  }

  $string = '';

  $string .= '<div class="mdui-panel'.$gapless.'" id="panel" mdui-panel>';
  $string .= '<div class="mdui-panel-item">';
  $string .= '<div class="mdui-panel-item-header">
   <div class="mdui-panel-item-title">'.$title.'</div>
   '.$summary.'
   <i class="mdui-panel-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
  </div>';
  $string .= '<div class="mdui-panel-item-body">'.$content.'</div>';
  $string .= '</div></div>';

  return $string;
 }

 /**
  * Card
  */
 public function card($title = "", $summary = "", $content = "") {
  $title = ($title) ? '<div class="mdui-card-primary-title">'.$title.'</div>' : NULL;
  $summary = ($summary) ? '<div class="mdui-card-primary-subtitle">'.$summary.'</div>' : NULL;
  $primaryHead = (!$title && !$summary) ? NULL : '<div class="mdui-card-primary">';
  $primaryFoot = (!$title && !$summary) ? NULL : '</div>';
  
  $string = '';
  $string .= '<div class="mdui-card">';
  $string .= $primaryHead;
  $string .= $title;
  $string .= $summary;
  $string .= $primaryFoot;
  $string .= '<div class="mdui-card-content">'.$content.'</div>';
  $string .= '</div>';
  
  return $string;
 }

 /**
  * Input 
  */
 public function input($name, $display = NULL, $description = NULL, $default = NULL, $desType = NULL) {
  $string = '';
  if ($desType === true) {
   $description = $description.'<br/>';
  }else{
   $description = ($description) ? '<div class="mdui-textfield-helper">'.$description.'</div>' : NULL;
  }
  $userOption = Castle_Libs::getThemeOptions($name);
  $floatingLabel = ($userOption == "") ? " mdui-textfield-floating-label" : NULL;
  $string .= '<div class="mdui-textfield'.$floatingLabel.'">';
  $string .= '<label class="mdui-textfield-label">'.$display.'</label>';
  $string .= '<input class="mdui-textfield-input" type="text" name="'.$name.'" value="'.htmlspecialchars($userOption).'" />';
  $string .= $description;
  $string .= '</div>';

  $$name = new Typecho_Widget_Helper_Form_Element_Text($name, NULL, $default, $display, $description);
  $this->form->addInput($$name);
  return $string;
 }

 /**
  * Radio
  */
 public function radio($name, $display = NULL, $description = NULL, $options, $default = NULL) {
  $string = '';
  $string .= ($description !== NULL) ? $description . "<br>" : NULL;
  $userOption = Castle_Libs::getThemeOptions($name);
  if ($userOption === NULL) {
   $userOption = $default;
  }
  $string .= '<ul style="list-style: none!important">';
  foreach ($options as $id => $value) {
   $check = ($id == $userOption) ? "checked" : NULL;
   $string .= '<li><label class="mdui-radio">
            <input type="radio" name="'.$name.'" value="'.$id.'" '.$check.'/><i class="mdui-radio-icon"></i>'.$value.'</label></li>';
            $options[$id] = _t($value);
  }
  $string .= "</ul>";
  $$name = new Typecho_Widget_Helper_Form_Element_Radio($name, $options, $default, _t($display), _t($description));
  $this->form->addInput($$name);
  return $string;
 }

 /**
  * Checkbox
  */
 public function checkbox($name, $display = NULL, $description = NULL, $options, $default = NULL) {
  $string = "";
  $userOptions = Castle_Libs::getThemeOptions($name);
  $string .= '<ul style="list-style: none!important">';
  foreach ($options as $option => $value) {
   $checked = "";
   if ($userOptions !== null && in_array($option, $userOptions)) $checked = "checked";
   $string .= '<li><label class="mdui-checkbox"><input type="checkbox" name="' . $name . '[]" value="' . $option . '" ' . $checked . '/><i class="mdui-checkbox-icon"></i>' . $value . '</label></li>';
  }
  $string .= "</ul>";
  $$name = new Typecho_Widget_Helper_Form_Element_Checkbox($name, $options, $default, _t($display), _t($description));
  $this->form->addInput($$name->multiMode());
  return $string;
 }

 /**
  * Textarea
  */
 public function textarea($name, $display = NULL, $description = NULL, $default = NULL, $rows = NULL) {
  $string = "";
  $rows = ($rows) ? ' rows="'.$rows.'" ' : NULL;
  $userOption = Castle_Libs::getThemeOptions($name);
  $description = ($description) ? '<div class="mdui-textfield-helper">'.$description.'</div>' : NULL;
  $floatingLabel = ($userOption == "") ? " mdui-textfield-floating-label" : NULL;
  $string .= '<div class="mdui-textfield"><label class="mdui-textfield-label">' . $display .'</label><textarea class="mdui-textfield-input" type="text" name="' . $name . '"'.$rows.'/>' . htmlspecialchars($userOption) . '</textarea>'.$description.'</div>';
  $$name = new Typecho_Widget_Helper_Form_Element_Textarea($name, null, _t($default), _t($display), _t($description));
  $this->form->addInput($$name);
  return $string;
 }

 /**
  * Select
  */
 public function select($name, $display = NULL, $description = NULL, $options, $default = NULL) {
  $string = '';
  $string .= ($description !== NULL) ? $description . "<br>" : NULL;
  $userOption = Castle_Libs::getThemeOptions($name);
  if ($userOption === NULL) {
   $userOption = $default;
  }

  $string .= '<select class="mdui-select" name="'.$name.'" mdui-select="{position: \'bottom\'}">';
  foreach ($options as $id => $value) {
   $check = ($id == $userOption) ? ' selected="true"': NULL;
   $string .= '<option value="'.$id.'"'.$check.'>'.$value.'</option>';
  }
  $string .= "</select>";
  $$name = new Typecho_Widget_Helper_Form_Element_Select($name, $options, $default, _t($display), _t($description));
  $this->form->addInput($$name);
  return $string;

 }
}