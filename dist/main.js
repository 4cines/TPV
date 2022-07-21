/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/js/admin-form.js":
/*!*********************************!*\
  !*** ./assets/js/admin-form.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"renderAdminForm\": () => (/* binding */ renderAdminForm)\n/* harmony export */ });\nlet renderAdminForm = () => {\r\n\r\n    let adminForm = document.querySelector('.admin-form');\r\n    let createFormButton = document.querySelector('.create-form-button');\r\n    let sendFormButton = document.querySelector('.send-form-button');\r\n    let createLayout = document.querySelector('.create-layout');\r\n    let tableContainer = document.querySelector('tbody');\r\n\r\n    if(createFormButton) {\r\n        createFormButton.addEventListener(\"click\", (event) => {\r\n            adminForm.reset(); // resetar el formulario para añadir una mesa, botón \"añadir mesa\" de la vista\r\n            document.getElementsByName('id')[0].value = '';\r\n        });\r\n    }\r\n\r\n    if(sendFormButton) {\r\n\r\n        sendFormButton.addEventListener(\"click\", (event) => {\r\n\r\n            event.preventDefault();  //comportamiento por defecto del botón (llamada GET), nosotros lo enviamos por POST, de ahí esta línea\r\n                \r\n            let sendPostRequest = async () => {\r\n                \r\n                let data = {}; // crear JSON\r\n                let formData = new FormData(adminForm); // formData: objeto nativo de JS y por () indicas el formulario. Después hay que pasar el formData a JSON para el servidor\r\n                formData.append(\"route\", adminForm.dataset.route); // = data[\"route\"] = 'addProduct'; \r\n\r\n                formData.forEach(function(value, key){ //transformamos el FormData a JSON \r\n\r\n                    if(value instanceof File && value.size > 0) {\r\n\r\n                        let file = {\r\n                            'lastMod'    : value.lastModified,\r\n                            'lastModDate': value.lastModifiedDate,\r\n                            'name'       : value.name,\r\n                            'size'       : value.size,\r\n                            'type'       : value.type,\r\n                        } \r\n\r\n                        data[key] = file;\r\n\r\n                        fetch ('upload.php', {\r\n                            method: 'POST',\r\n                            body: formData\r\n                        });\r\n                    }\r\n                    else {\r\n                        data[key] = value; // se le crea un bucle para que le adjudique una clave (campo bbdd) a cada valor (valor a introducir)\r\n                    }\r\n                });\r\n\r\n                let response = await fetch('web.php', {\r\n                    headers: {\r\n                        'Accept': 'application/json',\r\n                    },\r\n                    method: 'POST',\r\n                    body: JSON.stringify(data)\r\n                })\r\n                .then(response => {\r\n                \r\n                    if (!response.ok) throw response;\r\n\r\n                    return response.json();\r\n                })\r\n                .then(json => {\r\n\r\n                    if(json.id == \"\") { //si la id viene vacía \r\n\r\n                        let newElement = createLayout.cloneNode(true); // clonar la plantilla linea 78 admin-mesas.php\r\n                        newElement.classList.remove('d-none', 'create-layout'); // se le quita la invisibilidad y el formato formulario de admin-mesa.php\r\n                        newElement.dataset.element = json.newElement.id; // el elemento creado le meto la id para poder localizarlo \r\n\r\n                        newElement.querySelector('.delete-table-button').dataset.id = json.newElement.id; // coger la id del clonado para poder eliminarlo\r\n                        newElement.querySelector('.edit-table-button').dataset.id = json.newElement.id; // coger la id del clonado para poder eliminarlo\r\n\r\n                        Object.entries(json.newElement).forEach(([key, value]) => { \r\n                            // json.newElement es el ultimo registro de la tabla $query\r\n                            // json es un objeto\r\n                            if(newElement.querySelector(\".\" + key)){\r\n\r\n                                if(newElement.querySelector(\".\" + key).tagName == \"IMG\") {\r\n\r\n                                    newElement.querySelector(\".\" + key).src = value;\r\n                                }else{\r\n                                    newElement.querySelector(\".\" + key).innerHTML = value;\r\n                                }\r\n                            }// bucle para insertar los valores y claves que has añadido para que el js lo meta en el HTML\r\n                        });\r\n\r\n                        tableContainer.appendChild(newElement); // añadir dentro de la tabla lo clonado \r\n\r\n                        document.dispatchEvent(new CustomEvent('renderAdminTable'));\r\n\r\n                    }else{\r\n\r\n                        let element = document.querySelector(\"[data-element='\" + json.id + \"']\");\r\n\r\n                        Object.entries(json.newElement).forEach(([key, value]) => {\r\n                            if(element.querySelector(\".\" + key)){\r\n\r\n                                if(element.querySelector(\".\" + key).tagName == \"IMG\") {\r\n\r\n                                    element.querySelector(\".\" + key).src = value;\r\n                                }else{\r\n                                    element.querySelector(\".\" + key).innerHTML = value;\r\n                                }\r\n                            }\r\n                        });\r\n\r\n                        document.dispatchEvent(new CustomEvent('renderAdminTable'));\r\n                    }\r\n                })\r\n                .catch ( error =>  {\r\n                    console.log(error);\r\n                });\r\n            };\r\n\r\n            sendPostRequest();\r\n        }); \r\n    }\r\n    \r\n};\n\n//# sourceURL=webpack:///./assets/js/admin-form.js?");

/***/ }),

/***/ "./assets/js/admin-table.js":
/*!**********************************!*\
  !*** ./assets/js/admin-table.js ***!
  \**********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"renderAdminTable\": () => (/* binding */ renderAdminTable)\n/* harmony export */ });\nlet renderAdminTable = () => {\r\n\r\n    let deleteTableButtons = document.querySelectorAll('.delete-table-button');\r\n    let deleteTableModal = document.querySelector('.delete-table-modal');\r\n    let editButtons = document.querySelectorAll('.edit-table-button');\r\n\r\n    document.addEventListener(\"renderAdminTable\",( event =>{\r\n        renderAdminTable();\r\n    }), {once: true});\r\n\r\n    deleteTableButtons.forEach(deleteTableButton => {\r\n\r\n        deleteTableButton.addEventListener(\"click\", (event) => { \r\n                \r\n            deleteTableModal.dataset.id = deleteTableButton.dataset.id;//en el boton de eliminar contiene el id y lo igualas al boton del modal para eliminar\r\n            \r\n        }); \r\n    });\r\n\r\n    if(deleteTableModal) {\r\n        \r\n        deleteTableModal.addEventListener(\"click\", (event) => {\r\n\r\n            let sendPostRequest = async () => {\r\n                        \r\n                let data = {};\r\n                data[\"route\"] = deleteTableModal.dataset.route;\r\n                data[\"id\"] = deleteTableModal.dataset.id;\r\n\r\n                console.log(data['id']);\r\n               \r\n\r\n                let response = await fetch('web.php', {\r\n                    headers: {\r\n                        'Accept': 'application/json',\r\n                    },\r\n                    method: 'DELETE',\r\n                    body: JSON.stringify(data)\r\n                })\r\n                .then(response => {\r\n                \r\n                    if (!response.ok) throw response;\r\n\r\n                    return response.json();\r\n                })\r\n                .then(json => {\r\n\r\n                    document.querySelector(\"[data-element='\" + json.id + \"']\").remove(); // cada registro tiene un data-element, de esta forma se puede identificar\r\n                })\r\n                .catch ( error =>  {\r\n                    console.log(error);\r\n                });\r\n            };\r\n\r\n            sendPostRequest();\r\n\r\n        });\r\n    }\r\n\r\n    editButtons.forEach(editButton => {\r\n\r\n        editButton.addEventListener(\"click\", (event) => {\r\n                \r\n            let sendPostRequest = async () => {\r\n                        \r\n                let data = {};\r\n                data[\"route\"] = editButton.dataset.route;\r\n                data[\"id\"] = editButton.dataset.id;\r\n\r\n                let response = await fetch('web.php', {\r\n                    headers: {\r\n                        'Accept': 'application/json',\r\n                    },\r\n                    method: 'POST',\r\n                    body: JSON.stringify(data)\r\n                })\r\n                .then(response => {\r\n                \r\n                    if (!response.ok) throw response;\r\n\r\n                    return response.json();\r\n                })\r\n                .then(json => {\r\n  \r\n                    Object.entries(json.element).forEach(([key, value]) => {\r\n            \r\n                        if(document.getElementsByName(key).length > 0  && document.getElementsByName(key)[0].type != \"file\"){ // name del input del .php\r\n                            document.getElementsByName(key)[0].value = value; // [0] para poder acceder a los valores. Es standar\r\n                        }\r\n                    });\r\n                })\r\n                .catch ( error =>  {\r\n                    console.log(error);\r\n                });\r\n            };\r\n\r\n            sendPostRequest();\r\n            \r\n        }); \r\n    });\r\n};\n\n//# sourceURL=webpack:///./assets/js/admin-table.js?");

/***/ }),

/***/ "./assets/js/app.js":
/*!**************************!*\
  !*** ./assets/js/app.js ***!
  \**************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _products_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./products.js */ \"./assets/js/products.js\");\n/* harmony import */ var _tickets_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./tickets.js */ \"./assets/js/tickets.js\");\n/* harmony import */ var _sales_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./sales.js */ \"./assets/js/sales.js\");\n/* harmony import */ var _admin_table_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./admin-table.js */ \"./assets/js/admin-table.js\");\n/* harmony import */ var _admin_form_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./admin-form.js */ \"./assets/js/admin-form.js\");\n\r\n\r\n\r\n\r\n\r\n\r\n(0,_products_js__WEBPACK_IMPORTED_MODULE_0__.renderProducts)();\r\n(0,_tickets_js__WEBPACK_IMPORTED_MODULE_1__.renderTickets)();\r\n(0,_sales_js__WEBPACK_IMPORTED_MODULE_2__.renderSales)();\r\n(0,_admin_table_js__WEBPACK_IMPORTED_MODULE_3__.renderAdminTable)();\r\n(0,_admin_form_js__WEBPACK_IMPORTED_MODULE_4__.renderAdminForm)();\n\n//# sourceURL=webpack:///./assets/js/app.js?");

/***/ }),

/***/ "./assets/js/products.js":
/*!*******************************!*\
  !*** ./assets/js/products.js ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"renderProducts\": () => (/* binding */ renderProducts)\n/* harmony export */ });\nlet renderProducts = () => {\r\n\r\n    let ticketContainer = document.querySelector(\".list-group\");\r\n    let totals = document.querySelector(\".totals\");\r\n    let addProductLayout = document.querySelector(\".add-product-layout\");\r\n    let addProducts = document.querySelectorAll(\".add-product\");\r\n\r\n    addProducts.forEach(addProduct => {\r\n\r\n        addProduct.addEventListener(\"click\", (event) => {\r\n            \r\n            let sendPostRequest = async () => { // llamada async va con un await\r\n                \r\n                let data = {}; //JSON llamada al servidor enviando datos\r\n                data[\"route\"] = 'addProduct';\r\n                data[\"price_id\"] = addProduct.dataset.price;\r\n                data[\"table_id\"] = addProduct.dataset.table;\r\n    \r\n                let response = await fetch('web.php', {\r\n                    headers: {\r\n                        'Accept': 'application/json',\r\n                    },\r\n                    method: 'POST',\r\n                    body: JSON.stringify(data)\r\n                })\r\n                .then(response => {\r\n                \r\n                    if (!response.ok) throw response;\r\n    \r\n                    return response.json();\r\n                })\r\n                .then(json => {\r\n\r\n                    let product = addProductLayout.cloneNode(true);\r\n    \r\n                    product.querySelector('.delete-product').dataset.ticket = json.newProduct.id;\r\n                    product.querySelector('.img-ticket').src =  json.newProduct.imagen_url;\r\n                    product.querySelector('.categoria-prod').innerHTML =  json.newProduct.categoria;\r\n                    product.querySelector('.nombre-prod').innerHTML =  json.newProduct.nombre;\r\n                    product.querySelector('.precio-prod').innerHTML =  json.newProduct.precio_base;\r\n                    product.classList.remove('d-none', 'add-product-layout');\r\n    \r\n                    totals.querySelector('.iva-percent').innerHTML = json.total.iva;\r\n                    totals.querySelector('.base').innerHTML = json.total.base;\r\n                    totals.querySelector('.iva').innerHTML = json.total.total_iva;\r\n                    totals.querySelector('.total').innerHTML = json.total.total;\r\n    \r\n                    if(ticketContainer.querySelector('.no-products')){\r\n                        ticketContainer.querySelector('.no-products').classList.add('d-none');\r\n                        ticketContainer.appendChild(product);\r\n                    }else{\r\n                        ticketContainer.appendChild(product);\r\n                    }\r\n    \r\n                    document.dispatchEvent(new CustomEvent('renderTicket'));\r\n                })\r\n                .catch ( error =>  {\r\n                    console.log(JSON.stringify(error));\r\n                });\r\n            };\r\n    \r\n            sendPostRequest();\r\n        }); \r\n    });\r\n};\n\n//# sourceURL=webpack:///./assets/js/products.js?");

/***/ }),

/***/ "./assets/js/sales.js":
/*!****************************!*\
  !*** ./assets/js/sales.js ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"renderSales\": () => (/* binding */ renderSales)\n/* harmony export */ });\nlet renderSales = () => {\r\n\r\n    let chargeTickets = document.querySelectorAll(\".charge-ticket\");\r\n    let ticketContainer = document.querySelector(\".list-group\");\r\n    let totals = document.querySelector(\".totals\");\r\n\r\n    chargeTickets.forEach(chargeTicket => {\r\n\r\n        chargeTicket.addEventListener(\"click\", (event) => {\r\n                \r\n            let sendPostRequest = async () => { \r\n                \r\n                let data = {};\r\n                data[\"route\"] = 'chargeTicket';\r\n                data[\"table_id\"] = chargeTicket.dataset.table;\r\n                data[\"metodo_pago\"] = chargeTicket.dataset.metodopago;\r\n                            \r\n                let response = await fetch('web.php', {\r\n                    headers: {\r\n                        'Accept': 'application/json',\r\n                    },\r\n                    method: 'POST',\r\n                    body: JSON.stringify(data)\r\n                })\r\n                .then(response => {\r\n                \r\n                    if (!response.ok) throw response;\r\n\r\n                    return response.json();\r\n                })\r\n                .then(json => {\r\n                    let products = ticketContainer.querySelectorAll('li:not(.add-product-layout)');\r\n\r\n                    ticketContainer.querySelector('.no-products').classList.remove('d-none');\r\n    \r\n                    totals.querySelector('.iva-percent').innerHTML = '';\r\n                    totals.querySelector('.base').innerHTML = 0;\r\n                    totals.querySelector('.iva').innerHTML = 0;\r\n                    totals.querySelector('.total').innerHTML = 0;\r\n    \r\n                    products.forEach(product => {\r\n                        product.remove();\r\n                    });\r\n                })\r\n                .catch ( error =>  {\r\n                    console.log(JSON.stringify(error));\r\n                });\r\n            };\r\n            \r\n            sendPostRequest();\r\n\r\n        });\r\n\r\n    });\r\n\r\n}\n\n//# sourceURL=webpack:///./assets/js/sales.js?");

/***/ }),

/***/ "./assets/js/tickets.js":
/*!******************************!*\
  !*** ./assets/js/tickets.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"renderTickets\": () => (/* binding */ renderTickets)\n/* harmony export */ });\nlet renderTickets = () => {\r\n\r\n    let deleteProducts = document.querySelectorAll(\".delete-product\");\r\n    let deleteAllProducts = document.querySelector(\".delete-all-products\");\r\n    let ticketContainer = document.querySelector(\".list-group\");\r\n    let totals = document.querySelector(\".totals\");\r\n\r\n    document.addEventListener(\"renderTicket\",( event =>{\r\n        renderTickets();\r\n    }), {once: true});\r\n\r\n    deleteProducts.forEach(deleteProduct => {\r\n\r\n        deleteProduct.addEventListener(\"click\", (event) => {\r\n            \r\n            let sendPostRequest = async () => { // llamada async va con un await\r\n                \r\n                let data = {}; //JSON llamada al servidor enviando datos\r\n                data[\"route\"] = 'deleteProduct';\r\n                data[\"ticket_id\"] = deleteProduct.dataset.ticket;\r\n                data[\"table_id\"] = deleteProduct.dataset.table;\r\n    \r\n                let response = await fetch('web.php', {\r\n                    headers: {\r\n                        'Accept': 'application/json',\r\n                    },\r\n                    method: 'DELETE',\r\n                    body: JSON.stringify(data)\r\n                })\r\n                .then(response => {\r\n\r\n                    if (!response.ok) throw response;\r\n    \r\n                    return response.json();\r\n                })\r\n                .then(json => {\r\n    \r\n                    deleteProduct.parentElement.remove();\r\n\r\n                    if(json.total == false){\r\n\r\n                        ticketContainer.querySelector('.no-products').classList.remove('d-none');\r\n                        totals.querySelector('.iva-percent').innerHTML = '';\r\n                        totals.querySelector('.base').innerHTML = 0;\r\n                        totals.querySelector('.iva').innerHTML = 0;\r\n                        totals.querySelector('.total').innerHTML = 0;\r\n                        \r\n                    }else{\r\n                        totals.querySelector('.iva-percent').innerHTML = json.total.iva;\r\n                        totals.querySelector('.base').innerHTML = json.total.base;\r\n                        totals.querySelector('.iva').innerHTML = json.total.total_iva;\r\n                        totals.querySelector('.total').innerHTML = json.total.total;\r\n                    }\r\n                })\r\n                .catch ( error =>  {\r\n                    console.log(JSON.stringify(error));\r\n                });\r\n            };\r\n    \r\n            sendPostRequest();\r\n        }); \r\n    });\r\n\r\n    if(deleteAllProducts){\r\n        \r\n        deleteAllProducts.addEventListener(\"click\", (event) => {\r\n        \r\n            let sendPostRequest = async () => { \r\n                \r\n                let data = {};\r\n                data[\"route\"] = 'deleteAllProducts';\r\n                data[\"table_id\"] = deleteAllProducts.dataset.table;\r\n    \r\n                let response = await fetch('web.php', {\r\n                    headers: {\r\n                        'Accept': 'application/json',\r\n                    },\r\n                    method: 'DELETE',\r\n                    body: JSON.stringify(data)\r\n                })\r\n                .then(response => {\r\n                \r\n                    if (!response.ok) throw response;\r\n    \r\n                    return response.json();\r\n                })\r\n                .then(json => {\r\n    \r\n                    let products = ticketContainer.querySelectorAll('li:not(.add-product-layout)');\r\n    \r\n                    ticketContainer.querySelector('.no-products').classList.remove('d-none');\r\n    \r\n                    totals.querySelector('.iva-percent').innerHTML = '';\r\n                    totals.querySelector('.base').innerHTML = 0;\r\n                    totals.querySelector('.iva').innerHTML = 0;\r\n                    totals.querySelector('.total').innerHTML = 0;\r\n    \r\n                    products.forEach(product => {\r\n                        product.remove();\r\n                    });\r\n                })\r\n                .catch ( error =>  {\r\n                    console.log(JSON.stringify(error));\r\n                });\r\n            };\r\n    \r\n            sendPostRequest();\r\n        }); \r\n    \r\n    }\r\n \r\n \r\n};\n\n//# sourceURL=webpack:///./assets/js/tickets.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./assets/js/app.js");
/******/ 	
/******/ })()
;