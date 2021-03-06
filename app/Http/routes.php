<?php

/**
 * Octipas Connect
 * Description here. 
 *
 * OpenAPI spec version: 1.0.0
 * Contact: montpellier@octipas.com
 *
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen.git
 * Do not edit the class manually.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Octipas Connect
 * @version 1.0.0
 */

$app->get('/', function () use ($app) {
    return $app->version();
});

/**
 * POST addCustomer
 * Summary: Add a new customer to the store
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->POST('/{source}/{storeId}/customer', 'CustomerApi@addCustomer');
/**
 * PUT updateCustomer
 * Summary: Update an existing customer
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->PUT('/{source}/{storeId}/customer', 'CustomerApi@updateCustomer');
/**
 * DELETE deleteCustomer
 * Summary: Deletes a customer
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->DELETE('/{source}/{storeId}/customer', 'CustomerApi@deleteCustomer');
/**
 * GET getCustomerById
 * Summary: Find customer by ID
 * Notes: Returns a single customer
 * Output-Formats: [application/json, application/xml]
 */
$app->GET('/{source}/{storeId}/customer/{customerId}', 'CustomerApi@getCustomerById');
/**
 * POST updateCustomerWithForm
 * Summary: Updates a customer in the store with form data
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->POST('/{source}/{storeId}/customer/{customerId}', 'CustomerApi@updateCustomerWithForm');
/**
 * POST uploadCustomerFile
 * Summary: uploads an image
 * Notes: 
 * Output-Formats: [application/json]
 */
$app->POST('/{source}/{storeId}/customer/{customerId}/uploadImage', 'CustomerApi@uploadCustomerFile');
/**
 * GET getAllPrestaProduct
 * Summary: Get all PrestaShop Products
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->GET('/odoo/{storeId}/product', 'ProductApi@getAllPrestaProduct');
/**
 * POST addProduct
 * Summary: Add a new product to the store
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->POST('/{source}/{storeId}/product', 'ProductApi@addProduct');
/**
 * PUT updateProduct from Odoo to Prestashop
 * Summary: Update an existing product
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->PUT('/{source}/{storeId}/product', 'ProductApi@updateProduct');
/**
 * DELETE deleteProduct from Odoo or Prestashop
 * Summary: Deletes a product
 * Notes: 
 * Output-Formats:[application/json, application/xml]
 */
$app->DELETE('/{source}/{storeId}/product', 'ProductApi@deleteProduct');
/**
 * POST addProduct
 * Summary: Add a new product to the store
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->POST('/index.php/{source}/{storeId}/product', 'ProductApi@addProduct');
/**
 * PUT updateProduct from Odoo to Prestashop
 * Summary: Update an existing product
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->PUT('/index.php/{source}/{storeId}/product', 'ProductApi@updateProduct');
/**
 * DELETE deleteProduct from Odoo or Prestashop
 * Summary: Deletes a product
 * Notes: 
 * Output-Formats:[application/json, application/xml]
 */
$app->DELETE('/index.php/{source}/{storeId}/product', 'ProductApi@deleteProduct');

/**
 * GET getProductById
 * Summary: Find product by ID
 * Notes: Returns a single product
 * Output-Formats: [application/json, application/xml]
 */
$app->GET('/product/{productId}', 'ProductApi@getProductById');
/**
 * POST updateProductWithForm
 * Summary: Updates a product in the store with form data
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->POST('/product/{productId}', 'ProductApi@updateProductWithForm');
/**
 * POST uploadProductFile
 * Summary: uploads an image
 * Notes: 
 * Output-Formats: [application/json]
 */
$app->POST('/product/{productId}/uploadImage', 'ProductApi@uploadProductFile');
/**
 * POST addProduct
 * Summary: Add a new product to the store
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->POST('/{source}/{storeId}/order', 'OrderApi@addOrder');
/**
 * PUT updateProduct from Odoo to Prestashop
 * Summary: Update an existing product
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->PUT('/{source}/{storeId}/order', 'OrderApi@updateOrder');
/**
 * DELETE deleteProduct from Odoo or Prestashop
 * Summary: Deletes a product
 * Notes: 
 * Output-Formats:[application/json, application/xml]
 */
$app->DELETE('/{source}/{storeId}/order', 'OrderApi@deleteOrder');
/**
 * POST addProduct
 * Summary: Add a new product to the store
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->POST('/{source}/{storeId}/stock', 'StockApi@addStock');
/**
 * PUT updateProduct from Odoo to Prestashop
 * Summary: Update an existing product
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->PUT('/{source}/{storeId}/stock', 'StockApi@updateStock');
/**
 * DELETE deleteProduct from Odoo or Prestashop
 * Summary: Deletes a product
 * Notes: 
 * Output-Formats:[application/json, application/xml]
 */
$app->DELETE('/{source}/{storeId}/stock', 'StockApi@deleteStock');
/**
 * GET getInventory
 * Summary: Returns customer inventories by status
 * Notes: Returns a map of status codes to quantities
 * Output-Formats: [application/json]
 */
$app->GET('/store/inventory', 'StoreApi@getInventory');
/**
 * POST placeOrder
 * Summary: Place an order for a customer
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->POST('/store/order', 'StoreApi@placeOrder');
/**
 * DELETE deleteOrder
 * Summary: Delete purchase order by ID
 * Notes: For valid response try integer IDs with positive integer value.\\ \\ Negative or non-integer values will generate API errors
 * Output-Formats: [application/json, application/xml]
 */
$app->DELETE('/store/order/{orderId}', 'StoreApi@deleteOrder');
/**
 * GET getOrderById
 * Summary: Find purchase order by ID
 * Notes: For valid response try integer IDs with value &gt;&#x3D; 1 and &lt;&#x3D; 10.\\ \\ Other values will generated exceptions
 * Output-Formats: [application/json, application/xml]
 */
$app->GET('/store/order/{orderId}', 'StoreApi@getOrderById');
/**
 * POST createUser
 * Summary: Create user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json, application/xml]
 */
$app->POST('/user', 'UserApi@createUser');
/**
 * POST createUsersWithArrayInput
 * Summary: Creates list of users with given input array
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->POST('/user/createWithArray', 'UserApi@createUsersWithArrayInput');
/**
 * POST createUsersWithListInput
 * Summary: Creates list of users with given input array
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->POST('/user/createWithList', 'UserApi@createUsersWithListInput');
/**
 * GET loginUser
 * Summary: Logs user into the system
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->GET('/user/login', 'UserApi@loginUser');
/**
 * GET logoutUser
 * Summary: Logs out current logged in user session
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->GET('/user/logout', 'UserApi@logoutUser');
/**
 * DELETE deleteUser
 * Summary: Delete user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json, application/xml]
 */
$app->DELETE('/user/{username}', 'UserApi@deleteUser');
/**
 * GET getUserByName
 * Summary: Get user by user name
 * Notes: 
 * Output-Formats: [application/json, application/xml]
 */
$app->GET('/user/{username}', 'UserApi@getUserByName');
/**
 * PUT updateUser
 * Summary: Updated user
 * Notes: This can only be done by the logged in user.
 * Output-Formats: [application/json, application/xml]
 */
$app->PUT('/user/{username}', 'UserApi@updateUser');

