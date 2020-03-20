var rootUrl = 'https://castle.baka.show/',
    rootDir = 'docs';

var versions = [
 { title: '0.9.3', path: '/0.9.3/' }
];

versions[0].title += ' (latest)';

if (document.getElementById('version-nav')) {
 document.getElementById('version-nav').innerHTML = '';
 document.getElementById('version-nav').innerHTML += '<li>文档版本：'+versions[0].title+'<ul id="nav-main"></ul></li>';

 for (let i=0; i<versions.length; ++i) {
  document.getElementById('nav-main').innerHTML += '<li><a href="'+rootUrl+rootDir+versions[i].path+'#/">'+versions[i].title+'</a></li>';
 }
}