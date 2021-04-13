# 常见问题

## 安装时提示「风格不存在」或「服务器错误」
- 请确保主题文件夹名为 `Castle`。
- 如果主题已经启用且改动了文件夹名称，请到外观重新启用一次主题。

## 安装完主题后，页面中间部分空白/安装后首页报错
- 检查 PHP 版本是否大于或等于 7.0 (一般低于此版本会提示)。
- 初次使用请确保博客中有至少一篇文章，以免向数据库添加 `view` 字段失败（文章浏览次数）。

## Links 插件提示启用失败
- 如果启用时提示「数据表建立失败，友情链接插件启用失败。错误号：42S01」，是因为数据库中已经有 `typecho_link` 表了，重命名此表，待插件启用完成后删除插件刚创建的表再将旧的表名改为 `typecho_links` 即可（下版本修复）。
- 如果启用时提示「Server Error」，请确保插件文件夹名为 `Links` 并且 `/usr/plugins` 有足够的读写权限。

## 从低版本 PHP 切换到 PHP 7.0+ 时提示数据库错误
- 如果数据库为 `MySQL` 请打开 Typecho 根目录下的 `config.inc.php` 修改第 55 行（大概）`$db = new Typecho_Db('Mysql', 'typecho_');` 为 `$db = new Typecho_Db('Pdo_Mysql', 'typecho_');`。

## Aplayer 无法加载
- 如果开启了 `PJAX` ，请前往 `控制台` → `外观` → `外观设置` → `功能设置` → `外观` → `PJAX 设置`，在 `PJAX 重载函数` 中填入 `loadMeting();` 并保存。

## 其他问题？
如遇到其他问题，请在 Github [Issues](https://github.com/ohmyga233/castle-Typecho-Theme/issues) 提出或到博客留言板留言。