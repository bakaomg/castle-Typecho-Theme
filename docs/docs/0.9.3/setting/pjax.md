## PJAX
- 重载刷新后失效的 JS
- 在开启 PJAX 时此设置有效，此设置在 `控制台` → `外观` → `外观设置` → `功能设置` → `PJAX 设置` → `PJAX 重载函数`

## 常用示例
### APlyaer
```javascript
loadMeting();
```

### 百度统计
```javascript
if (typeof _hmt !== 'undefined'){
 _hmt.push(['_trackPageview', location.pathname + location.search]);
}  
```

### 谷歌统计
```javascript
if (typeof ga !== 'undefined'){
 ga('send', 'pageview', location.pathname + location.search);
}
```

### Prism.js
```javascript
if (typeof Prism !== 'undefined') {
 Prism.highlightAll(true,null);
}
```

### MathJax
```javascript
if (typeof MathJax !== 'undefined'){
 MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
}
```