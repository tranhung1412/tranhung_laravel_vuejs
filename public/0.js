(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/Category.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/admin/Category.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  name: "Category",
  data: function data() {
    return {
      editMode: false,
      categories: {},
      itemPerPage: 2,
      numPerPageList: [2, 3, 5],
      form: new Form({
        id: '',
        name: '',
        status: 1,
        slug: '',
        created_at: ''
      }),
      error: null
    };
  },
  methods: {
    openAddCategory: function openAddCategory() {
      this.editMode = false;
      this.form.reset();
    },
    addCategory: function addCategory() {
      this.form.post('/api/admin/category', this.form).then(function (response) {
        console.log(response);
        Toast.fire({
          icon: 'success',
          title: response.data.message
        });
        $('#exampleModal').modal('hide');
        Fire.$emit('afterSaveChange');
      })["catch"](function (error) {
        console.log(error);
      });
    },
    getResults: function getResults() {
      var _this = this;

      var page = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
      var num = this.itemPerPage;
      var url;

      if (this.$store.state.search == null) {
        url = '/api/getAllCategoryPaging/' + num + '?page=' + page;
      } else {
        url = '/api/searchCategory/' + num + "?q=" + this.$store.state.search + '&page=' + page;
      }

      axios.get(url).then(function (response) {
        console.log(response.data);
        _this.categories = response.data;
      });
    },
    getAllCategory: function getAllCategory(itemPerPage) {
      var _this2 = this;

      if (this.$store.state.search != null) {
        this.search();
      } else {
        axios.get('/api/getAllCategoryPaging/' + itemPerPage).then(function (response) {
          console.log(response.data);
          _this2.categories = response.data;
        });
      }
    },
    deleteCategroy: function deleteCategroy(id, index) {
      var _this3 = this;

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then(function (result) {
        if (result.value) {
          var app = _this3;
          axios["delete"]('/api/admin/category/' + id).then(function (resp) {
            if (resp.data.status == 1) {
              // app.productTypes.splice(index, 1);
              console.log(resp);
              Swal.fire('Deleted!', 'Xoá thành công.', 'success');
              Fire.$emit('afterSaveChange');
            } else {
              Swal.fire('Lỗi!', 'Xoá thất bại. Một trường khác đang sử dụng trường này vui lòng kiểm tra lại', 'error');
            }
          })["catch"](function (resp) {// alert("Could not delete company");
            // console.log(resp)
          });
        }
      });
    },
    getCategoryById: function getCategoryById(category) {
      this.editMode = true;
      this.form.clear();
      $('#exampleModal').modal('show');
      this.form.fill(category);
    },
    updateCategory: function updateCategory() {
      this.form.put('/api/admin/category/' + this.form.id).then(function (response) {
        console.log(response);
        Toast.fire({
          icon: 'success',
          title: response.data.message
        });
        $('#exampleModal').modal('hide');
        Fire.$emit('afterSaveChange');
      })["catch"](function (error) {
        console.log(error);
      });
    },
    search: function search() {
      var _this4 = this;

      console.log(this.$store.state.search);
      axios.get('/api/searchCategory/' + this.itemPerPage + '?q=' + this.$store.state.search).then(function (response) {
        console.log(response.data);
        _this4.categories = response.data;
      });
    }
  },
  created: function created() {
    var _this5 = this;

    this.getAllCategory(this.itemPerPage);
    Fire.$on('afterSaveChange', function () {
      _this5.getAllCategory(_this5.itemPerPage);
    });
    Fire.$on('search', function () {
      if (_this5.$store.state.search != null) {
        _this5.search();
      } else {
        _this5.getAllCategory(_this5.itemPerPage);
      }
    }); // setInterval(()=>this.getAllCategory(), 5000);
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/Category.vue?vue&type=template&id=d1b3502e&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/admin/Category.vue?vue&type=template&id=d1b3502e&scoped=true& ***!
  \*****************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c(
        "button",
        {
          staticClass: "btn btn-outline-success float-right",
          attrs: { "data-toggle": "modal", "data-target": "#exampleModal" },
          on: {
            click: function($event) {
              return _vm.openAddCategory()
            }
          }
        },
        [_vm._v("Add category\n    ")]
      ),
      _vm._v(" "),
      _c("h2", { staticClass: "text-center mb-3" }, [_vm._v("All category")]),
      _vm._v(" "),
      _c("div", { staticClass: "d-flex justify-content-end" }, [
        _c("p", { staticStyle: { padding: "10px" } }, [
          _vm._v("Hiển thị số sản phẩm")
        ]),
        _vm._v(" "),
        _c(
          "select",
          {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.itemPerPage,
                expression: "itemPerPage"
              }
            ],
            staticClass: "form-control",
            class: { "is-invalid": _vm.form.errors.has("idCategory") },
            staticStyle: { width: "10%" },
            attrs: { id: "exampleFormControlSelect1" },
            on: {
              change: [
                function($event) {
                  var $$selectedVal = Array.prototype.filter
                    .call($event.target.options, function(o) {
                      return o.selected
                    })
                    .map(function(o) {
                      var val = "_value" in o ? o._value : o.value
                      return val
                    })
                  _vm.itemPerPage = $event.target.multiple
                    ? $$selectedVal
                    : $$selectedVal[0]
                },
                function($event) {
                  return _vm.getAllCategory(_vm.itemPerPage)
                }
              ]
            }
          },
          _vm._l(_vm.numPerPageList, function(item, index) {
            return _c("option", { key: index, domProps: { value: item } }, [
              _vm._v(_vm._s(item))
            ])
          }),
          0
        )
      ]),
      _vm._v(" "),
      _c(
        "sorted-table",
        {
          staticClass: "table table-bordered table-hover",
          attrs: { values: _vm.categories.data },
          scopedSlots: _vm._u([
            {
              key: "body",
              fn: function(sort) {
                return [
                  _c(
                    "tbody",
                    _vm._l(sort.values, function(value, index) {
                      return _c("tr", { key: index + "-" + value.id }, [
                        _c("td", [_vm._v(_vm._s(value.id))]),
                        _vm._v(" "),
                        _c("td", [_vm._v(_vm._s(value.name))]),
                        _vm._v(" "),
                        _c("td", [_vm._v(_vm._s(value.slug))]),
                        _vm._v(" "),
                        _c("td", [_vm._v(_vm._s(value.created_at))]),
                        _vm._v(" "),
                        _c("td", [
                          _c("div", { staticClass: "btn-group" }, [
                            _c(
                              "button",
                              {
                                staticClass: "btn btn-outline-warning",
                                attrs: {
                                  "data-target": "#exampleModal",
                                  "data-toggle": "modal"
                                },
                                on: {
                                  click: function($event) {
                                    return _vm.getCategoryById(value)
                                  }
                                }
                              },
                              [_vm._v("Edit\n                        ")]
                            ),
                            _vm._v(" "),
                            _c(
                              "button",
                              {
                                staticClass: "btn btn-outline-danger",
                                on: {
                                  click: function($event) {
                                    return _vm.deleteCategroy(value.id, index)
                                  }
                                }
                              },
                              [_vm._v("Delete\n                        ")]
                            )
                          ])
                        ])
                      ])
                    }),
                    0
                  )
                ]
              }
            }
          ])
        },
        [
          _c("thead", [
            _c("tr", [
              _c(
                "th",
                {
                  staticStyle: { "text-align": "left", width: "10rem" },
                  attrs: { scope: "col" }
                },
                [_c("sort-link", { attrs: { name: "id" } }, [_vm._v("ID")])],
                1
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticStyle: { "text-align": "left", width: "10rem" },
                  attrs: { scope: "col" }
                },
                [
                  _c("sort-link", { attrs: { name: "name" } }, [_vm._v("Name")])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticStyle: { "text-align": "left", width: "10rem" },
                  attrs: { scope: "col" }
                },
                [
                  _c("sort-link", { attrs: { name: "slug" } }, [_vm._v("Slug")])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticStyle: { "text-align": "left", width: "10rem" },
                  attrs: { scope: "col" }
                },
                [
                  _c("sort-link", { attrs: { name: "created_at" } }, [
                    _vm._v("Created at")
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "th",
                {
                  staticStyle: { "text-align": "left", width: "10rem" },
                  attrs: { scope: "col" }
                },
                [_vm._v("\n                Action\n            ")]
              )
            ])
          ])
        ]
      ),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "d-flex justify-content-center" },
        [
          _c("pagination", {
            staticClass: "text-center mb-3",
            staticStyle: { width: "auto" },
            attrs: { data: _vm.categories },
            on: { "pagination-change-page": _vm.getResults }
          })
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "modal fade",
          attrs: {
            id: "exampleModal",
            tabindex: "-1",
            role: "dialog",
            "aria-labelledby": "exampleModalLabel",
            "aria-hidden": "true"
          }
        },
        [
          _c(
            "div",
            {
              staticClass: "modal-dialog modal-lg",
              attrs: { role: "document" }
            },
            [
              _c("div", { staticClass: "modal-content" }, [
                _c("div", { staticClass: "modal-header" }, [
                  _vm.editMode
                    ? _c("h5", { staticClass: "modal-title text-success" }, [
                        _vm._v("Edit\n                        category")
                      ])
                    : _c("h5", { staticClass: "modal-title text-success" }, [
                        _vm._v("Add\n                        category")
                      ]),
                  _vm._v(" "),
                  _vm._m(0)
                ]),
                _vm._v(" "),
                _c(
                  "form",
                  {
                    on: {
                      submit: function($event) {
                        $event.preventDefault()
                        _vm.editMode ? _vm.updateCategory() : _vm.addCategory()
                      }
                    }
                  },
                  [
                    _c("div", { staticClass: "modal-body" }, [
                      _c(
                        "div",
                        { staticClass: "form-group" },
                        [
                          _c("label", [_vm._v("Category name")]),
                          _vm._v(" "),
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.form.name,
                                expression: "form.name"
                              }
                            ],
                            staticClass: "form-control",
                            class: {
                              "is-invalid": _vm.form.errors.has("name")
                            },
                            attrs: { type: "text", name: "name" },
                            domProps: { value: _vm.form.name },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(_vm.form, "name", $event.target.value)
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c("has-error", {
                            attrs: { form: _vm.form, field: "name" }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "form-group" },
                        [
                          _c("label", [_vm._v("Category slug")]),
                          _vm._v(" "),
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.form.slug,
                                expression: "form.slug"
                              }
                            ],
                            staticClass: "form-control",
                            class: {
                              "is-invalid": _vm.form.errors.has("slug")
                            },
                            attrs: { type: "text", name: "slug" },
                            domProps: { value: _vm.form.slug },
                            on: {
                              input: function($event) {
                                if ($event.target.composing) {
                                  return
                                }
                                _vm.$set(_vm.form, "slug", $event.target.value)
                              }
                            }
                          }),
                          _vm._v(" "),
                          _c("has-error", {
                            attrs: { form: _vm.form, field: "slug" }
                          })
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c("fieldset", { staticClass: "form-group" }, [
                        _c("div", { staticClass: "row" }, [
                          _c(
                            "legend",
                            { staticClass: "col-form-label col-sm-2 pt-0" },
                            [_vm._v("Status")]
                          ),
                          _vm._v(" "),
                          _c("div", { staticClass: "col-sm-10" }, [
                            _c("div", { staticClass: "form-check" }, [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.form.status,
                                    expression: "form.status"
                                  }
                                ],
                                staticClass: "form-check-input",
                                attrs: {
                                  type: "radio",
                                  name: "publication_status",
                                  id: "publication_status",
                                  value: "1",
                                  checked: ""
                                },
                                domProps: {
                                  checked: _vm._q(_vm.form.status, "1")
                                },
                                on: {
                                  change: function($event) {
                                    return _vm.$set(_vm.form, "status", "1")
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c(
                                "label",
                                {
                                  staticClass: "form-check-label",
                                  attrs: { for: "publication_status" }
                                },
                                [
                                  _vm._v(
                                    "\n                                            Published\n                                        "
                                  )
                                ]
                              )
                            ]),
                            _vm._v(" "),
                            _c("div", { staticClass: "form-check" }, [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.form.status,
                                    expression: "form.status"
                                  }
                                ],
                                staticClass: "form-check-input",
                                attrs: {
                                  type: "radio",
                                  name: "publication_status",
                                  id: "unpublished",
                                  value: "0"
                                },
                                domProps: {
                                  checked: _vm._q(_vm.form.status, "0")
                                },
                                on: {
                                  change: function($event) {
                                    return _vm.$set(_vm.form, "status", "0")
                                  }
                                }
                              }),
                              _vm._v(" "),
                              _c(
                                "label",
                                {
                                  staticClass: "form-check-label",
                                  attrs: { for: "unpublished" }
                                },
                                [
                                  _vm._v(
                                    "\n                                            Unpublished\n                                        "
                                  )
                                ]
                              )
                            ])
                          ])
                        ])
                      ])
                    ]),
                    _vm._v(" "),
                    _vm._m(1)
                  ]
                )
              ])
            ]
          )
        ]
      )
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "button",
      {
        staticClass: "close",
        attrs: {
          type: "button",
          "data-dismiss": "modal",
          "aria-label": "Close"
        }
      },
      [_c("span", { attrs: { "aria-hidden": "true" } }, [_vm._v("×")])]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "modal-footer" }, [
      _c(
        "button",
        {
          staticClass: "btn btn-secondary",
          attrs: { type: "button", "data-dismiss": "modal" }
        },
        [_vm._v("Close\n                        ")]
      ),
      _vm._v(" "),
      _c(
        "button",
        { staticClass: "btn btn-primary", attrs: { type: "submit" } },
        [
          _vm._v(
            "Save\n                            changes\n                        "
          )
        ]
      )
    ])
  }
]
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/admin/Category.vue":
/*!****************************************************!*\
  !*** ./resources/js/components/admin/Category.vue ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Category_vue_vue_type_template_id_d1b3502e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Category.vue?vue&type=template&id=d1b3502e&scoped=true& */ "./resources/js/components/admin/Category.vue?vue&type=template&id=d1b3502e&scoped=true&");
/* harmony import */ var _Category_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Category.vue?vue&type=script&lang=js& */ "./resources/js/components/admin/Category.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Category_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Category_vue_vue_type_template_id_d1b3502e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Category_vue_vue_type_template_id_d1b3502e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "d1b3502e",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/admin/Category.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/admin/Category.vue?vue&type=script&lang=js&":
/*!*****************************************************************************!*\
  !*** ./resources/js/components/admin/Category.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Category_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Category.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/Category.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Category_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/admin/Category.vue?vue&type=template&id=d1b3502e&scoped=true&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/components/admin/Category.vue?vue&type=template&id=d1b3502e&scoped=true& ***!
  \***********************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Category_vue_vue_type_template_id_d1b3502e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Category.vue?vue&type=template&id=d1b3502e&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/Category.vue?vue&type=template&id=d1b3502e&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Category_vue_vue_type_template_id_d1b3502e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Category_vue_vue_type_template_id_d1b3502e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);