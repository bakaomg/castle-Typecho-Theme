## 文章无图样式图标
- `indexIcon` 在文章高级设置中，且为无图时，自定义左上角图标。
- 图标请到 [MDUI Icon](https://www.mdui.org/docs/material_icon) 获取。
- 注意：仅在文章页面且样式为无图时有效。

```JSON
{
 "indexIcon": "favorite"
}
```

## 目录树自动弹出
- `tocPopup` 在文章页/独立页（不包括特殊独立页）有目录树时可强制自动弹出/禁止自动弹出目录树。
- 可能的值有 `true` (自动弹出) | `false` (禁止自动弹出)。
- 注意：此设置会无视 `外观设置` 中的 `自动弹出目录树` 设置项。

```JSON
{
 "tocPopup": true
}
```