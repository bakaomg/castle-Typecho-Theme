<?php
/**
 * Castle AntiSpam Class
 * Last Update: 2020/01/26
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class TypechoAntiSpam extends Widget_Abstract_Contents {
 public function __construct() {
  Typecho_Widget::widget('Widget_Init');
  Typecho_Widget::widget('Widget_Options')->to($options);
  Widget_Abstract::__construct($options->request, $options->response);
 }

 /**
  * 获取反垃圾规则
  */  
 public function AntiSpam() {
  echo "(function () {
    var event = document.addEventListener ? {
        add: 'addEventListener',
        triggers: ['scroll', 'mousemove', 'keyup', 'touchstart'],
        load: 'DOMContentLoaded'
    } : {
        add: 'attachEvent',
        triggers: ['onfocus', 'onmousemove', 'onkeyup', 'ontouchstart'],
        load: 'onload'
    }, added = false;
    document[event.add](event.load, function () {
        var commentID = $$('.respondID').attr('id');
        var r = document.getElementById(commentID),
            input = document.createElement('input');
        input.type = 'hidden';
        input.name = '_';
        input.value = " . Typecho_Common::shuffleScriptVar(
            $this->security->getToken($this->request->getRequestUrl())) . "
        if (null != r) {
            var forms = r.getElementsByTagName('form');
            if (forms.length > 0) {
                function append() {
                    if (!added) {
                        forms[0].appendChild(input);
                        added = true;
                    }
                }
            
                for (var i = 0; i < event.triggers.length; i ++) {
                    var trigger = event.triggers[i];
                    document[event.add](trigger, append);
                    window[event.add](trigger, append);
                }
            }
        }
    });
  })();";
 }
}