## 主题语言
- 默认为 Zh-CN (简体中文)
- 已有语言 `zh-CN(简体中文)`

## 自定义语言
前往主题根目录下的 `/core/lang` 文件夹。<br>
复制一份配置文件并重命名，配置格式为 Json ，请遵循 Json 的格式。

打开复制的那份，修改 `name` (后台设置显示的配置名称)、`raw_name` 为唯一的标识，不可重复。
```json
{
 "name": "配置名称",
 "raw_name": "lang"
}
```

余下根据原先内容修改即可。

## 修改后不显示语言或者报错
- 检查 Json 格式是否有误 详细参考[Json语法](http://www.w3school.com.cn/json/json_syntax.asp)