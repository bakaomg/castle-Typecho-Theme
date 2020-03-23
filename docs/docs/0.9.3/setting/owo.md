## 自定义表情
- 表情配置文件位于 `主题根目录/core/owo.json`
- `"type"` 类型有：`text`（颜文字）、`emoji`、`smallPicture`（小表情，如`贴吧`表情）、`picture`（普通图片表情，如`猫猫`表情）、`external`（外部链接表情包）
- 除了 `external` 其余类型的表情都得放在 `主题根目录/static/img/{表情包名称}/`

!> 全程请注意遵循 [JSON的语法](http://www.w3school.com.cn/json/json_syntax.asp) （否则语法不规范，报错两行泪

!> 下列示例中的注解（例如 `//` 开头的）请在**实际使用中去掉**，**以免发生报错导致表情框为空**

## 一般示例
```json
//图片表情包
{
 "owoName": {            //表情包的英文名称 同时也是表情包文件夹名称 所以不可以使用中文以及其他特殊符号
  "name": "示例表情包",   //表情包显示名称
  "type": "picture",     //表情包类型（此配置对 smallPicture 和 picture 有效）
  "content": [           //表情包内容
   {"file": "owo.jpg", "data": "::owo测试::"},   //"file" 为此表情的文件名，"data" 为此表情的唯一标识（解析时用得到，不允许有重复）
   {"file": "owo1.jpg", "data": "::owo测试1::"}, //如上（以此类推）
   {"file": "owo2.jpg", "data": "::owo测试2::"}  //如上（以此类推）
  ]
 }
}
```

```json
//Emoji 或 颜文字
{
 "owoName": {            //表情包的英文名称 同时也是表情包文件夹名称 所以不可以使用中文以及其他特殊符号
  "name": "示例表情包",   //表情包显示名称
  "type": "text",        //表情包类型（此配置对 emoji 和 text 有效）
  "content": [           //表情包内容
   {"text": "(。・∀・)ノ"},   //"text" 为 Emoji 或 颜文字
   {"text": "＞﹏＜"},        //如上（以此类推）
   {"text": "🤔"}            //如上（以此类推）
  ]
 }
}
```

```json
//外部图片
{
 "owoName": {            //表情包的英文名称 同时也是表情包文件夹名称 所以不可以使用中文以及其他特殊符号
  "name": "示例表情包",   //表情包显示名称
  "type": "external",    //表情包类型（此配置对 external 有效）
  "content": [           //表情包内容
   {"file": "qwq.jpg", "data": "::qwq测试::"},   //"file" 为此表情的文件名，"data" 为此表情的唯一标识（解析时用得到，不允许有重复）
   {"file": "qwq1.jpg", "data": "::qw测试1::"},  //如上（以此类推）
   {"file": "qwq2.png", "data": "::qwq测试2::"}  //如上（以此类推）
  ],
  "url": "http://example-domain.com/owoName/"  //外部表情包的链接（owoName 为表情包的英文名 建议和上方名称一致，而且末尾一定要加 / ）
 }
}
```