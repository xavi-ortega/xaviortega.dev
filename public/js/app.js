(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app"],{

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

window.axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.baseURL = "/api";
Prism.languages.tree = {
  // Highlight symbols used to denote folder structure
  'punctuation': /^([-|+`\s]+)/gm,
  // Highlight the individual file names
  'keyword': /([a-zA-Z0-9._].+)/g
};
Prism.hooks.add('wrap', function (env) {
  // Add classnames for file extensions
  if (env.language === 'tree' && env.type === 'keyword') {
    var parts = env.content.split('.');
    while (parts.length > 1) {
      parts.shift();
      // Ex. 'foo.min.js' would become '<span class="token keyword ext-min-js ext-js">foo.min.js</span>'
      env.classes.push('ext-' + parts.join('-'));
    }
  }
});
Prism.highlightAll();

/***/ }),

/***/ "./resources/sass/about.scss":
/*!***********************************!*\
  !*** ./resources/sass/about.scss ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/article.scss":
/*!*************************************!*\
  !*** ./resources/sass/article.scss ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/welcome.scss":
/*!*************************************!*\
  !*** ./resources/sass/welcome.scss ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*****************************************************************************************************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ./resources/sass/welcome.scss ./resources/sass/about.scss ./resources/sass/article.scss ***!
  \*****************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/xavi/Workspace/xaviortega.dev/resources/js/app.js */"./resources/js/app.js");
__webpack_require__(/*! /home/xavi/Workspace/xaviortega.dev/resources/sass/app.scss */"./resources/sass/app.scss");
__webpack_require__(/*! /home/xavi/Workspace/xaviortega.dev/resources/sass/welcome.scss */"./resources/sass/welcome.scss");
__webpack_require__(/*! /home/xavi/Workspace/xaviortega.dev/resources/sass/about.scss */"./resources/sass/about.scss");
module.exports = __webpack_require__(/*! /home/xavi/Workspace/xaviortega.dev/resources/sass/article.scss */"./resources/sass/article.scss");


/***/ })

},[[0,"/js/manifest","/js/vendor"]]]);