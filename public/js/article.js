/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/article.js":
/*!*********************************!*\
  !*** ./resources/js/article.js ***!
  \*********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _utils_form__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils/form */ "./resources/js/utils/form.js");

var thumbsUpElement = document.getElementById('thumbs-up');
var thumbsDownElement = document.getElementById('thumbs-down');
var article_id = document.querySelector("input[name='article_id']").value;
var commentForm = new _utils_form__WEBPACK_IMPORTED_MODULE_0__["Form"]('comment-form');
commentForm.addField('author');
commentForm.addField('body');
commentForm.addRule('body', function (value) {
  return value && value.length;
});
commentForm.addRule('userMustVote', function () {
  return thumbsUp || thumbsDown;
});
var thumbsUp = false;
var thumbsDown = false;
thumbsUpElement.addEventListener('click', function () {
  if (thumbsDown) {
    thumbsDown = false;
    thumbsDownElement.classList.remove('text-danger');
    var dislikes = parseInt(thumbsDownElement.nextSibling.textContent.trim());
    dislikes--;
    thumbsDownElement.nextSibling.textContent = " ".concat(dislikes);
  }

  if (!thumbsUp) {
    thumbsUp = true;
    thumbsUpElement.classList.add('text-primary');
    var likes = parseInt(thumbsUpElement.nextSibling.textContent.trim());
    likes++;
    thumbsUpElement.nextSibling.textContent = " ".concat(likes);
  }
});
thumbsDownElement.addEventListener('click', function () {
  if (thumbsUp) {
    thumbsUp = false;
    thumbsUpElement.classList.remove('text-primary');
    var likes = parseInt(thumbsUpElement.nextSibling.textContent.trim());
    likes--;
    thumbsUpElement.nextSibling.textContent = " ".concat(likes);
  }

  if (!thumbsDown) {
    thumbsDown = true;
    thumbsDownElement.classList.add('text-danger');
    var dislikes = parseInt(thumbsDownElement.nextSibling.textContent.trim());
    dislikes++;
    thumbsDownElement.nextSibling.textContent = " ".concat(dislikes);
  }
});
var errorFeedback = document.getElementById('error-feedback');
commentForm.onSubmit(function (data) {
  if (commentForm.isValid()) {
    hideErrors();

    if (thumbsUp) {
      data.pleased = true;
    } else if (thumbsDown) {
      data.pleased = false;
    }

    axios.post("article/".concat(article_id, "/comment"), data).then(function (response) {
      if (response.data.success) {
        var commentEl = document.createElement('div');
        commentEl.classList.add('comment', 'mb-3');
        var innerHTML = "<div class=\"comment-header mb-3\">\n                    <div class=\"comment-metadata\">\n                        <span>".concat(data.author || 'Annonymous', "</span> &nbsp;\u2022&nbsp; Now\n                    </div>");

        if (data.pleased) {
          innerHTML += "<i class=\"fas fa-thumbs-up text-primary\" title=\"".concat(data.author || 'Annonyous', " loved the article\" id=\"thumbs-up\"></i>");
        } else {
          innerHTML += "<i class=\"fas fa-thumbs-down text-danger\" title=\"".concat(data.author || 'Annonyous', " wasn't pleased by article\" id=\"thumbs-down\"></i>");
        }

        innerHTML += "</div>\n                <div class=\"comment-body\">\n                    ".concat(data.body, "\n                </div>");
        commentEl.innerHTML = innerHTML;
        commentForm.form.after(commentEl);
        commentForm.reset();
        resetFeedback();
      }
    });
  } else {
    showErrors(commentForm.getErrors());
  }
});

function hideErrors() {
  errorFeedback.innerHTML = '';
  errorFeedback.style.display = 'none';
}

function showErrors(errors) {
  errorFeedback.innerHTML = '';
  errorFeedback.style.display = 'block';

  if (errors.includes('body')) {
    errorFeedback.innerHTML += "<p>Please, leave an opinion before submitting</p>";
  }

  if (errors.includes('userMustVote')) {
    errorFeedback.innerHTML += "<p>Please, react to the article (<i class=\"fas fa-thumbs-up\"></i> or <i class=\"fas fa-thumbs-down\"></i>) before leaving an opinion</p>";
  }
}

function resetFeedback() {
  thumbsUp = false;
  thumbsDown = false;
  thumbsUpElement.classList.remove('text-primary');
  thumbsDownElement.classList.remove('text-danger');
}

/***/ }),

/***/ "./resources/js/utils/form.js":
/*!************************************!*\
  !*** ./resources/js/utils/form.js ***!
  \************************************/
/*! exports provided: Form */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Form", function() { return Form; });
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var Form = /*#__PURE__*/function () {
  function Form(form) {
    _classCallCheck(this, Form);

    this.form = document.getElementById(form);
    this.fields = {};
    this.rules = {};
  }

  _createClass(Form, [{
    key: "addField",
    value: function addField(fieldName) {
      var value = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
      this.fields[fieldName] = value;
    }
  }, {
    key: "addRule",
    value: function addRule(fieldName, rule) {
      this.rules[fieldName] = rule;
    }
  }, {
    key: "isValid",
    value: function isValid() {
      var _this = this;

      this.fetchValues();
      return Object.keys(this.rules).every(function (fieldName) {
        if (_this.fields[fieldName]) {
          return _this.rules[fieldName](_this.fields[fieldName]);
        } else {
          return _this.rules[fieldName]();
        }
      });
    }
  }, {
    key: "getErrors",
    value: function getErrors() {
      var _this2 = this;

      return Object.keys(this.rules).map(function (fieldName) {
        if (_this2.fields[fieldName]) {
          if (!_this2.rules[fieldName](_this2.fields[fieldName])) {
            return fieldName;
          }
        } else {
          console.log(fieldName);

          if (!_this2.rules[fieldName]()) {
            return fieldName;
          }
        }
      }, []);
    }
  }, {
    key: "onSubmit",
    value: function onSubmit(callback) {
      var _this3 = this;

      document.removeEventListener('submit', this.form);
      this.form.addEventListener('submit', function (e) {
        e.preventDefault();

        _this3.fetchValues();

        callback(_this3.fields);
      });
    }
  }, {
    key: "fetchValues",
    value: function fetchValues() {
      this.fields = Object.keys(this.fields).reduce(function (fields, fieldName) {
        fields[fieldName] = document.querySelector(".form-control[name='".concat(fieldName, "']")).value;
        return fields;
      }, {});
    }
  }, {
    key: "reset",
    value: function reset() {
      Object.keys(this.fields).forEach(function (fieldName) {
        document.querySelector(".form-control[name=".concat(fieldName, "]")).value = '';
      });
    }
  }]);

  return Form;
}();

/***/ }),

/***/ 1:
/*!***************************************!*\
  !*** multi ./resources/js/article.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\Datos\Personal\xaviortega.dev\resources\js\article.js */"./resources/js/article.js");


/***/ })

/******/ });