/**
   _____                 _     _        
  / ____|               | |   | |       
 | |        __ _   ___  | |_  | |   ___ 
 | |       / _` | / __| | __| | |  / _ \
 | |____  | (_| | \__ \ | |_  | | |  __/
  \_____|  \__,_| |___/  \__| |_|  \___|
 ----------------------------------------
 * Castle's Theme Setting JavaScript
 * Last Update: 2021/04/12 [0.9.6]
 * Author: ohmyga (https://ohmyga.cn)
 * GitHub: https://github.com/bakaomg/castle-Typecho-Theme/
 * LICENSE: GPL V3 (https://www.gnu.org/licenses/gpl-3.0.html)
 **/
/* 偷偷用 MDUI 的 JQ 库应该没人看吧（小声 */
var $$ = mdui.JQ;

var CastleSettingData = {};

$$("body").prepend('<div id="moe-bg" style="background-image: url(\'' + CastleConfig.bgurl + '\')">');

var CastleLinkPanel = {
   toggle: function () {
      if ($$('#moe-theme-panel #moe-theme-panel-menu').hasClass('moe-menu-open')) {
         //如果已经开启
         this.close();
      } else {
         //如果没开启
         this.open();
      }
   },

   open: function () {
      $$('#moe-theme-panel .moe-quq').attr('src', CastleConfig.quq.open);
      $$('#moe-theme-panel #moe-theme-panel-menu')[0].style.display = 'block';
      setTimeout(function () {
         $$('#moe-theme-panel #moe-theme-panel-menu').addClass('moe-menu-open');
      }, 10);
   },

   close: function () {
      $$('#moe-theme-panel .moe-quq').attr('src', CastleConfig.quq.close);
      $$('#moe-theme-panel #moe-theme-panel-menu').removeClass('moe-menu-open');
      setTimeout(function () {
         $$('#moe-theme-panel #moe-theme-panel-menu')[0].style.display = 'none';
      }, 310);
   }
};

var CastlePanel = {
   open: function () {
      for (let i = 0; i < $$('.mdui-panel').length; ++i) {
         new mdui.Panel($$('.mdui-panel')[i]).openAll();
      }
   },

   close: function () {
      for (let i = 0; i < $$('.mdui-panel').length; ++i) {
         new mdui.Panel($$('.mdui-panel')[i]).closeAll();
      }
   },

   updateLog: function () {
      if ($$(".update-log-dialog")[0] != undefined) {
         CastleSettingData.updateDialog.open();
         return false;
      };
      CastleSettingData.updateDialog = mdui.dialog({
         title: "更新日志",
         modal: true,
         content: '<div class="update-log-loading">获取中...</div>',
         cssClass: "update-log-dialog",
         onOpen: function (int) {
            CastleUpdate.log();
         },
         buttons: [{
            text: "关闭",
            close: true
         }],
         destroyOnClosed: false
      })
   },

   updateLogPanel: function (data) {
      var res = '<div class="mdui-panel mdui-panel-gapless" mdui-panel>';

      data.forEach(function (item, key) {
         let open = (CastleConfig.version == item.version) ? " mdui-panel-item-open" : (key === 0) ? " mdui-panel-item-open" : "";

         var verText = (key === 0) ? "[latest]" : "";
         verText += (CastleConfig.version == item.version) ? "[current]" : "";
         verText += (verText != "") ? " " : "";
         let verID = "ver-" + item.version.replace(/\./g, "_",);

         res += '<div class="mdui-panel-item' + open + '" id="' + verID + '">\
           <div class="mdui-panel-item-header">\
            <div class="mdui-panel-item-title">' + verText + item.version + '</div>\
            <div class="mdui-panel-item-summary">' + item.time + '</div>\
            <i class="mdui-panel-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>\
           </div>\
           <div class="mdui-panel-item-body mdui-typo">' + item.changelog + '</div>\
         </div>';
      });

      res += '</div>';

      return res;
   }
};

var CastleUpdate = {
   AJAXGet: function () {
      if (!$$('#update-msg')[0]) { return false; }

      $$.ajax({
         method: 'POST',
         url: 'https://api.baka.show/themeUpdate/',
         data: 'data=' + $$('#update-data').data('up'),
         success: function (data) {
            var data = JSON.parse(data);
            if (data.status == 'ok') {
               $$('#update-msg').html(data.message);
               if (data.announcement.has) {
                  $$('#update-msg')[0].innerHTML += '<br/>' + data.announcement.message;
               }
            }
         },
         error: function (xhr, status, error) {
            $$('#update-msg').html('<span class="mdui-text-color-red-accent">API 发生错误 [HTTP' + xhr.status + ']，无法获取更新信息。</span>');
         }
      });
   },

   log: function () {
      function goToLog() {
         let verID = "ver-" + CastleConfig.version.replace(/\./g, "_",);
         if ($$(".update-log-dialog .mdui-dialog-content #" + verID)[0] != undefined) {
            setTimeout(function () { $$(".update-log-dialog .mdui-dialog-content")[0].scrollTo(0, $$(".update-log-dialog .mdui-dialog-content #" + verID)[0].offsetTop - 60); }, 10);
         }
      };

      if (CastleSettingData.changelog != undefined) {
         if ($$(".update-log-dialog .mdui-dialog-content")[0] == undefined) {
            $$(".update-log-dialog .mdui-dialog-content")[0].innerHTML = "";
            $$(".update-log-dialog .mdui-dialog-content")[0].innerHTML = CastlePanel.updateLogPanel(CastleSettingData.changelog);
            mdui.mutation();
         }
         goToLog();
         return false;
      }
      $$.ajax({
         method: 'GET',
         url: 'https://api.baka.show/themeUpdate/?action=log',
         success: function (data) {
            var data = JSON.parse(data);
            if (data.status == 'ok') {
               CastleSettingData.changelog = data.data;
               $$(".update-log-dialog .mdui-dialog-content")[0].innerHTML = "";
               $$(".update-log-dialog .mdui-dialog-content")[0].innerHTML = CastlePanel.updateLogPanel(CastleSettingData.changelog);
               mdui.mutation();
               goToLog();
            }
         }
      });
   }
};

$$("body").prepend('<div id="moe-nav" style="height:46px;width:100%;display:none;"></div>');

/* scroll事件 */
document.onscroll = function () {
   var h = document.documentElement.scrollTop || document.body.scrollTop;
   if (h > 100) {
      $$('.typecho-head-nav').addClass('moe-fixed');
      $$('.typecho-head-nav').addClass('moe-nav-animation');
      $$('#moe-nav').css('display', 'block');
   }

   if (h < 100) {
      $$('#moe-nav').css('display', 'none');
      $$('.typecho-head-nav').removeClass('moe-fixed');
      $$('.typecho-head-nav').removeClass('moe-nav-animation');
   }
}