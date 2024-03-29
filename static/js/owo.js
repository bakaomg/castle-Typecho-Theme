/**
   _____                 _     _        
  / ____|               | |   | |       
 | |        __ _   ___  | |_  | |   ___ 
 | |       / _` | / __| | __| | |  / _ \
 | |____  | (_| | \__ \ | |_  | | |  __/
  \_____|  \__,_| |___/  \__| |_|  \___|
 ----------------------------------------
 * Castle's OwO JavaScript
 * Last Update: 2022/04/22 [0.9.7]
 * Author: ohmyga (https://ohmyga.cn)
 * GitHub: https://github.com/bakaomg/castle-Typecho-Theme/
 * LICENSE: GPL V3 (https://www.gnu.org/licenses/gpl-3.0.html)
 **/

//MDUI JQ
var $$ = mdui.JQ;

/**
 * 表情框
 */
var CastleOwO = {
   toggle: function () {
      if (!$$('#wmd-editarea #text')[0]) { return false; };
      if (!$$('#owoBox')[0]) { this.create(); };

      if ($$('#owoBox').hasClass('moe-owo-open')) {
         this.close();
         return true;
      } else {
         this.open();
         return true;
      }
   },

   //打开表情框
   open: function () {
      if (!$$('#owoBox')[0]) { return false; };
      $$('#owoBox')[0].style.display = 'block';
      $$('body').addClass('mdui-locked');
      $$('#moe-owo-overlay')[0].style.display = 'block';

      setTimeout(function () {
         $$('#owoBox')[0].classList.add('moe-owo-open');
         $$('#moe-owo-overlay')[0].classList.add('moe-owo-overlay-open');
      }, 10);
   },

   //关闭表情框
   close: function () {
      if (!$$('#owoBox')[0]) { return false; };
      $$('#moe-owo-overlay')[0].classList.remove('moe-owo-overlay-open');
      $$('#owoBox')[0].classList.remove('moe-owo-open');

      setTimeout(function () {
         $$('#owoBox')[0].style.display = 'none';
         $$('#moe-owo-overlay')[0].style.display = 'none';
         $$('body').removeClass('mdui-locked');
      }, 310);
   },

   //生成表情框
   create: function () {
      //如果表情框存在
      if ($$('#owoBox')[0]) { return false; };

      //暂存变量
      var owoTmps = { owo: '', tab: '' };

      //创建一个容器
      var owoBox = document.createElement("div");
      owoBox.style.display = 'none';
      owoBox.setAttribute('id', 'owoBox');
      owoBox.classList.add('mdui-shadow-10');

      //表情框头部
      owoBox.innerHTML += '<header class="moe-owo-header">\
   <div class="moe-owo-header-title"><i class="mdui-icon material-icons">tag_faces</i></div>\
   <button class="mdui-btn mdui-btn-icon" onclick="CastleOwO.toggle();"><i class="mdui-icon material-icons">close</i></button>\
  </div>';

      //表情列表
      var owoList = CastleConfig.setting.owoList;

      for (let owoNum = 0; owoNum < owoList.length; ++owoNum) {
         //如果为文字表情
         if (owoList[owoNum].type == 'text') {
            owoTmps.owo += '<div id="' + owoList[owoNum].id + '" class="mdui-p-a-2">';

            //如果有表情
            if (owoList[owoNum].content) {
               for (let i = 0; i < owoList[owoNum].content.length; ++i) {
                  owoTmps.owo += '<a data-owo="' + owoList[owoNum].content[i].text + '" class="moe-owo-text-btn mdui-btn mdui-shadow-2" no-go no-pgo no-pjax>' + owoList[owoNum].content[i].text + '</a>';
               }
            } else {
               //如果什么都没有
               owoTmps.owo += '<div class="moe-owo-main-error">此表情包下并没有任何表情..</div>';
            };

            owoTmps.owo += '</div>';
            //加上tab
            owoTmps.tab += '<a href="#' + owoList[owoNum].id + '" class="mdui-ripple" no-pgo no-go>' + owoList[owoNum].name + '</a>';
         };

         /* =============================================================== */
         //如果为Emoji
         if (owoList[owoNum].type == 'emoji') {
            owoTmps.owo += '<div id="' + owoList[owoNum].id + '" class="mdui-p-a-2">';

            //如果有表情
            if (owoList[owoNum].content) {
               for (let i = 0; i < owoList[owoNum].content.length; ++i) {
                  owoTmps.owo += '<a data-owo="' + owoList[owoNum].content[i].text + '" class="moe-owo-emoji-btn mdui-btn mdui-shadow-2" no-pgo no-go no-pjax>' + owoList[owoNum].content[i].text + '</a>';
               }
            } else {
               //如果什么都没有
               owoTmps.owo += '<div class="moe-owo-main-error">此表情包下并没有任何表情..</div>';
            };

            owoTmps.owo += '</div>';
            //加上tab
            owoTmps.tab += '<a href="#' + owoList[owoNum].id + '" class="mdui-ripple" no-pgo no-go>' + owoList[owoNum].name + '</a>';
         };

         /* =============================================================== */
         //如果为小表情
         if (owoList[owoNum].type == 'smallPicture') {
            owoTmps.owo += '<div id="' + owoList[owoNum].id + '" class="mdui-p-a-2">';

            //如果有表情
            if (owoList[owoNum].content) {
               for (let i = 0; i < owoList[owoNum].content.length; ++i) {
                  owoTmps.owo += '<a data-owo="' + owoList[owoNum].content[i].data + '" class="moe-owo-smallPicture-btn mdui-btn mdui-shadow-2" no-pgo no-go no-pjax>\
       <img src="'+ owoList[owoNum].dir + owoList[owoNum].content[i].file + '" />\
      </a>';
               }
            } else {
               //如果什么都没有
               owoTmps.owo += '<div class="moe-owo-main-error">此表情包下并没有任何表情..</div>';
            };

            owoTmps.owo += '</div>';
            //加上tab
            owoTmps.tab += '<a href="#' + owoList[owoNum].id + '" class="mdui-ripple" no-pgo no-go>' + owoList[owoNum].name + '</a>';
         };

         /* =============================================================== */
         //如果为普通表情
         if (owoList[owoNum].type == 'picture') {
            owoTmps.owo += '<div id="' + owoList[owoNum].id + '" class="mdui-p-a-2">';

            //如果有表情
            if (owoList[owoNum].content) {
               for (let i = 0; i < owoList[owoNum].content.length; ++i) {
                  owoTmps.owo += '<a data-owo="' + owoList[owoNum].content[i].data + '" class="moe-owo-picture-btn mdui-btn mdui-shadow-2" no-pgo no-go no-pjax>\
       <img src="'+ owoList[owoNum].dir + owoList[owoNum].content[i].file + '" />\
      </a>';
               }
            } else {
               //如果什么都没有
               owoTmps.owo += '<div class="moe-owo-main-error">此表情包下并没有任何表情..</div>';
            };

            owoTmps.owo += '</div>';
            //加上tab
            owoTmps.tab += '<a href="#' + owoList[owoNum].id + '" class="mdui-ripple" no-pgo no-go>' + owoList[owoNum].name + '</a>';
         };

      };

      //表情框主容器
      owoBox.innerHTML += '<main class="moe-owo-main mdui-dialog-content" >' + owoTmps.owo + '</main>';
      //表情框TAB
      owoBox.innerHTML += '<footer class="moe-owo-footer-tab">\
   <div class="mdui-tab mdui-tab-full-width" id="OwO-tab" mdui-tab>\
    '+ owoTmps.tab + '\
   </div>\
  </footer>';

      $$('body').append(owoBox);
      mdui.mutation($$('#owoBox'));

      //绑定表情
      this.bindOwO();

      //创建遮罩
      var owoOverlay = document.createElement("div");
      owoOverlay.style.display = 'none';
      owoOverlay.setAttribute('id', 'moe-owo-overlay');
      owoOverlay.onclick = function () { CastleOwO.toggle(); };
      $$('body').append(owoOverlay);
   },

   //表情按钮绑定
   bindOwO: function () {
      if (!$$('#owoBox main.moe-owo-main a')[0]) { return false; };
      for (let owoNum = 0; owoNum < $$('#owoBox main.moe-owo-main a').length; ++owoNum) {
         if ($$('#owoBox main.moe-owo-main a')[owoNum].dataset.owo) {
            $$('#owoBox main.moe-owo-main a')[owoNum].onclick = function () {
               CastleOwO.grin($$('#owoBox main.moe-owo-main a')[owoNum].dataset.owo);
               CastleOwO.toggle();
            }
         }
      }
   },

   grin: function (tag) {
      tag = ' ' + tag + ' '; myField = $$('#wmd-editarea #text')[0];
      document.selection ? (myField.focus(), sel = document.selection.createRange(), sel.text = tag, myField.focus()) : this.insertTag(tag);
   },

   insertTag: function (tag) {
      myField = $$('#wmd-editarea #text')[0];
      myField.selectionStart || myField.selectionStart == "0" ? (
         startPos = myField.selectionStart,
         endPos = myField.selectionEnd,
         cursorPos = startPos,
         myField.value = myField.value.substring(0, startPos) + tag + myField.value.substring(endPos, myField.value.length),
         cursorPos += tag.length,
         myField.focus(),
         myField.selectionStart = cursorPos,
         myField.selectionEnd = cursorPos
      ) : (
            myField.value += tag,
            myField.focus()
         );
   },

   addOwOBtn: function () {
      var editorBar = $$('#wmd-button-row');
      if (!editorBar[0]) { return false; };
      editorBar.append('<li class="wmd-spacer wmd-spacer1" id="wmd-spacer6"></li>' +
         '<li class="wmd-button" id="wmd-owo-button" style="margin-top: -3px;" title="插入表情" onclick="CastleOwO.toggle();"><i class="mdui-icon material-icons" style="width: 20px;height: 20px;font-size: 20px;font-weight: bolder;color: rgba(66,66,66,0.8)">sentiment_very_satisfied</i></li>');
   }
};
