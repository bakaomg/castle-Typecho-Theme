/**
   _____                 _     _        
  / ____|               | |   | |       
 | |        __ _   ___  | |_  | |   ___ 
 | |       / _` | / __| | __| | |  / _ \
 | |____  | (_| | \__ \ | |_  | | |  __/
  \_____|  \__,_| |___/  \__| |_|  \___|
 ----------------------------------------
 * Castle's Bangumi JavaScript
 * Last Update: 2022/04/22 [0.9.7]
 * Author: ohmyga (https://ohmyga.cn)
 * GitHub: https://github.com/bakaomg/castle-Typecho-Theme/
 * LICENSE: GPL V3 (https://www.gnu.org/licenses/gpl-3.0.html)
 **/

//MDUI JQ
var $$ = mdui.JQ;

var CastleBangumi = {
   bindBtn: function () {
      if (!$$('#bangumi-box')[0]) { return false; }

      $$('.moe-bangumi-load-more button')[0].onclick = function () {
         CastleBangumi.loadMore();
      }
   },

   getlist: function () {
      if (!$$('#bangumi-box')[0]) { return false; }

      var loadBtn = $$('.moe-bangumi-load-more button');
      loadBtn.attr('disabled', 'true');
      loadBtn.html('<i class="mdui-icon material-icons moe-bangumi-loadBtn">autorenew</i>');

      $$.ajax({
         url: CastleConfig.url.index + '/action/castle',
         method: 'GET',
         data: {
            "type": "bangumi",
            "auth": $$('#bangumi-box').data('auth')
         },
         success: function (data) {
            if (/^[\s\uFEFF]+|[\s\uFEFF]+$/g.test(data)) {
               var data = data.replace(/^[\s\uFEFF]+|[\s\uFEFF]+$/g, '');
            }
            var data = JSON.parse(data);
            if (data.status == true) {
               $$('#bangumi-box').data('offset', Number($$('#bangumi-box').data('offset')) + 5);
               if (data.type == 'bilibili') {
                  $$('#bangumi-box')[0].innerHTML += CastleBangumi.BiliHtml(data.data);
               } else if (data.type == 'bgm') {
                  $$('#bangumi-box')[0].innerHTML += CastleBangumi.BGMHtml(data.data);
               }
               setTimeout(function () {
                  $$('.moe-animation-bottom-top-fadein').removeClass('moe-animation-bottom-top-fadein');
               }, 300);
               loadBtn.removeAttr('disabled');
               loadBtn.html('加载更多');
            }
         },
         error: function (xhr, status, error) {
            if (xhr.status == '403') {
               loadBtn.html('获取失败');
               mdui.snackbar({ message: 'Token 有误，请检查服务器时区是否统一', position: 'right-bottom', onOpen: function () { document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400'); } });
            }
         }
      });
   },

   loadMore: function () {
      if (!$$('#bangumi-box')[0]) { return false; }

      var loadBtn = $$('.moe-bangumi-load-more button');
      loadBtn.attr('disabled', 'true');
      loadBtn.html('<i class="mdui-icon material-icons moe-bangumi-loadBtn">autorenew</i>');

      $$.ajax({
         url: CastleConfig.url.index + '/action/castle',
         method: 'GET',
         data: {
            "type": "bangumi",
            "auth": $$('#bangumi-box').data('auth'),
            "offset": $$('#bangumi-box').data('offset')
         },
         success: function (data) {
            if (/^[\s\uFEFF]+|[\s\uFEFF]+$/g.test(data)) {
               var data = data.replace(/^[\s\uFEFF]+|[\s\uFEFF]+$/g, '');
            }
            var data = JSON.parse(data);
            if (data.status == true) {
               $$('#bangumi-box').data('offset', Number($$('#bangumi-box').data('offset')) + 5);
               if (data.type == 'bilibili') {
                  $$('#bangumi-box')[0].innerHTML += CastleBangumi.BiliHtml(data.data);
               } else if (data.type == 'bgm') {
                  $$('#bangumi-box')[0].innerHTML += CastleBangumi.BGMHtml(data.data);
               }
               setTimeout(function () {
                  $$('.moe-animation-bottom-top-fadein').removeClass('moe-animation-bottom-top-fadein');
               }, 300);
               loadBtn.removeAttr('disabled');
               loadBtn.html('加载更多');
            } else {
               $$('.moe-bangumi-load-more button').html('没有了');
            }
         },
         error: function (xhr, status, error) {
            if (xhr.status == '403') {
               loadBtn.html('Token 过期');
               mdui.snackbar({ message: 'Token 已过期，请刷新页面后重试', position: 'right-bottom', onOpen: function () { document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400'); } });
            }
         }
      });
   },

   BiliHtml: function (data) {
      var html = '';
      for (let i = 0; i < data.length; ++i) {
         html += '<div class="moe-bangumi-card mdui-card moe-animation-bottom-top-fadein">' +
            '<div class="moe-bangumi-left">' +
            '<img class="moe-bangumi-cover-pc" src="' + data[i].cover.large + '" referrerpolicy="no-referrer"/>' +
            '<img class="moe-bangumi-cover-pe" src="' + data[i].cover.square + '" referrerpolicy="no-referrer"/>' +
            '</div>' +
            '<div class="moe-bangumi-right">' +
            '<header class="moe-bangumi-header">' +
            '<div class="moe-bangumi-title">' + data[i].name + '</div>' +
            '<div class="moe-bangumi-subtitle">' + data[i].info.type + ' | ' + data[i].info.area + ' | ' + data[i].info.show + '</div>' +
            '</header>' +
            '<main class="moe-bangumi-content">' + data[i].info.evaluate + '</main>' +
            '<footer class="moe-bangumi-footer">' +
            '<a href="' + data[i].url + '" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent moe-bangumi-btn" target="_blank">' +
            '<i class="mdui-icon material-icons">arrow_forward</i> 点击查看' +
            '</a>' +
            '</footer>' +
            '</div>' +
            '</div>';
      }
      return html;
   },

   BGMHtml: function (data) {
      var html = '';
      for (let i = 0; i < data.length; ++i) {
         html += '<div class="moe-bangumi-card mdui-card moe-animation-bottom-top-fadein">' +
            '<div class="moe-bangumi-left">' +
            '<div class="moe-bangumi-cover-pc" style="background-image: url(\'' + data[i].cover.large + '\');"></div>' +
            '<div class="moe-bangumi-cover-pe" style="background-image: url(\'' + data[i].cover.square + '\');"></div>' +
            '</div>' +
            '<div class="moe-bangumi-right">' +
            '<header class="moe-bangumi-header">' +
            '<div class="moe-bangumi-title">' + data[i].name_cn + '</div>' +
            '<div class="moe-bangumi-subtitle">' + data[i].name + '</div>' +
            '</header>' +
            '<main class="moe-bangumi-content"></main>' +
            '<footer class="moe-bangumi-footer">' +
            '<a href="' + data[i].url + '" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-theme-accent moe-bangumi-btn" target="_blank">' +
            '<i class="mdui-icon material-icons">arrow_forward</i> 点击查看' +
            '</a>' +
            '</footer>' +
            '</div>' +
            '</div>';
      }
      return html;
   }
};

function bangumiLoad() {
   CastleBangumi.getlist();
   CastleBangumi.bindBtn();
};