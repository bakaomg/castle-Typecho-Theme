## 侧边抽屉
- 首页按钮为默认按钮不可删除。

> 图标请参考 https://www.mdui.org/docs/material_icon

!> 全程请注意遵循 [JSON的语法](http://www.w3school.com.cn/json/json_syntax.asp) （否则语法不规范，报错两行泪

!> 下列示例中的注解（例如 `//` 开头的）请在**实际使用中去掉**，**以免发生报错导致侧栏为空**

## 可用变量
- `"link"` 中可用变量目前有 `{siteIndex}` (站点首页链接)

------

## 普通按钮
![按钮](../../static/img/setting/button.png)
- `"name"` 按钮名称
- `"type"` 类型 `button` 为普通按钮
- `"link"` 按钮链接（如果链接为站外链接且不设置禁止新标签页打开将会自动添加 target="blank" 属性
- `"icon"` 按钮图标（请前往 [MDUI Docs](https://www.mdui.org/docs/material_icon) 获取图标名
- `"setting"` 按钮设置，可用设置项见下面示例

```json
{
 "name": "普通按钮",  //按钮名称
 "icon": {
  "type": "mdui",    //图标类型（目前只有 mdui ）
  "text": "link"     //图标名称（见 MDUI 文档）
 },
 "link": "{siteIndex}/test.html",  //按钮链接（可用变量见上方）
 "setting": {
  "target": false    //是否强制在新标签页打开（填入的值为布尔值 true 或 false ）
 }
}
```

------

## 归档按钮
![归档](../../static/img/setting/archives.png)
- `"name"` 列表名称
- `"type"` 类型 `archives` 为归档列表
- `"icon"` 列表图标（请前往 [MDUI Docs](https://www.mdui.org/docs/material_icon) 获取图标名）
- `"setting"` 按钮设置，可用设置项见下面示例

```json
{
 "name": "归档",       //按钮名称
 "type": "archives",  //按钮类型（归档列表）
 "icon": {
  "type": "mdui",     //图标类型（目前仅支持 MDUI ）
  "text": "&#xe192;"  //图标名称（见 MDUI 文档）
 },
 "setting": {
  "number": true,      //是否显示数量
  "date": "Y 年 m 月"  //归档显示的时间格式（Y = 年，m = 月）
 }
}
```

------

## 分类按钮
![分类](../../static/img/setting/category.png)
- `"name"` 列表名称
- `"type"` 类型 `category` 为分类列表
- `"icon"` 列表图标（请前往 [MDUI Docs](https://www.mdui.org/docs/material_icon) 获取图标名）
- `"setting"` 按钮设置，可用设置项见下面示例

```json
{
 "name": "分类",       //按钮名称
 "type": "category",  //按钮类型（分类列表）
 "icon": {
  "type": "mdui",     //图标类型（目前仅支持 MDUI ）
  "text": "&#xe8ef;"  //图标名称（见 MDUI 文档）
 },
 "setting": {
  "number": true      //是否显示数量
 }
}
```

------

## 页面按钮
![页面](../../static/img/setting/pages.png)
- `"name"` 列表名称
- `"type"` 类型 `pages` 为页面列表
- `"icon"` 列表图标（请前往 [MDUI Docs](https://www.mdui.org/docs/material_icon) 获取图标名）

```json
{
 "name": "页面",       //按钮名称
 "type": "pages",     //按钮类型（页面列表）
 "icon": {
  "type": "mdui",     //图标类型（目前仅支持 MDUI ）
  "text": "&#xe8eb;"  //图标名称（见 MDUI 文档）
 }
}
```

------

## 列表按钮
![列表](../../static/img/setting/list.png)
- `"name"` 显示名称
- `"type"` 类型 `list` 为列表
- `"icon"` 父列表图标（请前往 [MDUI Docs](https://www.mdui.org/docs/material_icon) 获取图标名）
- `"content"` 子列表内容（见示例）

```json
{
 "name": "自定列表",  //按钮名称
 "type": "list",     //按钮类型（自定义列表）
 "icon": {
  "type": "mdui",     //图标类型（目前仅支持 MDUI ）
  "text": "setting"   //图标名称（见 MDUI 文档）
 },
 "content": [{        //列表内容
  "name": "自定子列表1",  //子列表的名称（下同）
  "link": "#",           //子列表的链接（下同）
  "target": false        //子列表是否新标签页打开（下同）
 },{
  "name": "自定子列表2",
  "link": "#",
  "target": false
 },{
  "name": "以此类推。。",
  "link": "#",
  "target": false
 }]
}
```

------

## 分割线
![数据统计](../../static/img/setting/divider.png)
- `"type"` 类型 `divider` 为分割线

```json
{
 "type": "divider"  //类型（分割线）
}
```

------

## Rss 订阅按钮
![数据统计](../../static/img/setting/rss.png)
- `"name"` 显示名称
- `"type"` 类型 `RssLink` 为 RSS 订阅按钮
- `"icon"` 按钮图标（请前往 [MDUI Docs](https://www.mdui.org/docs/material_icon) 获取图标名）
- `"setting"` 按钮设置，可用设置项见下面示例

```json
{
 "name": "RSS 订阅",  //按钮名称
 "type": "RssLink",  //按钮类型（Rss按钮）
 "icon": {
  "type": "mdui",    //图标类型（目前仅支持 MDUI ）
  "text": "&#xe0e5;" //图标名称（见 MDUI 文档）
 },
 "setting": {
  "target": true     //是否强制新标签页打开（填入的值为布尔值 true 或 false ）
 }
}
```

------

## 数据统计
![数据统计](../../static/img/setting/total.png)
- `"name"` 显示名称
- `"type"` 数据统计类型，见示例

```json
//文章总数
{
 "name": "文章总数",
 "type": "TotalPost"
}
```
```json
//评论总数
{
 "name": "评论总数",
 "type": "TotalComments"
}
```
```json
//页面总数
{
 "name": "页面总数",
 "type": "TotalPage"
}
```
```json
//分类总数
{
 "name": "分类总数",
 "type": "TotalCategory"
}
```