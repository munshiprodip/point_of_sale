<?php

Route::get('/shop/settings', 'ShopController@settings')->name('shops.settings'); 
Route::post('/shop/update_settings', 'ShopController@updateSettings')->name('shops.update_settings'); 

Route::get('/invoices/list', 'InvoiceController@list')->name('invoices.list'); 
Route::get('/invoices/due_list', 'InvoiceController@dueList')->name('invoices.due_list'); 
Route::get('/invoices/details/{id}', 'InvoiceController@details')->name('invoices.details'); 
Route::get('/invoices/create', 'InvoiceController@create')->name('pos'); 
Route::post('/invoices/add_to_cart', 'InvoiceController@addToCart')->name('invoices.add_to_cart');
Route::delete('/invoices/delete_from_cart/{id}', 'InvoiceController@deleteFromCart')->name('invoices.delete_from_cart');
Route::post('/invoices/prepare', 'InvoiceController@prepare')->name('invoices.prepare');
Route::get('/invoices/print/{id}', 'InvoiceController@print')->name('invoices.print');
Route::get('/invoices/collect_due/{id}', 'InvoiceController@collectDue')->name('invoices.collect_due'); 
Route::post('/invoices/make_payment', 'InvoiceController@makePayment')->name('invoices.make_payment'); 



Route::get('/products/list', 'ProductController@list')->name('products.list'); 
Route::get('/products/create', 'ProductController@create')->name('products.create'); 
Route::get('/products/edit/{id}', 'ProductController@edit')->name('products.edit'); 
Route::patch('/products/update/{id}', 'ProductController@update')->name('products.update'); 
Route::post('/products/add_to_cart', 'ProductController@addToCart')->name('products.add_to_cart');
Route::delete('/products/delete_from_cart/{id}', 'ProductController@deleteFromCart')->name('products.delete_from_cart');
Route::post('/products/store', 'ProductController@store')->name('products.store');
Route::delete('/products/destroy/{id}', 'ProductController@destroy')->name('products.destroy');


Route::get('/requisitions/list', 'RequisitionController@list')->name('requisitions.list'); 
Route::get('/requisitions/details/{id}', 'RequisitionController@details')->name('requisitions.details'); 
Route::get('/requisitions/create', 'RequisitionController@create')->name('requisitions.create');
Route::post('/requisitions/add_to_cart', 'RequisitionController@addToCart')->name('requisitions.add_to_cart');
Route::delete('/requisitions/delete_from_cart/{id}', 'RequisitionController@deleteFromCart')->name('requisitions.delete_from_cart');
Route::post('/requisitions/prepare', 'RequisitionController@prepare')->name('requisitions.prepare');

Route::get('/purchases/list', 'PurchaseController@list')->name('purchases.list'); 
Route::get('/purchases/details/{id}', 'PurchaseController@details')->name('purchases.details'); 
Route::get('/purchases/create', 'PurchaseController@create')->name('purchases.create'); 
Route::post('/purchases/add_to_cart', 'PurchaseController@addToCart')->name('purchases.add_to_cart');
Route::delete('/purchases/delete_from_cart/{id}', 'PurchaseController@deleteFromCart')->name('purchases.delete_from_cart');
Route::post('/purchases/prepare', 'PurchaseController@prepare')->name('purchases.prepare');

Route::get('/payments/list', 'PaymentController@list')->name('payments.list'); 





Route::get('/damages/list', 'DamageItemController@list')->name('damages.list'); 
Route::post('/damages/verify', 'DamageItemController@verify')->name('damages.verify'); 
Route::post('/damages/cancel', 'DamageItemController@cancel')->name('damages.cancel'); 
Route::get('/damages/verified', 'DamageItemController@verified')->name('damages.verified'); 
Route::get('/damages/canceled', 'DamageItemController@canceled')->name('damages.canceled'); 
Route::post('/damages/store', 'DamageItemController@store')->name('damages.store');




Route::get('/cash_deposites/list', 'CashDepositeController@list')->name('cash_deposites.list'); 
Route::post('/cash_deposites/verify', 'CashDepositeController@verify')->name('cash_deposites.verify'); 
Route::get('/cash_deposites/verified', 'CashDepositeController@verified')->name('cash_deposites.verified'); 
Route::post('/cash_deposites/store', 'CashDepositeController@store')->name('cash_deposites.store');





Route::get('/reports/stock_form', 'ReportController@stock_form')->name('reports.stock_form'); 
Route::get('/reports/stock_report', 'ReportController@stock_report')->name('reports.stock_report'); 
Route::get('/reports/purchase_form', 'ReportController@purchase_form')->name('reports.purchase_form'); 
Route::get('/reports/purchase_report', 'ReportController@purchase_report')->name('reports.purchase_report'); 
Route::get('/reports/sell_form', 'ReportController@sell_form')->name('reports.sell_form'); 
Route::get('/reports/sell_report', 'ReportController@sell_report')->name('reports.sell_report'); 
Route::get('/reports/damage_form', 'ReportController@damage_form')->name('reports.damage_form'); 
Route::get('/reports/damage_report', 'ReportController@damage_report')->name('reports.damage_report'); 
Route::get('/reports/cash_deposite_form', 'ReportController@cash_deposite_form')->name('reports.cash_deposite_form'); 
Route::get('/reports/cash_deposite_report', 'ReportController@cash_deposite_report')->name('reports.cash_deposite_report'); 
