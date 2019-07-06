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

/***/ "./resources/js/geoDist.js":
/*!*********************************!*\
  !*** ./resources/js/geoDist.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

function getAdmin(val) {
  axios.post('/Tansik/gov', {
    gov: val
  }).then(function (r) {
    if (r.data.admins === 0) {
      //No Admins
      makeDistTable(r.data.dist);
    } else {
      //Admins exist
      JSONresponse = JSON.parse(r.data);
      console.log(JSONresponse);
    }
  });
}

function getDist(val) {}

function makeDistTable(DistArr) {
  /*Create The Table START*/
  var table = document.createElement('table');
  table.id = "DistTable"; //iterate over every array(row) within Distribution Array

  var _iteratorNormalCompletion = true;
  var _didIteratorError = false;
  var _iteratorError = undefined;

  try {
    for (var _iterator = DistArr[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
      var row = _step.value;
      //Insert a new row element into the table element
      table.insertRow(); //Iterate over every index(cell) in each array(row)

      var _iteratorNormalCompletion2 = true;
      var _didIteratorError2 = false;
      var _iteratorError2 = undefined;

      try {
        for (var _iterator2 = row[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
          var cell = _step2.value;
          //While iterating over the index(cell)
          //insert a cell into the table element
          var newCell = table.rows[table.rows.length - 1].insertCell(); //add text to the created cell element

          newCell.textContent = cell;
        }
      } catch (err) {
        _didIteratorError2 = true;
        _iteratorError2 = err;
      } finally {
        try {
          if (!_iteratorNormalCompletion2 && _iterator2["return"] != null) {
            _iterator2["return"]();
          }
        } finally {
          if (_didIteratorError2) {
            throw _iteratorError2;
          }
        }
      }
    }
    /*Create The Table END*/
    //append the compiled table to the DOM

  } catch (err) {
    _didIteratorError = true;
    _iteratorError = err;
  } finally {
    try {
      if (!_iteratorNormalCompletion && _iterator["return"] != null) {
        _iterator["return"]();
      }
    } finally {
      if (_didIteratorError) {
        throw _iteratorError;
      }
    }
  }

  document.getElementById('result').innerHTML = '';
  document.getElementById('result').appendChild(table); //Coloring it

  $("#DistTable").hide().css("background-color", "cornsilk").show(1000); //Instantiate Tabular for grouping
  // // code for grouping in "after" table
  // var $rows = $(table).find('tr');
  // var items = [],
  //     itemtext = [],
  //     currGroupStartIdx = 0;
  // $rows.each(function (i) {
  //     var $this = $(this);
  //     var itemCell = $(this).find('td:eq(0)');
  //     var item = itemCell.text();
  //     itemCell.remove();
  //     if ($.inArray(item, itemtext) === -1) {
  //         itemtext.push(item);
  //         items.push([i, item]);
  //         groupRowSpan = 1;
  //         currGroupStartIdx = i;
  //         $this.data('rowspan', 1);
  //     } else {
  //         var rowspan = $rows.eq(currGroupStartIdx).data('rowspan') + 1;
  //         $rows.eq(currGroupStartIdx).data('rowspan', rowspan);
  //     }
  // });
  // $.each(items, function (i) {
  //     var $row = $rows.eq(this[0]);
  //     var rowspan = $row.data('rowspan');
  //     $row.prepend('<td rowspan="' + rowspan + '">' + this[1] + '</td>');
  // });
  // //END
  // jQuery.each($("table tr"), function () {
  //     $(this).children(":eq(1)").after($(this).children(":eq(0)"));
  // });

  $('html, body').animate({
    scrollTop: $("#result table").offset().top
  }, 2000);
}

/***/ }),

/***/ 1:
/*!***************************************!*\
  !*** multi ./resources/js/geoDist.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\TH-v2\resources\js\geoDist.js */"./resources/js/geoDist.js");


/***/ })

/******/ });