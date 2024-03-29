/**
   _____                 _     _        
  / ____|               | |   | |       
 | |        __ _   ___  | |_  | |   ___ 
 | |       / _` | / __| | __| | |  / _ \
 | |____  | (_| | \__ \ | |_  | | |  __/
  \_____|  \__,_| |___/  \__| |_|  \___|
 ----------------------------------------
 * Castle's JavaScript
 * Last Update: 2022/04/22 [0.9.7]
 * Author: ohmyga (https://ohmyga.cn)
 * GitHub: https://github.com/bakaomg/castle-Typecho-Theme/
 * LICENSE: GPL V3 (https://www.gnu.org/licenses/gpl-3.0.html)
 **/

//MDUI JQ
var $$ = mdui.JQ;

var CastleData = {
  "firstChild": document.body.firstChild,
  "date": new Date(),
  "scrollTop": "",
  "comments": {
    "replyID": ""
  },
  "compositionFlag": true,
  "searchLock": false,
  "lastScrollStopUnix": 0,
};

CastleData.lastScrollStopUnix = Math.round(CastleData.date.getTime() / 1000);

/**
 * 组件生成
 */
var CastleCreate = {
  //背景
  BG: function () {
    var bg = document.createElement("div");
    bg.setAttribute("id", "moe-bg");

    //如果有设置背景
    if (CastleConfig.setting.background.big) {
      bg.style.backgroundImage = "url('" + CastleConfig.setting.background.big + "')";
    };

    $$('body')[0].insertBefore(bg, CastleData.firstChild);

    var style = document.createElement("style");
    style.innerHTML = '';

    //如果有设置背景色
    if (CastleConfig.setting.background.color) {
      style.innerHTML += '#moe-bg{background-color: ' + CastleConfig.setting.background.color + '!important;}';
    };

    //如果有小屏背景
    if (CastleConfig.setting.background.small) {
      style.innerHTML += '@media (max-width: 600px) {#moe-bg{background-image: url(\'' + CastleConfig.setting.background.small + '\')!important;}}';
    };
    $$('head').append(style);
  },

  //Search
  Search: function () {
    var search = document.createElement("div");
    search.setAttribute("id", "search-dialog");
    search.setAttribute("class", "mdui-dialog");
    $$('body').append(search);
  },

  //Header
  Header: function () {
    var id = $$('#header')[0];
    id.classList.add('moe-appbar');
    id.innerHTML = '<div class="mdui-toolbar">\
   <a class="mdui-btn mdui-btn-icon" mdui-drawer="{target: \'#sidebar\', swipe: \'true\', overlay: \'true\'}" no-go><i class="mdui-icon material-icons">&#xe5d2;</i></a>\
   <a href="'+ CastleConfig.url.site + '" class="mdui-typo-title">' + CastleConfig.info.siteName + '</a>\
   <div class="mdui-toolbar-spacer"></div>\
   <a class="mdui-btn mdui-btn-icon moe-device-btn-hidden" id="toolbar-device-btn" mdui-menu="{target: \'#decice-toolbar-list\', align: \'right\'}" no-go><i class="mdui-icon material-icons">&#xe1b1;</i></a>\
   <a class="mdui-btn mdui-btn-icon" mdui-dialog="{target: \'#search-dialog\', history: false, content: CastleSearch.dialog()}" no-go><i class="mdui-icon material-icons">&#xe8b6;</i></a>\
  </div>';
  },

  //Sidebar
  Sidebar: function () {
    if (CLStatus.is === true) { CastleData.login = { tooltip: CastleLang.sidebar.toolbar.logout, onclick: 'CastleLogin.Logout()', icon: 'power_settings_new' }; }
    else { CastleData.login = { tooltip: CastleLang.sidebar.toolbar.login, onclick: 'CastleLogin.panel()', icon: 'account_circle' }; };

    var sidebarToolsBar = '';
    var sidebarToolsBarBox = { "box": "", "has": "" };
    if (CastleConfig.switch.sidebarToolsBar.login) {
      sidebarToolsBar += '<button class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-black mdui-color-grey-100" id="login-btn" mdui-tooltip="{content: \'' + CastleData.login.tooltip + '\', position: \'top\'}" data-loginStatus="' + CLStatus.is + '"><i class="mdui-icon material-icons">' + CastleData.login.icon + '</i></button>';
    }
    if (CastleConfig.switch.sidebarToolsBar.darkBtn) {
      sidebarToolsBar += '<button class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-black mdui-color-grey-100" id="night-btn" mdui-tooltip="{content: \'' + CastleLang.sidebar.toolbar.dark + '\', position: \'top\'}"><i class="mdui-icon material-icons">brightness_4</i></button>';
    }
    if (!CastleConfig.switch.sidebarToolsBar.settingBtn && !CastleConfig.switch.sidebarToolsBar.login && !CastleConfig.switch.sidebarToolsBar.darkBtn) {
      sidebarToolsBarBox.box = '';
      sidebarToolsBarBox.has = '';
    } else {
      sidebarToolsBarBox.has = ' moe-sidebar-toolbar-has';
      sidebarToolsBarBox.box = '<div class="moe-sidebar-toolbar">' + sidebarToolsBar + '</div>';
    };

    var id = $$('#sidebar')[0];
    id.innerHTML = '<div class="moe-sidebar-header" style="background-image: url(\'' + CastleConfig.setting.sidebar.background + '\')">\
   <div class="moe-sidebar-header-headimg" style="background-image: url(\''+ CastleConfig.setting.avatar + '\')"></div>\
   <div class="moe-sidebar-header-siteInfo"><div class="moe-sidebar-header-authorName">'+ CastleConfig.info.author + '</div><div class="moe-sidebar-header-description">' + CastleConfig.info.description + '</div></div>\
  </div>\
  <ul class="mdui-list'+ sidebarToolsBarBox.has + '" mdui-collapse="{accordion: true}">\
   <a href="'+ CastleConfig.url.site + '" class="mdui-list-item mdui-ripple">\
    <i class="mdui-icon material-icons mdui-list-item-icon">home</i>\
    <div class="mdui-list-item-content">'+ CastleLang.sidebar.home + '</div>\
   </a>\
  </ul>\
  '+ sidebarToolsBarBox.box;

    CastleSidebar.menu();

    //为超链接绑定关闭抽屉的事件
    //当点击抽屉内链接时将隐藏抽屉
    var dom = $$('#sidebar ul a');
    for (let i = 0; i < dom.length; ++i) {
      dom[i].onclick = function () {
        new mdui.Drawer('#sidebar').close();
      }
    };

    //为抽屉工具栏按钮绑定事件
    function scriptExec(toolsFuncName) {
      var scr = document.createElement("script");
      scr.innerHTML = toolsFuncName;
      $$('body').append(scr);
      setTimeout(function () {
        $$('body')[0].removeChild(scr);
      }, 10);
      //console.log('ok');
    }
    if ($$('#sidebar .moe-sidebar-toolbar #login-btn')[0]) {
      $$('#sidebar .moe-sidebar-toolbar #login-btn')[0].onclick = function () { scriptExec(CastleData.login.onclick) }
    };
    if ($$('#sidebar .moe-sidebar-toolbar #night-btn')[0]) {
      $$('#sidebar .moe-sidebar-toolbar #night-btn')[0].onclick = function () { scriptExec('CastleNight.toggle()') }
    };
  },

  //Toc Sidebar
  tocSidebar: function () {
    if (!$$('#toc-sidebar')[0]) { return false; };
    if ($$('#toc-sidebar').html() != "") { CastlePostToc.toc(); return true; };

    var tocSidebar = $$('#toc-sidebar');

    tocSidebar[0].innerHTML += '<header class="moe-toc-header mdui-shadow-1">\
   <div class="moe-toc-header-title">'+ CastleLang.toc + '</div>\
  </header>';

    tocSidebar[0].innerHTML += '<main class="moe-toc-main"></main>';

    CastlePostToc.toc();
  },

  //Footer
  Footer: function () {
    var footer = document.createElement("footer");
    footer.setAttribute("id", "footer");
    if (CastleConfig.setting.miibeian.number) {
      var miibeian = '<div class="moe-footer-icp"><a href="' + CastleConfig.setting.miibeian.link + '" target="_blank">' + CastleConfig.setting.miibeian.number + '</a></div>';
    } else {
      var miibeian = '';
    }

    footer.innerHTML = '<main class="moe-footer-box">\
   <div class="moe-footer-top">\
    <div class="moe-footer-copyright">Copyright &copy; '+ CastleData.date.getFullYear() + ' <a href="' + CastleConfig.url.site + '">' + CastleConfig.info.siteName + '</a></div>\
   </div>\
   <div class="moe-footer-bottom">\
    '+ miibeian + '\
    <div class="moe-footer-theme-or-powered">Theme <a href="https://github.com/ohmyga233/castle-Typecho-Theme" target="_blank">Castle</a> By <a href="https://ohmyga.cn/">ohmyga</a> | Powered By <a href="http://typecho.org/" target="_blank">Typecho</a></div>\
   </div>\
  </main>';
    $$('body').append(footer);
  },

  // 创建按钮组
  btnGroup: function () {
    var btnGroup = document.createElement("div");
    btnGroup.setAttribute("id", "btn-group");
    $$('body').append(btnGroup);
  },

  //回到顶部按钮
  gotoTopBtn: function () {
    var topBtn = document.createElement("div");
    topBtn.setAttribute("id", "go-top");
    topBtn.setAttribute('class', 'mdui-fab mdui-fab-fixed mdui-ripple mdui-fab-hide mdui-color-theme');
    topBtn.innerHTML = '<i class="mdui-icon material-icons">&#xe5d8;</i>';
    topBtn.onclick = function () { CastleTop.gotoTop(); };
    $$('#btn-group').append(topBtn);
  },

  //目录树
  tocBtn: function () {
    var tocBtn = document.createElement("div");
    tocBtn.setAttribute("id", "toc-Btn");
    tocBtn.setAttribute("class", "mdui-fab mdui-fab-fixed mdui-ripple mdui-fab-hide");
    if (CastleConfig.setting.toc.color) {
      tocBtn.style.backgroundColor = CastleConfig.setting.toc.color;
    } else {
      tocBtn.classList.add("mdui-color-theme");
    };
    tocBtn.innerHTML = '<i class="mdui-icon material-icons">&#xe866;</i>';
    tocBtn.onclick = function () { CastlePostToc.toggle(); };
    $$('#btn-group').append(tocBtn);
  }
};

/**
 * 侧栏
 */
var CastleSidebar = {
  menu: function () {
    if (!$$('#sidebar')[0]) { return false; };
    if (!CastleConfig.setting.sidebarMenu) { return false; };

    var sidebarMenuBox = '';

    var sidebarMenu = CastleConfig.setting.sidebarMenu;
    for (let countMenu = 0; countMenu < sidebarMenu.length; ++countMenu) {
      //如果为普通按钮
      if (sidebarMenu[countMenu].type == 'button') {
        if (sidebarMenu[countMenu].setting.target) {
          var targetBlank = ' target="_blank"';
        } else {
          var targetBlank = ' target="_self"';
        };

        sidebarMenuBox += '<a href="' + sidebarMenu[countMenu].link + '" class="mdui-list-item mdui-ripple"' + targetBlank + '>\
     <i class="mdui-icon material-icons mdui-list-item-icon">'+ sidebarMenu[countMenu].icon.text + '</i>\
     <div class="mdui-list-item-content">'+ sidebarMenu[countMenu].name + '</div>\
    </a>';
      };

      //如果为列表
      if (sidebarMenu[countMenu].type == 'list') {
        sidebarMenuBox += '<li class="mdui-collapse-item">\
     <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">\
      <i class="mdui-icon material-icons mdui-list-item-icon">'+ sidebarMenu[countMenu].icon.text + '</i>\
      <div class="mdui-list-item-content">'+ sidebarMenu[countMenu].name + '</div>\
      <i class="mdui-icon material-icons mdui-list-item-icon mdui-collapse-item-arrow">keyboard_arrow_down</i>\
     </div>\
     <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">';

        if (sidebarMenu[countMenu].content) {
          for (let i = 0; i < sidebarMenu[countMenu].content.length; ++i) {
            var targetContent = (sidebarMenu[countMenu].content[i].target) ? ' target="_blank"' : '';
            sidebarMenuBox += '<a class="mdui-list-item mdui-ripple" href="' + sidebarMenu[countMenu].content[i].link + '"' + targetContent + '>' + sidebarMenu[countMenu].content[i].name + '</a>';
          }
        };

        sidebarMenuBox += '</ul></li>';
      };

      //如果为归档
      if (sidebarMenu[countMenu].type == 'archives') {
        sidebarMenuBox += '<li class="mdui-collapse-item">\
     <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">\
      <i class="mdui-icon material-icons mdui-list-item-icon">'+ sidebarMenu[countMenu].icon.text + '</i>\
      <div class="mdui-list-item-content">'+ sidebarMenu[countMenu].name + '</div>\
      <i class="mdui-icon material-icons mdui-list-item-icon mdui-collapse-item-arrow">keyboard_arrow_down</i>\
     </div>\
     <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">';

        if (sidebarMenu[countMenu].archives) {
          for (let i = 0; i < sidebarMenu[countMenu].archives.length; ++i) {
            sidebarMenuBox += '<a href="' + sidebarMenu[countMenu].archives[i].link + '" class="mdui-list-item mdui-ripple">';
            sidebarMenuBox += sidebarMenu[countMenu].archives[i].date + ' &nbsp; ';
            if (sidebarMenu[countMenu].setting.number) {
              sidebarMenuBox += '<span class="moe-sidebar-ul-count">' + sidebarMenu[countMenu].archives[i].count + '</span>';
            };
            sidebarMenuBox += '</a>';
          };
        };

        sidebarMenuBox += '</ul></li>';
      };

      //如果为分类
      if (sidebarMenu[countMenu].type == 'category') {
        sidebarMenuBox += '<li class="mdui-collapse-item">\
     <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">\
      <i class="mdui-icon material-icons mdui-list-item-icon">'+ sidebarMenu[countMenu].icon.text + '</i>\
      <div class="mdui-list-item-content">'+ sidebarMenu[countMenu].name + '</div>\
      <i class="mdui-icon material-icons mdui-list-item-icon mdui-collapse-item-arrow">keyboard_arrow_down</i>\
     </div>\
     <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">';

        if (sidebarMenu[countMenu].category) {
          for (let i = 0; i < sidebarMenu[countMenu].category.length; ++i) {
            sidebarMenuBox += '<a href="' + sidebarMenu[countMenu].category[i].link + '" class="mdui-list-item mdui-ripple">';
            sidebarMenuBox += sidebarMenu[countMenu].category[i].name + ' &nbsp; ';
            if (sidebarMenu[countMenu].setting.number) {
              sidebarMenuBox += '<span class="moe-sidebar-ul-count">' + sidebarMenu[countMenu].category[i].count + '</span>';
            };
            sidebarMenuBox += '</a>';
          };
        };

        sidebarMenuBox += '</ul></li>';
      };

      //如果为页面
      if (sidebarMenu[countMenu].type == 'pages') {
        sidebarMenuBox += '<li class="mdui-collapse-item">\
     <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">\
      <i class="mdui-icon material-icons mdui-list-item-icon">'+ sidebarMenu[countMenu].icon.text + '</i>\
      <div class="mdui-list-item-content">'+ sidebarMenu[countMenu].name + '</div>\
      <i class="mdui-icon material-icons mdui-list-item-icon mdui-collapse-item-arrow">keyboard_arrow_down</i>\
     </div>\
     <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">';

        if (sidebarMenu[countMenu].pages) {
          for (let i = 0; i < sidebarMenu[countMenu].pages.length; ++i) {
            sidebarMenuBox += '<a class="mdui-list-item mdui-ripple" href="' + sidebarMenu[countMenu].pages[i].link + '">' + sidebarMenu[countMenu].pages[i].name + '</a>';
          };
        };

        sidebarMenuBox += '</ul></li>';
      };

      //如果为分隔线
      if (sidebarMenu[countMenu].type == 'divider') {
        sidebarMenuBox += '<div class="mdui-divider"></div>';
      };

      //如果为Rss
      if (sidebarMenu[countMenu].type == 'RssLink') {
        if (sidebarMenu[countMenu].setting.target) {
          var targetBlank = ' target="_blank" ';
        } else {
          var targetBlank = ' target="_blank" ';
        };
        sidebarMenuBox += '<a href="' + sidebarMenu[countMenu].RssLink + '"' + targetBlank + 'class="mdui-list-item mdui-ripple">\
     <i class="mdui-icon material-icons mdui-list-item-icon">'+ sidebarMenu[countMenu].icon.text + '</i>\
     <div class="mdui-list-item-content">'+ sidebarMenu[countMenu].name + '</div>\
    </a>';
      };

      //如果为计数
      if (sidebarMenu[countMenu].type == 'TotalPost' || sidebarMenu[countMenu].type == 'TotalComments' || sidebarMenu[countMenu].type == 'TotalPage' || sidebarMenu[countMenu].type == 'TotalCategory' || sidebarMenu[countMenu].type == 'TotalWords') {
        sidebarMenuBox += '<li class="mdui-list-item mdui-ripple">\
     <div class="mdui-list-item-content">'+ sidebarMenu[countMenu].name + '</div>\
     <div class="mdui-list mdui-float-right">\
      <span class="moe-sidebar-TotalCount">'+ sidebarMenu[countMenu].count + '</span>\
     </div>\
    </li>';
      }
    };

    $$('#sidebar ul.mdui-list')[0].innerHTML += sidebarMenuBox;
  }
};

/**
 * 搜索
 */
var CastleSearch = {
  //搜索提交
  submit: function (input) {
    if (input) {
      var input = input;
    } else {
      var input = $$('#search-dialog #searchInput');
    };

    //如果输入框为空
    if (!input.val()) { mdui.snackbar({ message: CastleLang.search.empty, position: 'right-bottom', onOpen: function () { document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400'); } }); return false; };

    new mdui.Dialog('#search-dialog').close(); //关闭搜索框

    if (CastleConfig.switch.pjax) {
      pjax.loadUrl(CastleConfig.url.index + '/search/' + input.val());
    } else {
      window.location.href = CastleConfig.url.index + '/search/' + input.val();
    }
  },

  dialog: function () {
    var dialog = $$('#search-dialog')[0];
    if ($$('#search-dialog').html()) { return; }; //如果已有内容

    var resBox = (CastleConfig.switch.search === true) ? '<div class="moe-search-result mdui-card"><ul class="mdui-list"></ul></div>' : '';

    dialog.innerHTML = '<div class="moe-search-header"><a href="javascript:;" class="mdui-btn mdui-btn-icon" mdui-dialog-close no-go><i class="mdui-icon material-icons">close</i></a></div>\
   <div class="moe-search-content">\
    <div class="moe-search-input">\
     <form onkeydown="if(event.keyCode == 13){CastleSearch.submit(); return false;}">\
      <i class="mdui-icon material-icons">search</i>\
      <input id="searchInput" name="search" placeholder="'+ CastleLang.search.input + '" type="text">\
     </form>\
     ' + resBox + ' \
    </div>\
   </div>';

    if (CastleConfig.switch.search === true) { CastleSearch.on(); }
  },

  //输入框监听
  on: function () {
    $$('#search-dialog #searchInput').one('focus', function (e) {
      $$('#search-dialog .moe-search-content').addClass('moe-search-content-focus');
    });

    $$("#search-dialog #searchInput").on('compositionstart', function (e) {
      CastleData.compositionFlag = false;
    });

    $$("#search-dialog #searchInput").on('compositionend', function (e) {
      CastleData.compositionFlag = true;
    });

    $$('#search-dialog #searchInput').on('input propertychange keyup', function (e) {
      if ($$(this).val() == '' || $$(this).val() == null) {
        $$('#search-dialog .moe-search-result .mdui-list')[0].innerHTML = "";
        return false;
      };
      CastleSearch.search();
    })
  },

  //实时搜索框
  search() {
    if (CastleData.compositionFlag === false || CastleData.searchLock === true) { return false; };
    CastleData.searchLock = true;

    setTimeout(function () {
      if ($$('#search-dialog #searchInput').val() == '' || $$('#search-dialog #searchInput').val() == null) { return false; };
      $$.ajax({
        method: 'POST',
        url: CastleConfig.url.index + '/action/castle?type=search',
        data: $$('#search-dialog .moe-search-content form').serialize(),
        success: function (data) {
          var data = JSON.parse(data);
          CastleSearch.result(data);
          CastleData.searchLock = false;
        },
        error: function (xhr, status, error) {
          CastleData.searchLock = false;
          $$('#search-dialog .moe-search-result .mdui-list')[0].innerHTML = '<div class="search-result-none">发生错误</div>';
        }
      })
    }, 300);
  },

  //展示结果
  result(data) {
    if (data.has === false) {
      $$('#search-dialog .moe-search-result .mdui-list')[0].innerHTML = '<div class="search-result-none">搜索不到相关结果</div>';
      return false;
    };

    var result = "";

    data.data.forEach(function (item, key) {
      result += '<a href="javascript:;" onclick="CastleSearch.searchTo(\'' + item.link + '\')" class="mdui-list-item mdui-ripple" no-go>\
      <div class="mdui-list-item-content">\
       <div class="mdui-list-item-title mdui-list-item-one-line">' + item.title + '</div>\
       <div class="mdui-list-item-text mdui-list-item-two-line">' + item.excerpt + '</div>\
      </div>\
     </a>';
    });

    if (data.data.length == 5) {
      result += '<li class="mdui-list-item mdui-ripple">\
      <div class="mdui-list-item-content">\
       <div class="mdui-list-item-title mdui-list-item-one-line" style="font-weight: bold;">更多结果请直接回车搜索</div>\
      </div>\
     </li>';
    };

    $$('#search-dialog .moe-search-result .mdui-list')[0].innerHTML = result;
  },

  searchTo(link) {
    new mdui.Dialog('#search-dialog').close(); //关闭搜索框

    if (CastleConfig.switch.pjax) {
      pjax.loadUrl(link);
    } else {
      window.location.href = link;
    }
  }
};

/**
 * 夜间模式
 */
var CastleNight = {
  check: function () {
    //暗色
    function dark() {
      $$('body')[0].classList.add('mdui-theme-layout-dark');

      //判断是否开启侧栏按钮
      if (CastleConfig.switch.sidebarToolsBar.darkBtn) {
        window.onload = function () {
          var btn = $$('#night-btn')[0];
          btn.classList.add('moe-night-btn-rotate360');
          $$('#night-btn i')[0].innerHTML = 'brightness_high';
          $$('#night-btn').attr('mdui-tooltip', "{content: '" + CastleLang.sidebar.toolbar.light + "', position: 'top'}");
        }
      }
    };

    //亮色
    function light() {
      $$('body')[0].classList.remove('mdui-theme-layout-dark');

      //判断是否开启侧栏按钮
      if (CastleConfig.switch.sidebarToolsBar.darkBtn) {
        window.onload = function () {
          var btn = $$('#night-btn')[0];
          btn.classList.remove('moe-night-btn-rotate360');
          $$('#night-btn i')[0].innerHTML = 'brightness_4';
          $$('#night-btn').attr('mdui-tooltip', "{content: '" + CastleLang.sidebar.toolbar.dark + "', position: 'top'}");
        }
      }
    };

    //如果用户自行设置
    if (CastleLibs.getCookie('nightSwitch')) {
      //console.log('用户自行设置，nightSwitch ['+CastleLibs.getCookie('nightSwitch')+']');
      //如果 Cookie 中有夜间模式的设置并为 [true]
      if (CastleLibs.getCookie('nightSwitch') == 'true') {
        dark();
      };

      //如果 Cookie 中有夜间模式的设置并为 [false]
      if (CastleLibs.getCookie('nightSwitch') == 'false') {
        light();
      };
      return false;
    };

    //如果为跟随时间
    if (CastleConfig.switch.dark.follow) {
      var hour_now = CastleData.date.getHours();
      if (hour_now >= CastleConfig.switch.dark.DarkTimeFrom || hour_now <= CastleConfig.switch.dark.DarkTimeTo) {
        dark();
      };
      return false;
    };

    //如果为开启跟随
    if (CastleConfig.switch.dark.scheme) {
      var schemeGeter = window.matchMedia("(prefers-color-scheme: dark)");
      schemeGeter.addListener(function (scheme) {
        if (scheme.matches) {
          dark();
          //console.log('跟随暗色');
        } else if (window.matchMedia("(prefers-color-scheme: light)").matches) {
          light();
          //console.log('跟随亮色');
        }
      });

      if (schemeGeter.matches) {
        dark();
        return false;
      }
    };

    //默认设置
    if (CastleConfig.switch.dark.default == 'dark') {
      dark();
      return false;
    } else if (CastleConfig.switch.dark.default == 'light') {
      light();
      return false;
    }
  },

  toggle: function () {
    var status = $$('body').hasClass('mdui-theme-layout-dark');
    if (status) { this.close(true); } else { this.open(true); };
    setTimeout(function () { CastlePost.deviceQR(true); }, 400);
  },

  open: function (toggle) {
    var id = $$('body')[0];
    if ($$('body').hasClass('mdui-theme-layout-dark') && !toggle) {
      mdui.snackbar({ message: CastleLang.sidebar.dark.dark_enabled, position: 'right-bottom', onOpen: function () { var snackbar = document.querySelector('.mdui-snackbar'); snackbar.classList.add('mdui-color-blue-600'); } });
      return false;
    }

    //如果开启了侧栏按钮
    if (CastleConfig.switch.sidebarToolsBar.darkBtn) {
      var btn = $$('#night-btn')[0];
      $$('#night-btn').attr('disabled', true); //禁用按钮
      btn.classList.add('moe-night-btn-rotate360'); //图标旋转
      $$('#night-btn').attr('mdui-tooltip', ""); //修改工具提示
    };

    CastleLibs.setCookie('nightSwitch', true, 30, '/'); //设置 Cookie
    new mdui.Tooltip('#sidebar .moe-sidebar-toolbar #night-btn').close();
    setTimeout(function () {
      id.classList.add('mdui-theme-layout-dark'); //向 body 添加 class [mdui-theme-layout-dark]
      mdui.snackbar({ message: CastleLang.sidebar.dark.light, position: 'right-bottom', onOpen: function () { var snackbar = document.querySelector('.mdui-snackbar'); snackbar.classList.add('mdui-color-blue-600'); } }); //弹出切换成功消息

      //如果开启了侧栏按钮
      if (CastleConfig.switch.sidebarToolsBar.darkBtn) {
        $$('#night-btn').removeAttr("disabled"); //取消按钮禁用状态
        $$('#night-btn').attr('mdui-tooltip', "{content: '" + CastleLang.sidebar.toolbar.light + "', position: 'top'}"); //修改工具提示
      }
    }, 310);
    setTimeout(function () {
      if (CastleConfig.switch.sidebarToolsBar.darkBtn) {
        $$('#night-btn i')[0].innerHTML = 'brightness_high'; //修改按钮图标
      }
    }, 330);
    setTimeout(function () {
      if (CastleConfig.switch.sidebarToolsBar.darkBtn) {
        new mdui.Drawer('#sidebar').close(); //关闭抽屉
      }
    }, 400);
  },

  close: function (toggle) {
    var id = $$('body')[0];
    if ($$('body').hasClass('mdui-theme-layout-dark') && !toggle) {
      mdui.snackbar({ message: CastleLang.sidebar.dark.light_enabled, position: 'right-bottom', onOpen: function () { var snackbar = document.querySelector('.mdui-snackbar'); snackbar.classList.add('mdui-color-blue-600'); } });
      return false;
    }

    //如果开启了侧栏按钮
    if (CastleConfig.switch.sidebarToolsBar.darkBtn) {
      var btn = $$('#night-btn')[0];
      $$('#night-btn').attr('disabled', true); //禁用按钮
      btn.classList.remove('moe-night-btn-rotate360'); //去掉图标旋转
      $$('#night-btn').attr('mdui-tooltip', ""); //修改工具提示
    };

    CastleLibs.setCookie('nightSwitch', false, false, '/'); //设置 Cookie
    new mdui.Tooltip('#sidebar .moe-sidebar-toolbar #night-btn').close();
    setTimeout(function () {
      id.classList.remove('mdui-theme-layout-dark'); //去掉 body 的 class [mdui-theme-layout-dark]
      mdui.snackbar({ message: CastleLang.sidebar.dark.dark, position: 'right-bottom' }); //弹出切换成功消息

      //如果开启了侧栏按钮
      if (CastleConfig.switch.sidebarToolsBar.darkBtn) {
        $$('#night-btn').removeAttr("disabled"); //取消按钮禁用状态
        $$('#night-btn').attr('mdui-tooltip', "{content: '" + CastleLang.sidebar.toolbar.dark + "', position: 'top'}"); //修改工具提示
      }
    }, 310);
    setTimeout(function () {
      if (CastleConfig.switch.sidebarToolsBar.darkBtn) {
        $$('#night-btn i')[0].innerHTML = 'brightness_4'; //修改按钮图标
      }
    }, 330);
    setTimeout(function () {
      if (CastleConfig.switch.sidebarToolsBar.darkBtn) {
        new mdui.Drawer('#sidebar').close(); //关闭抽屉
      }
    }, 400);
  }
};

/**
 * 登陆面板
 */
var CastleLogin = {
  panel: function () {
    //判断功能是否启用
    if (!CastleConfig.switch.sidebarToolsBar.login) { mdui.alert('别试了，并没有启用前台登录功能 (￣_￣|||)', '提示'); return false; };

    //关闭抽屉[不然有奇怪的 BUG ]
    new mdui.Drawer('#sidebar').close();

    if ($$('#login-btn').data('loginStatus') == 'true') { mdui.alert(CastleLang.sidebar.login.login.logined, CastleLang.tips.tips); return false; };

    var loginStyle = '';
    if (CastleConfig.setting.login.background) {
      loginStyle += 'background-image: url(\'' + CastleConfig.setting.login.background + '\');';
    };
    if (CastleConfig.setting.login.backgroundColor) {
      loginStyle += 'background-color: ' + CastleConfig.setting.login.background + ';';
    };

    //对话框内容
    var content = '<div class="moe-login-header" style="' + loginStyle + '">\
   <a href="javascript:;" class="mdui-btn mdui-btn-icon" mdui-dialog-close><i class="mdui-icon material-icons">close</i></a>\
   <div class="moe-login-header-title">'+ CastleLang.sidebar.login.login.title + '</div>\
  </div>\
  <div class="moe-login-content">\
   <form id="loginForm" onkeydown="if(event.keyCode == 13){return false;}">\
    <div class="mdui-textfield mdui-textfield-floating-label">\
     <label class="mdui-textfield-label">'+ CastleLang.sidebar.login.login.user + '</label>\
     <input class="mdui-textfield-input" type="text" id="name" name="name" required/>\
     <div class="mdui-textfield-error">'+ CastleLang.sidebar.login.login.wrongUser + '</div>\
    </div>\
    <div class="mdui-textfield mdui-textfield-floating-label">\
     <label class="mdui-textfield-label">'+ CastleLang.sidebar.login.login.password + '</label>\
     <input class="mdui-textfield-input" type="password" id="password" name="password" required/>\
     <div class="mdui-textfield-error">'+ CastleLang.sidebar.login.login.wrongPass + '</div>\
    </div>\
    <label class="mdui-checkbox">\
     <input type="checkbox" name="remember" value="1" id="remember">\
     <i class="mdui-checkbox-icon"></i>\
     '+ CastleLang.sidebar.login.login.remember + '\
    </label>\
    <div class="moe-login-submit">\
     <button class="mdui-btn mdui-btn-icon moe-login-loadBtn" type="button" disabled><i class="mdui-icon material-icons">autorenew</i></button>\
     <button class="mdui-btn mdui-btn-raised mdui-color-theme moe-login-submitBtn" type="button" onclick="CastleLogin.loginSubmit()">'+ CastleLang.sidebar.login.login.submit + '</button>\
    </div>\
   </form>\
  </div>';

    //创建对话框
    mdui.dialog({
      content: content,
      modal: true,
      history: false,
      closeOnEsc: false,
      cssClass: 'moe-login mdui-shadow-10',
      onOpen: function (init) { $$('.moe-login').attr('id', 'moe-login'); CastleData.LoginDialog = init }
    });
  },

  //登陆提交
  loginSubmit: function () {
    if (!CastleConfig.switch.sidebarToolsBar.login) { mdui.alert('别试了，并没有启用前台登录功能 (￣_￣|||)', '提示'); return false; };
    var username = $$('#loginForm #name').val();
    var password = $$('#loginForm #password').val();
    if (!username || !password) { return false; }

    var loadBtn = $$('#loginForm .moe-login-submit .moe-login-loadBtn');
    var submitBtn = $$('#loginForm .moe-login-submit .moe-login-submitBtn');
    submitBtn.attr('disabled', 'true');
    loadBtn[0].classList.add('moe-login-loadBtn-display');

    $$.ajax({
      method: 'POST',
      url: CastleConfig.url.login,
      data: $$('#loginForm').serialize(),
      success: function (data) {
        var data = JSON.parse(data);
        if (data.status == 'error' && data.status != 'ok') {
          submitBtn.removeAttr("disabled");
          loadBtn[0].classList.remove('moe-login-loadBtn-display');
          mdui.snackbar({ message: data.error, position: 'right-bottom', onOpen: function () { document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400'); } });
        } else if (data.status == 'ok') {
          $$('#login-btn').attr('data-loginStatus', "true");
          $$('#login-btn').attr('onclick', "CastleLogin.Logout()");
          $$('#login-btn').attr('mdui-tooltip', "{content: '" + CastleLang.sidebar.toolbar.logout + "', position: 'top'}");
          $$('#login-btn i')[0].innerHTML = 'power_settings_new';
          CastleData.LoginDialog.close();
          loadBtn[0].classList.remove('moe-login-loadBtn-display');
          if (data.loginStatus === true) { data.msg = CastleLang.sidebar.login.login.success; data.color = 'mdui-color-green-600'; if (CastleConfig.switch.pjax) { pjax.loadUrl(window.location.href); } else { CastleLibs.reload(); } } else { data.msg = CastleLang.sidebar.login.login.logined; data.color = 'mdui-color-red-400'; }
          mdui.snackbar({ message: data.msg, position: 'right-bottom', onOpen: function () { document.querySelector('.mdui-snackbar').classList.add(data.color); } });
        } else {
          submitBtn.removeAttr("disabled");
          loadBtn[0].classList.remove('moe-login-loadBtn-display');
          mdui.snackbar({ message: CastleLang.tips.unknown, position: 'right-bottom', onOpen: function () { document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400'); } });
        }
      },
      error: function (xhr, status, error) {
        mdui.snackbar({ message: CastleLang.tips.error + '（HTTP ' + xhr.status + '）', position: 'right-bottom', onOpen: function () { document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400'); } });
        submitBtn.removeAttr("disabled");
        loadBtn[0].classList.remove('moe-login-loadBtn-display');
      }
    });
  },

  Logout: function () {
    if (!CastleConfig.switch.sidebarToolsBar.login) { mdui.alert('别试了，并没有启用前台登录功能 (￣_￣|||)', '提示'); return false; };

    //关闭抽屉[不然有奇怪的 BUG ]
    new mdui.Drawer('#sidebar').close();

    var LoginBtn = $$('#login-btn');
    LoginBtn.attr('disabled', 'true');

    $$.ajax({
      method: 'GET',
      url: CastleConfig.url.logout,
      success: function (data) {
        var data = JSON.parse(data);
        if (data.status == 'ok' && data.logout === true) {
          mdui.alert(CastleLang.sidebar.login.logout.content.logout, CastleLang.sidebar.login.logout.title, function () {
            if (CastleConfig.switch.pjax) { pjax.loadUrl(window.location.href); } else { CastleLibs.reload(); }
          });
          LoginBtn.attr('data-loginStatus', "false");
        } else {
          mdui.alert(data.msg, CastleLang.sidebar.login.logout.title);
        }
        LoginBtn.removeAttr('disabled');
        LoginBtn.attr('onclick', "CastleLogin.panel()");
        LoginBtn.attr('mdui-tooltip', "{content: '" + CastleLang.sidebar.toolbar.login + "', position: 'top'}");
        $$('#login-btn i')[0].innerHTML = 'account_circle';
      },
      error: function (xhr, status, error) {
        mdui.alert(CastleLang.tips.error + '（HTTP ' + xhr.status + '）', CastleLang.sidebar.login.logout.title);
        LoginBtn.removeAttr('disabled', 'true');
      }
    });
  }
};

/**
 * 文章/独立页面
 */
var CastlePost = {
  toolbar: function () {
    if (!$$('.moe-post-card')[0] || $$('#links-dialog')[0]) { this.barColor('remove'); return false; };
    var width = document.body.scrollWidth;
    var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

    if (width > 600 && scrollTop > 450) {
      if (!$$('#header').hasClass('moe-appbar')) { this.barColor('remove'); this.barTitle('remove'); };
      if (!$$('#toolbar-device-btn').hasClass('moe-device-btn-hidden')) { return false; };
      $$('#toolbar-device-btn').removeClass('moe-device-btn-hidden');
    } else if (width > 600 && scrollTop < 450) {
      if (!$$('#header').hasClass('moe-appbar')) { this.barColor('remove'); this.barTitle('remove'); };
      if ($$('#toolbar-device-btn').hasClass('moe-device-btn-hidden')) { return false; };
      $$('#toolbar-device-btn').addClass('moe-device-btn-hidden');
    };

    if (width <= 600 && scrollTop > 260) {
      if (!$$('#header').hasClass('moe-appbar')) { return false; };
      $$('#toolbar-device-btn').removeClass('moe-device-btn-hidden');
      this.barColor('add');
      this.barTitle('add');
    } else {
      if ($$('#header').hasClass('moe-appbar')) { return false; };
      $$('#toolbar-device-btn').addClass('moe-device-btn-hidden');
      this.barColor('remove');
      this.barTitle('remove');
    };
  },

  barColor: function (method) {
    if (method == 'add') {
      $$('#header')[0].classList.remove('moe-appbar');
      $$('#header .mdui-toolbar')[0].classList.add('mdui-color-theme');
    } else {
      $$('#header')[0].classList.add('moe-appbar');
      $$('#header .mdui-toolbar')[0].classList.remove('mdui-color-theme');
    }
  },

  barTitle: function (method) {
    var bar = $$('#header .mdui-toolbar .mdui-typo-title');
    var title = $$('.moe-post-card .mdui-card-media .mdui-card-primary .mdui-card-primary-title');

    if (method == 'add') {
      bar.html(title.html());
      bar.removeAttr('href');
      bar[0].onclick = function () { CastleTop.gotoTop(); }
    } else {
      bar.html(CastleConfig.info.siteName);
      bar.attr('href', CastleConfig.url.site);
      bar[0].onclick = '';
    }
  },

  //图片懒加载
  Lazyload: function () {
    $$(".lazyload").each(function (index, item) {
      item.classList.add("castle-lazyload");
      if (item.dataset.src) {
        const image = new Image();
        image.src = item.dataset.src;
        image.onload = function() {
          if (item.tagName.toLowerCase() == "div") {
            item.style.backgroundImage = "url('" + item.dataset.src + "')";
            setTimeout(function () { item.classList.add("display"); }, 600);
          }

          if (item.tagName.toLowerCase() == "img") {
            item.src = item.dataset.src;
            item.style.opacity = 1;
          }
        }
      }
    });
  },

  //灯箱
  baguetteBox: function () {
    baguetteBox.run('[data-baguettebox="photo"]', {
      noScrollbars: true
    });
  },

  //显示标题
  showIndexPostTitle: function () {
    if (!$$('#moe-post-list')[0]) { return false; }
    function regTitle(title) {
      var otitle = CastleLang.index.FloatingTitle;
      return otitle.replace(/%s/, title);
    }
    var title = $$('#moe-post-list .moe-default-card .mdui-card-primary .mdui-card-primary-title');
    for (let i = 0; i < title.length; ++i) {
      title[i].setAttribute('title', regTitle(title[i].innerText));
    };
    var noPicTitle = $$('#moe-post-list .moe-nopic-card .moe-nopic-title a');
    for (let i = 0; i < noPicTitle.length; ++i) {
      noPicTitle[i].setAttribute('title', regTitle(noPicTitle[i].innerText));
    }
  },

  //修改密码框样式
  modifyPasswordStyle: function () {
    if (!$$('form.protected')[0]) { return false; }
    $$('form.protected').attr('onKeyDown', 'if(event.keyCode == 13){CastlePost.submitPassword();return false;}');
    var cid = $$('form.protected input[name=protectCID]')[0] != undefined ? $$('form.protected input[name=protectCID]').attr("value") : "0";
    $$('form.protected')[0].innerHTML = '<div class="mdui-textfield mdui-textfield-floating-label">\
   <label class="mdui-textfield-label">'+ CastleLang.post.hidden.input + '</label>\
   <input class="mdui-textfield-input" name="protectPassword" id="protectPassword" type="password"/>\
   <input type="hidden" name="protectCID" value="' + cid + '">\
  </div>\
  <button class="mdui-btn mdui-btn-icon mdui-color-theme-accent mdui-ripple mdui-btn-raised" type="button" onclick="CastlePost.submitPassword()"><i class="mdui-icon material-icons">&#xe876;</i></button>';
  },

  //提交文章密码
  submitPassword: function () {
    if (!$$('form.protected')[0]) { return false; }

    if (!$$('form.protected #protectPassword').val()) {
      mdui.snackbar({
        message: CastleLang.post.hidden.empty,
        position: 'right-bottom',
        onOpen: function () {
          document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400');
        }
      });
      return false;
    }

    function parseError(data) {
      var Obj = $$(document.createElement('body')).append(data);
        if (/Typecho\\Widget\\Exception/i.test(data)) {
          if (/Typecho\\Widget\\Exception:(.*)in/i.exec(data).length > 0) {
            const errroMsg = /Typecho\\Widget\\Exception:(.*)in/i.exec(data)[1].trim();
            mdui.snackbar({
              message: errroMsg,
              position: 'right-bottom',
              onOpen: function () {
                document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400');
              }
            });
          }
        } else if ($$(Obj)[0].querySelector('.container') == null) {
          mdui.snackbar({
            message: CastleLang.post.hidden.success,
            position: 'right-bottom',
            onOpen: function () {
              document.querySelector('.mdui-snackbar').classList.add('mdui-color-green-600');
            }
          });

          if (CastleConfig.switch.pjax) {
            pjax.loadUrl(window.location.href);
          } else {
            CastleLibs.reload();
          }
        } else {
          mdui.snackbar({
            message: CastleLang.post.hidden.error + '[' + $$(Obj)[0].querySelector('.container').innerHTML + ']',
            position: 'right-bottom',
            onOpen: function () {
              document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400');
            }
          });
        };
    };

    $$.ajax({
      method: 'POST',
      data: $$('form.protected').serialize(),
      url: $$('form.protected').attr('action'),
      success: function (data) {
        parseError(data);
      },
      error: function (xhr, status, error) {
        parseError(xhr.responseText);
      }
    });
  },

  //删除文章/页面确定框
  delPost: function (obj, title, post) {
    var postLang = (post) ? CastleLang.post.delete : CastleLang.page.delete;
    mdui.dialog({
      title: postLang.tips.title,
      content: postLang.tips.content.replace(/%s/, title),
      buttons: [{
        text: postLang.tips.cancel,
        onClick: function () { return false; }
      }, {
        text: postLang.tips.confirm,
        onClick: function () {
          mdui.dialog({
            title: postLang.warning.title,
            content: postLang.warning.content.small.replace(/%s/, title) + '<br/><span class="mdui-text-color-red mdui-typo-title-opacity">' + postLang.warning.content.big + '</span>',
            buttons: [{
              text: postLang.warning.cancel,
              onClick: function () { return false; }
            }, {
              text: postLang.warning.confirm,
              onClick: function () { window.location.href = $$(obj).data('delUrl'); }
            }],
            history: false
          });
        }
      }],
      history: false
    });
  },

  //代码高亮
  highLight: function () {
    $$("pre code").each(function (key, item) {
      if (item.classList.contains("hljs") === false) {
        $$(this).html("<ol><li>" + $$(this).html().replace(/\n/g, "\n</li><li>") + "\n</li></ol>");
      }
    });

    $$(document).ready(function () {
      $$('pre code').each(function (key, item) {
        if (item.classList.contains("hljs") === false) {
          hljs.highlightBlock(item);
        }
      });
    });
  },

  //文章二维码
  deviceQR: function (reCreate) {
    if (!$$('.moe-post-card #QRcode')[0]) { $$('#toolbar-device-btn').addClass('moe-device-btn-hidden'); return false; };
    function createQR(element) {
      const url = (CastleConfig.switch.QRcodeSyncScroll) ? "?lastScroll=" + CastleLibs.getNowScrollTop() : "";
      var qrcode = new QRCode(element, {
        text: window.location.href + url,
        width: 165,
        height: 165,
        colorDark: $$('body').hasClass('mdui-theme-layout-dark') ? "#e0e0e0" : "#000000",
        colorLight: $$('body').hasClass('mdui-theme-layout-dark') ? "rgba(0,0,0,0)" : "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
      });
      return qrcode;
    };
    if (reCreate === true) {
      $$('.moe-post-card #QRcode li')[0].innerHTML = "";
      createQR($$('.moe-post-card #QRcode li')[0]);
    };
    if (!$$('#header .mdui-toolbar #decice-toolbar-list')[0]) {
      $$('#header .mdui-toolbar').append('<div class="mdui-menu" id="decice-toolbar-list">\
       <li class="mdui-menu-item">\
        <img src="" />\
       </li>\
      </div>');
    };
    if (!$$('.moe-post-card #QRcode li img')[0] && $$('.moe-post-card #QRcode li')[0]) {
      createQR($$('.moe-post-card #QRcode li')[0]);
    };

    setTimeout(function () {
      if ($$('.moe-post-card #QRcode li img').css("display") != "none") {
        $$('#decice-toolbar-list li img').attr('src', $$('.moe-post-card #QRcode li img').attr('src'));
      } else {
        $$('#decice-toolbar-list li')[0].innerHTML = "";
        createQR($$('#decice-toolbar-list li')[0]);
      }
    }, 1000);
  },

  // 刷新二维码
  autoReCreateQRcode() {
    const nowUnix = Math.round((new Date()).getTime() / 1000);
    if ((nowUnix - CastleData.lastScrollStopUnix) > 1) {
      CastlePost.deviceQR(true);
      CastleData.lastScrollStopUnix = nowUnix;
    }
  }
};

/**
 * 文章目录树
 */
var CastlePostToc = {
  //生成目录树
  toc: function () {
    if (!CastleConfig.switch.toc) { return false; };
    if (!$$('.moe-post-card')[0] || $$('.moe-post-card').data('toc') == 'false' || $$('.moe-links-box')[0]) {
      this.close();
      $$('#toc-Btn')[0].classList.add('mdui-fab-hide');
      return false;
    };

    $$('#toc-Btn')[0].classList.remove('mdui-fab-hide');

    var tocInts = {
      tocSelector: '#toc-sidebar main.moe-toc-main',
      contentSelector: '.moe-post-card .moe-card-content',
      headingSelector: 'h1,h2,h3,h4',
      scrollSmooth: true,
      scrollSmoothOffset: -60,
      headingsOffset: -260
    };

    tocbot.init(tocInts);

    //为目录树链接绑定事件
    $$.each($$('.toc-link'), function (i, item) {
      $$(item)[0].onclick = function () {
        if (document.body.scrollWidth <= 1024) {
          setTimeout(function () {
            CastlePostToc.close();
          }, 450);
        }
      }
    });

    if ($$('.moe-post-card').data('popup') != undefined) {
      if ($$('.moe-post-card').data('popup') == 'true' && document.body.scrollWidth > 1024) {
        this.open();
      };
      return false;
    }

    if ($$('.moe-post-card').data('toc') == 'true' && CastleConfig.setting.toc.popup === true && $$('#toc-sidebar main.moe-toc-main').html() != "") {
      if (document.body.scrollWidth > 1024) {
        this.open();
      }
    };

    if ($$('#toc-sidebar main.moe-toc-main').html() == "") {
      $$('#toc-sidebar main.moe-toc-main').html('<div class="moe-toc-empty">无可显示目录</div>');
    }
  },

  toggle: function () {
    if (!CastleConfig.switch.toc) { return false; };
    if (!$$('.moe-post-card')[0]) { return false; };
    if (!$$('#moe-toc-sidebar-overlay')[0]) { this.overlay(); };

    var tocSidebar = $$('#toc-sidebar');
    if (tocSidebar.hasClass('toc-sidebar-open')) {
      this.close();
    } else {
      this.open();
    }
  },

  open: function () {
    if (!CastleConfig.switch.toc) { return false; };
    if (!$$('.moe-post-card')[0]) { return false; };
    if (!$$('#moe-toc-sidebar-overlay')[0]) { this.overlay(); };
    if ($$('#moe-toc-sidebar-overlay')[0]) {
      $$('#moe-toc-sidebar-overlay')[0].style.display = 'block';
      setTimeout(function () {
        $$('#moe-toc-sidebar-overlay')[0].classList.add('moe-toc-sidebar-overlay-open');
      }, 10);
    };

    var tocSidebar = $$('#toc-sidebar');
    tocSidebar[0].style.display = 'block';
    $$('body')[0].classList.add('mdui-drawer-body-right');

    setTimeout(function () {
      tocSidebar[0].classList.add('toc-sidebar-open');
    }, 10);

    //将 body 固定住
    $$('body').addClass('mdui-locked');
  },

  close: function () {
    if (!CastleConfig.switch.toc) { return false; };
    if ($$('#moe-toc-sidebar-overlay')[0]) {
      $$('#moe-toc-sidebar-overlay')[0].classList.remove('moe-toc-sidebar-overlay-open');
      setTimeout(function () {
        $$('#moe-toc-sidebar-overlay')[0].style.display = 'none';
      }, 310);
    }

    var tocSidebar = $$('#toc-sidebar');
    tocSidebar[0].classList.remove('toc-sidebar-open');
    $$('body')[0].classList.remove('mdui-drawer-body-right');

    setTimeout(function () {
      tocSidebar[0].style.display = 'none';
    }, 310);

    //放开 body 的束缚（
    $$('body').removeClass('mdui-locked');
  },

  //创建遮罩层
  overlay: function () {
    if (!CastleConfig.switch.toc) { return false; };
    var tocOverlay = document.createElement("div");
    tocOverlay.setAttribute('id', 'moe-toc-sidebar-overlay');
    tocOverlay.onclick = function () { CastlePostToc.toggle(); };
    tocOverlay.style.display = "none";
    $$('body').append(tocOverlay);
  }
};

/**
 * 表情框
 */
var CastleOwO = {
  toggle: function () {
    if (!$$('#comment-card-box')[0]) { return false; };
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
    tag = ' ' + tag + ' '; myField = $$('#comment-card-box .moe-comment-input-text #text')[0];
    document.selection ? (myField.focus(), sel = document.selection.createRange(), sel.text = tag, myField.focus()) : this.insertTag(tag);
  },

  insertTag: function (tag) {
    myField = $$('#comment-card-box .moe-comment-input-text #text')[0];
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
  }
};

/**
 * 评论
 */
var CastleComments = {
  //评论核心函数
  Core: function () {
    var commentID = $$('.respondID').attr('id');
    window.TypechoComment = {
      dom: function (id) {
        return document.getElementById(id);
      },
      create: function (tag, attr) {
        var el = document.createElement(tag);
        for (var key in attr) {
          el.setAttribute(key, attr[key]);
        }
        return el;
      },
      reply: function (cid, coid) {
        $$("#comment-card-box").addClass('moe-comment-card-opaque');
        var comment = $$('#' + cid + ' main')[0], parent = comment.parentNode,
          response = this.dom(commentID),
          input = this.dom('comment-parent'),
          form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
          textarea = response.getElementsByTagName('textarea')[0];
        if (null == input) {
          input = this.create('input', {
            'type': 'hidden',
            'name': 'parent',
            'id': 'comment-parent'
          });
          form.appendChild(input);
        }
        input.setAttribute('value', coid);
        if (null == this.dom('comment-form-place-holder')) {
          var holder = this.create('div', {
            'id': 'comment-form-place-holder'
          });
          response.parentNode.insertBefore(holder, response);
        }
        last = CastleComments.getLastComment();
        if (last == null) {
          comment.appendChild(response);
        } else if (last.id == cid) {
          $$("#comments")[0].appendChild(response);
        } else {
          comment.appendChild(response);
        }
        this.dom('cancel-comment-reply-link').style.display = '';
        if (null != textarea && 'text' == textarea.name) {
          textarea.focus();
        }
        return false;
      },
      cancelReply: function () {
        $$("#comment-card-box").removeClass('moe-comment-card-opaque');
        var response = this.dom(commentID),
          holder = this.dom('comment-form-place-holder'),
          input = this.dom('comment-parent');
        if (null != input) {
          input.parentNode.removeChild(input);
        }
        if (null == holder) {
          return true;
        }
        this.dom('cancel-comment-reply-link').style.display = 'none';
        holder.parentNode.insertBefore(response, holder);
        return false;
      }
    }
  },

  //查找本页底部评论
  getLastComment: function () {
    firstNodeList = $$(".moe-comments-list-box > div");
    if (firstNodeList.length == 0) {
      return null;
    }
    firstNode = firstNodeList[firstNodeList.length - 1];
    return CastleComments.checkLast(firstNode);
  },

  //查找最末评论递归函数
  checkLast: function (node) {
    next = $$(node).next();
    if (next[0] == null) {
      return node;
    }
    if (next.hasClass("moe-comments-list-box") === false) {
      return node;
    }
    nextNodeList = next.children(".moe-comments-box");
    nextNode = nextNodeList[nextNodeList.length - 1];
    return CastleComments.checkLast(nextNode);
  },

  //打开/关闭链接输入框
  showLinkInput: function () {
    if (!$$('.moe-comment-card-content .moe-comment-input-url')[0]) { return false; }

    var link = $$('.moe-comment-card-content .moe-comment-input-url');

    if (link.hasClass('moe-comment-input-url-hidden')) {
      //如果已经打开
      link[0].classList.remove('moe-comment-input-url-hidden');
    } else {
      //如果已经关闭
      link[0].classList.add('moe-comment-input-url-hidden');
    }
  },

  //AJAX 获取评论者头像
  headimgAJAX: function () {
    if (!$$(".moe-comment-card-content #email")[0]) { return false; }
    $$(".moe-comment-card-content #email")[0].onblur = function () {
      if (!$$(this).val()) { return false } else { $$('#moe-comment-author-avatar')[0].innerHTML = '<div class="mdui-spinner"></div>'; mdui.mutation($$('#moe-comment-author-avatar')); };
      $$.ajax({
        method: 'GET',
        url: CastleConfig.url.index,
        data: {
          action: 'ajax_get_avatar',
          form: window.location.host,
          email: $$(this).val()
        },
        success: function (data) {
          if (!data) { return false; }
          $$('#moe-comment-author-avatar')[0].innerHTML = '<img src="' + data + '" />';
        },
        error: function (xhr, status, error) {
          mdui.snackbar({ message: '请求失败，请检查网络是否正常', position: 'right-bottom', onOpen: function () { document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400'); } });
        }
      });
    };
  },

  //提交 AJAX 评论
  submitComment: function () {
    if (!$$('.respondID').attr('data-commentUrl')) { return false; };

    /* ===== 检查是否完整 =====*/
    //如果评论内容为空
    if (!$$('.moe-comment-card-content #text').val()) {
      mdui.snackbar({
        message: CastleLang.comment.MsgEmpty,
        position: 'right-bottom',
        onOpen: function () {
          document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400');
        }
      });
      return false;
    };

    //如果昵称为空
    if ($$('.moe-comment-input-username #author').length && !$$('.moe-comment-input-username #author').val()) {
      mdui.snackbar({
        message: CastleLang.comment.AuthorEmpty,
        position: 'right-bottom',
        onOpen: function () {
          document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400');
        }
      });
      return false;
    };

    //如果邮箱为空
    if ($$('.moe-comment-input-email #email').length && !$$('.moe-comment-input-email #email').val() && CastleConfig.switch.comment.email) {
      mdui.snackbar({
        message: CastleLang.comment.EmailEmpty,
        position: 'right-bottom',
        onOpen: function () {
          document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400');
        }
      });
      return false;
    };

    //如果链接为空
    if ($$('.moe-comment-input-url #url').length && !$$('.moe-comment-input-url #url').val() && CastleConfig.switch.comment.link) {
      mdui.snackbar({
        message: CastleLang.comment.UrlEmpty,
        position: 'right-bottom',
        onOpen: function () {
          document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400');
        }
      });
      if ($$('.moe-comment-card-content .moe-comment-input-url').hasClass('moe-comment-input-url-hidden')) {
        $$('.moe-comment-card-content .moe-comment-input-url')[0].classList.remove('moe-comment-input-url-hidden');
      }
      return false;
    };

    //评论前需要做的事情
    function beforeComment() {
      //禁用按钮
      $$('#submitCommentBtn').attr('disabled', true);

      //关闭工具提示
      $$(".mdui-tooltip").removeClass("mdui-tooltip-open");

      //修改图标
      $$('#submitCommentBtn i').html('cached');
      $$('#submitCommentBtn i').addClass('moe-rotate360deg-infinite');
    };
    beforeComment();

    //评论后需要做的事情
    function afterComment(status) {
      //取消禁用评论按钮
      $$('#submitCommentBtn').removeAttr('disabled');

      //移除动画
      $$('#submitCommentBtn i').removeClass('moe-rotate360deg-infinite');

      //评论成功
      if (status) {
        $$('#submitCommentBtn i').html('send');
        CastleData.comments.replyTo = '';
        $$('.moe-comment-input-text #text').val('');
        $$('.moe-comment-input-text #text')[0].focus();
        $$('.moe-comment-input-text #text')[0].blur();

        //重新绑定链接事件
        CastleLibs.scrollClick();
      } else {
        $$('#submitCommentBtn i').html('warning');
        setTimeout(function () {
          $$('#submitCommentBtn i').html('send');
        }, 1200);
      }

      //重新绑定回复按钮
      CastleComments.bindReplyBtn();

      //重载下代码高亮
      CastlePost.highLight();
    };

    //提交评论
    $$.ajax({
      method: 'POST',
      url: $$('.respondID').attr('data-commentUrl'),
      data: $$('.moe-comment-card-content').serialize(),
      success: function (data) {
        var Obj = $$(document.createElement('body')).append(data);
        if ($$(Obj)[0].querySelector('.container') == null) {
          var $htmlData = $$(document.createElement('body')).append(data);

          //新评论ID
          if ($htmlData.html()) {
            CastleData.comments.NewID = $htmlData.html().match(/id=\"?comment-\d+/g).join().match(/\d+/g).sort(function (a, b) { return a - b }).pop();
          } else {
            mdui.snackbar({
              message: CastleLang.comment.refresh,
              position: 'right-bottom',
              onOpen: function () {
                document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400');
              }
            });
            afterComment(false);
            return false;
          };

          if ('' === CastleData.comments.replyTo || CastleData.comments.replyTo == undefined) {
            if (!$$('#comments > .moe-comments-list-box > .moe-comments-box').length) {
              //检查是否已有评论
              //如果没有先插入评论列表基本结构
              CastleData.comments.newComment = $htmlData[0].querySelectorAll('#comment-' + CastleData.comments.NewID);
              $$('.moe-comments-list-header').after('<div class="moe-comments-list-box"></div>');
              $$('.moe-comments-list-box').first().prepend(CastleData.comments.newComment);
              $$('#comment-' + CastleData.comments.NewID).addClass('moe-animation-fadein');
            } else if ($$('.prev').length) {
              //如果不在第一页
              $$('.moe-comments-page-navigator li a').eq(1)[0].click();
            } else {
              //当前在第一页
              CastleData.comments.newComment = $htmlData[0].querySelectorAll('#comment-' + CastleData.comments.NewID);
              $$('.moe-comments-list-box').first().prepend(CastleData.comments.newComment);
              $$('#comment-' + CastleData.comments.NewID).addClass('moe-animation-fadein');
            }

          } else {
            //如果是子评论
            CastleData.comments.newComment = $htmlData[0].querySelectorAll('#comment-' + CastleData.comments.NewID);

            if ($$('#' + CastleData.comments.replyTo).find('.moe-comment-children').length) {
              //当前父评论已经有嵌套的结构
              //直接插入新的评论
              $$('#' + CastleData.comments.replyTo + ' .moe-comment-children .moe-comments-list-box').first().append(CastleData.comments.newComment);
              $$('#comment-' + CastleData.comments.NewID).addClass('moe-animation-fadein');
              TypechoComment.cancelReply();
              CastleTop.scrollSmoothTo($$('#comment-' + CastleData.comments.NewID).offset().top);
            } else {
              //当前父评论没有嵌套的结构
              //先构建嵌套的结构再进插入子评论
              $$('#' + CastleData.comments.replyTo).append('<div class="moe-comment-children"><div class="moe-comments-list-box"></div></div>');
              $$('#' + CastleData.comments.replyTo + ' .moe-comment-children .moe-comments-list-box').first().prepend(CastleData.comments.newComment);
              $$('#comment-' + CastleData.comments.NewID).addClass('moe-animation-fadein');
              TypechoComment.cancelReply();
              CastleTop.scrollSmoothTo($$('#comment-' + CastleData.comments.NewID).offset().top);
            }
          };

          //评论数量增加
          if ($$('.moe-comments-list-number span').text() == null) {
            $$('.moe-comments-list-number').html(CastleLang.comment.have.replace(/%s/, '<span>1</span>'));
          } else {
            var counts = parseInt($$('.moe-comments-list-number span').text());
            $$('.moe-comments-list-number span').html($$('.moe-comments-list-number span').html().replace(/\d+/, counts + 1));
          };

          //处理评论后的事情
          afterComment(true);

          //判断是否在审核
          if ($$('#comment-' + CastleData.comments.NewID + ' .moe-comments-time span')[0]) {
            CastleData.comments.message = CastleLang.comment.pending;
            CastleData.comments.messageColor = 'mdui-color-deep-orange-600';
          } else {
            CastleData.comments.message = CastleLang.comment.success;
            CastleData.comments.messageColor = 'mdui-color-teal-500';
          };

          //提示评论成功
          mdui.snackbar({
            message: CastleData.comments.message,
            position: 'right-bottom',
            onOpen: function () {
              document.querySelector('.mdui-snackbar').classList.add(CastleData.comments.messageColor);
            }
          });
        } else {
          //评论失败
          mdui.snackbar({
            message: '评论失败！<br>原因：[' + $$(Obj)[0].querySelector('.container').innerHTML + ']',
            position: 'right-bottom',
            onOpen: function () {
              document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400');
            }
          });
          afterComment(false);
        }
      },
      error: function (xhr, status, error) {
        mdui.snackbar({
          message: '评论提交失败！<br>原因 [HTTP ' + xhr.status + ']',
          position: 'right-bottom',
          onOpen: function () {
            document.querySelector('.mdui-snackbar').classList.add('mdui-color-red-400');
          }
        });

        //评论发送后处理的事情
        afterComment(false);
      }
    });
  },

  //为回复/取消回复按钮绑定事件
  bindReplyBtn: function () {
    if (!$$('#comments')[0]) { return false; };
    CastleData.comments.replyTo = '';
    if (!$$(".moe-comments-reply a")[0]) { return false; };

    for (let i = 0; i < $$(".moe-comments-reply a").length; ++i) {
      $$(".moe-comments-reply a")[i].addEventListener('click', function () {
        CastleData.comments.replyTo = $$(this).parent().parent().parent().parent().attr("id");
      });
    };

    $$(".moe-comment-card-btns a")[0].addEventListener('click', function () { CastleData.comments.replyTo = ''; });
  }
};

/**
 * 全站公告
 */
var CastleFSA = {
  create: function () {
    if (!CastleConfig.switch.FSA || !CastleConfig.setting.FSA.content) { return false; };
    //判断是否开启 PJAX
    if (!CastleConfig.switch.pjax && CastleLibs.getCookie('FSAreaded') == 'true') { return false; } else if (!CastleConfig.switch.pjax) {
      CastleLibs.setCookie('FSAreaded', 'true', false, '/')
    }

    var message = CastleConfig.setting.FSA.content,
      textColor = CastleConfig.setting.FSA.textColor,
      background = CastleConfig.setting.FSA.background,
      position = CastleConfig.setting.FSA.position,
      buttonColor = CastleConfig.setting.FSA.buttonColor,
      timeout = (typeof (Number(CastleConfig.setting.FSA.timeout)) == 'number') ? CastleConfig.setting.FSA.timeout : 0;

    var buttonText = (CastleConfig.setting.FSA.buttonSwitch && CastleConfig.setting.FSA.buttonText) ? CastleConfig.setting.FSA.buttonText : '';

    mdui.snackbar({
      message: message,
      position: position,
      timeout: timeout,
      buttonText: buttonText,
      buttonColor: buttonColor,
      onOpen: function () {
        var snackbar = document.querySelector('.mdui-snackbar');
        snackbar.style.backgroundColor = background;
        snackbar.style.color = textColor;
        document.querySelector('.mdui-snackbar .mdui-snackbar-action').setAttribute('no-go', '');
        document.querySelector('.mdui-snackbar .mdui-snackbar-action').setAttribute('no-pjax', '');
      }
    });
  }
};

/**
 * Libs
 */
var CastleLibs = {
  //获取 Cookie
  getCookie: function (name) {
    var name = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i].trim();
      if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    };
    return false;
  },

  //设置 Cookie
  setCookie: function (name, value, days, path) {
    if (days === false) {
      document.cookie = name + '=' + value + ';path=' + path + ';';
    } else {
      var exp = CastleData.date;
      exp.setTime(exp.getTime() + days * 24 * 60 * 60 * 1000);
      document.cookie = name + '=' + value + ';expires=' + exp.toGMTString() + ';path=' + path + ';';
    }
  },

  // 获取 Query 参数
  getQueryString: function (name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var reg_rewrite = new RegExp("(^|/)" + name + "/([^/]*)(/|$)", "i");
    var hash = window.location.hash;
    if (/#(.*)\?(.*)/.test(hash)) {
      var hashNew = /#(.*)\?(.*)/.exec(hash);
      if (hashNew != null) {
        hash = hashNew[2].match(reg)
      } else {
        hash = null;
      }
    } else {
      hash = null;
    }
    var result = window.location.hash.substring(1).match(reg);
    var query = window.location.pathname.substring(1).match(reg_rewrite);
    if (result != null) {
      return decodeURIComponent(result[2]);
    } else if (query != null) {
      return decodeURIComponent(query[2]);
    } else if (hash != null) {
      return decodeURIComponent(hash[2]);
    } else {
      return null;
    }
  },

  //非站内链接添加 target=_blank 属性
  linkTarget: function () {
    $$('a:not([no-go]):not([target="_self"]):not(.toc-link)').each(function () {
      var href = $$(this).attr('href');
      var check = new RegExp("^" + document.location.protocol + "//" + window.location.host);
      if (!check.test(href) && (href != null && href != "")) {
        $$(this).attr('target', '_blank');
      }
    });
  },

  //平滑滚动到锚点
  scrollClick: function () {
    for (let i = 0; i < $$('a[href*="#"]:not([no-pgo]):not(.toc-link)').length; ++i) {
      $$('a[href*="#"]:not([no-pgo]):not(.toc-link)')[i].addEventListener('click', function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
          var $target = $$(this.hash);
          $target = $target.length && $target;
          if ($target.length) {
            var targetOffset = $target.offset().top;
            CastleTop.scrollSmoothTo(targetOffset);
            //console.log('top')
            return false;
          }
        }
      });
    }
  },

  //滚动条定位到上次浏览的位置
  scrollPos: function () {
    window.onbeforeunload = function () {
      const scrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
      document.cookie = "scrollTop=" + scrollPos; //存储滚动条位置到cookies中
    };

    if (document.cookie.match(/scrollTop=([^;]+)(;|$)/) != null) {
      var arr = document.cookie.match(/scrollTop=([^;]+)(;|$)/); //cookies中不为空，则读取滚动条位置
      document.documentElement.scrollTop = parseInt(arr[1]);
      document.body.scrollTop = parseInt(arr[1]);
    }
  },

  //刷新页面
  reload: function () {
    //window.location.reload(false);
    var script = document.createElement("script");
    script.innerHTML = 'window.location.reload(false);';
    setTimeout(function () {
      $$('body').append(script);
    }, 1000);
  },

  //销毁 MDUI ToolTip
  rmToolTip: function () {
    var tooltips = $$('.mdui-tooltip');
    tooltips.remove();
  },

  // 获取页面目前位置
  getNowScrollTop: function () {
    return window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
  },

  // 解析并跳转到指定位置
  goScrollTop: function() {
    const width = $$("body").width();
    const lastScroll = CastleLibs.getQueryString("lastScroll");
    if (lastScroll != null) {
      const realScroll = width <= 600 ? lastScroll - 140 : width <= 800 ? lastScroll - 40 : lastScroll;
      window.scrollTo({
        top: realScroll,
        behavior: "smooth",
      });
    }
  }
};

/**
 * 回到顶部按钮
 */
var CastleTop = {
  gotoTopBtn: function () {
    var height = document.documentElement.scrollTop || document.body.scrollTop;
    var bottomHeight = document.documentElement.scrollHeight - document.documentElement.scrollTop - document.documentElement.clientHeight;

    if (height > 300 && bottomHeight > 100) {
      this.topBtn('display');
    } else {
      this.topBtn('hidden');
    }
  },

  topBtn: function (method) {
    if (method == 'hidden') {
      $$('#go-top')[0].classList.add('mdui-fab-hide');
    } else {
      $$('#go-top')[0].classList.remove('mdui-fab-hide');
    }
  },

  //平滑回到顶部
  gotoTop: function () {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  },

  //平滑滚动
  scrollSmoothTo: function (position) {
    if (!window.requestAnimationFrame) {
      window.requestAnimationFrame = function (callback, element) {
        return setTimeout(callback, 17);
      };
    }
    // 当前滚动高度
    var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    // 滚动step方法
    var step = function () {
      // 距离目标滚动距离
      var distance = position - scrollTop;
      // 目标滚动位置
      scrollTop = scrollTop + distance / 20;
      if (Math.abs(distance) < 1) {
        window.scrollTo(0, position);
      } else {
        window.scrollTo(0, scrollTop);
        requestAnimationFrame(step);
      }
    };
    step();
  }
};


/**
 * 所需执行
 */
CastleCreate.BG();
CastleNight.check();
CastleCreate.Search();
CastleCreate.Sidebar();
CastleCreate.Header();
CastleCreate.Footer();
CastleCreate.btnGroup();
CastleCreate.gotoTopBtn();
if (CastleConfig.switch.toc) { CastleCreate.tocBtn(); };
CastleCreate.tocSidebar();
if (CastleConfig.switch.pjax) { CastleLibs.scrollPos(); };
if (CastleConfig.switch.FSA) { CastleFSA.create(); };

/**
 * 需要重载
 */
needReload = function () {
  if (CastleConfig.switch.toc) {
    CastlePostToc.toc();
    window.onload = function () { CastlePostToc.toc(); }
  };
  CastleComments.Core();
  CastleLibs.linkTarget();
  CastleComments.headimgAJAX();
  CastleComments.bindReplyBtn();
  CastleLibs.scrollClick();
  CastlePost.Lazyload();
  CastlePost.baguetteBox();
  CastlePost.toolbar();
  CastlePost.showIndexPostTitle();
  CastlePost.modifyPasswordStyle();
  CastlePost.highLight();
  CastlePost.deviceQR();
  if (CastleConfig.switch.bangumi) {
    bangumiLoad()
  };
  if (CastleConfig.switch.QRcodeSyncScroll) { setTimeout(function () { CastleLibs.goScrollTop(); }, 100); }
};
needReload();

/**
 * 窗口滚动变化
 */
document.addEventListener('scroll', function () {
  CastlePost.toolbar();
  CastleTop.gotoTopBtn();
  if (CastleConfig.switch.QRcodeSyncScroll) { CastlePost.autoReCreateQRcode(); }
  if (!$$('.moe-post-card #QRcode')[0]) { $$('#toolbar-device-btn').addClass('moe-device-btn-hidden'); };
});

window.addEventListener('resize', function () {
  CastlePost.toolbar();
  if (CastleConfig.switch.QRcodeSyncScroll) { CastlePost.autoReCreateQRcode(); }
  if (!$$('.moe-post-card #QRcode')[0]) { $$('#toolbar-device-btn').addClass('moe-device-btn-hidden'); };
});

/**
 * 页面资源加载完成
 */
window.addEventListener('load', function () {
  if (CastleConfig.switch.QRcodeSyncScroll) { setTimeout(function () { CastleLibs.goScrollTop(); }, 100); }
});

/**
 * PJAX
 */
if (CastleConfig.switch.pjax) {
  var pjax = new Pjax({
    elements: 'a[href^="' + document.location.protocol + '//' + window.location.host + '/"]:not([target="_blank"]):not([no-pjax])',
    selectors: ["title", "#moe-pjax-content"],
    timeout: PjaxConfig.timeout,
    cacheBust: false,
    scrollRestoration: true
  });

  //PJAX 开始请求时执行
  document.addEventListener('pjax:send', function () {
    if (!CastleConfig.switch.toc) { tocbot.destroy(); };
    NProgress.start();
    CastleData.scrollTop = document.documentElement.scrollTop || document.body.scrollTop || window.pageYOffset || 0;
  });

  //PJAX 请求成功后执行
  document.addEventListener('pjax:success', function () {
    mdui.mutation();
    needReload();
    CastleLibs.rmToolTip();
    //setTimeout(function(){window.scrollTo(0, CastleData.scrollTop);},-100);
  });

  //PJAX 请求成功并加载完成后执行
  document.addEventListener('pjax:complete', function () {
    NProgress.done();
    //CastleTop.gotoTop(0, 0);
    if (!$$('.moe-post-card')[0] || $$('#links-dialog')[0]) { CastlePost.barTitle('remove'); }
    PjaxConfig.after();
  });

  //PJAX 请求失败时执行
  document.addEventListener('pjax:error', function () {
    mdui.snackbar({
      message: CastleLang.pjax.error,
      position: 'right-bottom',
      onOpen: function () {
        var snackbar = document.querySelector('.mdui-snackbar');
        snackbar.classList.add('mdui-color-red-400');
      }
    });
  });
};

console.log(" %c \u2728\u0020\u0043\u0061\u0073\u0074\u006c\u0065 " + CastleConfig.CastleVersion + " %c \u0042\u0079\u0020\u006f\u0068\u006d\u0079\u0067\u0061\u0020\u007c\u0020\u0068\u0074\u0074\u0070\u0073\u003a\u002f\u002f\u006f\u0068\u006d\u0079\u0067\u0061\u002e\u0063\u006e\u002f ", "color: #FFFFFF; background: #1E88E5; padding:6px;", "color: #FFFFFF; background: #424242; padding:6px;");
