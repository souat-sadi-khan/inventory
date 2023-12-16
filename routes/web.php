<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');

// install Middleware
Route::group(['middleware' => ['install']], function () {

    // Check Registration is on or off
    Auth::routes(['register' => (get_option('registration') && get_option('registration') == 0 ? false : true)]);

    
    // ::::::::::::::::::::::::::::::  Admin Route ::::::::::::::::::::::::
    Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

        // ::::::::::::::::::::::::::::::: Admin Profile ::::::::::::::::::::::::::::::::::::::
        Route::get('/me', 'ProfileController@index')->name('me');
        Route::get('/my-activity/datatable', 'ProfileController@datatable')->name('my-activity.datatable');
        Route::post('/profile/personal-info-change', 'ProfileController@personal_info_change')->name('profile.personal-info-change');
        Route::post('change-password', 'ProfileController@changepassword')->name('change.password');
        Route::post('change-social', 'ProfileController@changesocial')->name('change.social');
        Route::post('change-other', 'ProfileController@changeother')->name('change.other');

        // :::::::::::::::::::::::::::::: Settings Part ::::::::::::::::::::::::::::::::::::::::
        Route::post('settings', 'SettingsController@store')->name('settings');
        Route::get('settings/general', 'SettingsController@general_settings')->name('general.settings');

        // :::::::::::::::::::::::::::::: Account Part ::::::::::::::::::::::::::::::::::::::::
        Route::get('account/datatable', 'Account\AccountController@datatable')->name('account.datatable');
        Route::get('account/table/{id}', 'Account\AccountController@table')->name('account.table');
        Route::get('account/show_data/{id}', 'Account\AccountController@show_data')->name('account.show_data');
        Route::get('account-trans/edit/{id}', 'Account\AccountController@trans_edit')->name('account-trans.edit');
        Route::patch('account-trans/update/{id}', 'Account\AccountController@trans_update')->name('account-trans.update');
        Route::patch('account-trans/deposit-update/{id}', 'Account\AccountController@deposit_update')->name('account-trans.deposit_update');
        Route::patch('account-trans/withdraw-update/{id}', 'Account\AccountController@withdraw_update')->name('account-trans.withdraw_update');
        Route::any('account-trans/destroy/{id}', 'Account\AccountController@trans_destroy')->name('account-trans.destroy');
        Route::get('account-trans/index/', 'Account\AccountController@trans_index')->name('account-trans.index');
        Route::get('account-trans/datatable', 'Account\AccountController@trans_datatable')->name('account-trans.datatable');
        Route::resource('account', 'Account\AccountController');

        // :::::::::::::::::::::::::::::: Account Transcation Part ::::::::::::::::::::::::::::::::::::::::
        Route::get('vaucher/opening-balance', 'Account\AccountTransactionController@opening_balance')->name('vaucher.opening_balance');
        Route::post('vaucher/ob_store', 'Account\AccountTransactionController@ob_store')->name('vaucher.ob_store');
        Route::get('vaucher/opening-balance/print/{id}', 'Account\AccountTransactionController@opening_balance_print')->name('vaucher.opening_balance.print');
        Route::get('vaucher/deposit', 'Account\AccountTransactionController@deposit')->name('vaucher.deposit');
        Route::get('vaucher/balance_check', 'Account\AccountTransactionController@balance_check')->name('vaucher.balance_check');
        Route::post('vaucher/deposit_store', 'Account\AccountTransactionController@deposit_store')->name('vaucher.deposit_store');
        Route::get('vaucher/deposit/print/{id}', 'Account\AccountTransactionController@deposit_print')->name('vaucher.deposit.print');
        // payment section
        Route::get('vaucher/withdraw', 'Account\AccountTransactionController@withdraw')->name('vaucher.withdraw');
        Route::post('vaucher/withdraw_store', 'Account\AccountTransactionController@withdraw_store')->name('vaucher.withdraw_store');
        Route::get('vaucher/withdraw/print/{id}', 'Account\AccountTransactionController@withdraw_print')->name('vaucher.withdraw.print');
        Route::get('vaucher/contra', 'Account\AccountTransactionController@contra')->name('vaucher.contra');
        Route::post('vaucher/contra_store', 'Account\AccountTransactionController@contra_store')->name('vaucher.contra_store');
        
        // Journal Vaucher
        Route::get('vaucher/journal', 'Account\AccountTransactionController@journal')->name('vaucher.journal');
        Route::get('vaucher/journal_data', 'Account\AccountTransactionController@journal_data')->name('vaucher.journal_data');
        Route::post('vaucher/journal_store', 'Account\AccountTransactionController@journal_store')->name('vaucher.journal_store');
        
        // debit Note
        Route::get('vaucher/debit', 'Account\AccountTransactionController@debit')->name('vaucher.debit');
        Route::post('vaucher/debit_store', 'Account\AccountTransactionController@debit_store')->name('vaucher.debit_store');
        // Credit Note
        Route::get('vaucher/credit', 'Account\AccountTransactionController@credit')->name('vaucher.credit');
        Route::post('vaucher/credit_store', 'Account\AccountTransactionController@credit_store')->name('vaucher.credit_store');

        // Income
        Route::get('vaucher/income', 'Account\AccountTransactionController@income')->name('vaucher.income');
        Route::post('vaucher/income_store', 'Account\AccountTransactionController@income_store')->name('vaucher.income_store');
          Route::get('vaucher/income/print/{id}', 'Account\AccountTransactionController@income_print')->name('vaucher.income.print');

        // Vaucher Entry
        Route::get('vaucher/vaucher', 'Account\AccountTransactionController@vaucher')->name('vaucher.vaucher');
        Route::post('vaucher/vaucher_store', 'Account\AccountTransactionController@vaucher_store')->name('vaucher.vaucher_store');
          Route::get('vaucher/vaucher/print/{id}', 'Account\AccountTransactionController@vaucher_print')->name('vaucher.vaucher.print');
        
        // Expense
        Route::get('vaucher/expense', 'Account\AccountTransactionController@expense')->name('vaucher.expense');
        Route::post('vaucher/expense_store', 'Account\AccountTransactionController@expense_store')->name('vaucher.expense_store');
        Route::get('vaucher/expense/print/{id}', 'Account\AccountTransactionController@expense_print')->name('vaucher.expense.print');
        
        // Loan
        Route::get('vaucher/loan', 'Account\AccountTransactionController@loan')->name('vaucher.loan');
        Route::get('vaucher/loan_pay', 'Account\AccountTransactionController@loan_pay')->name('vaucher.loan_pay');
        Route::post('vaucher/loan_store', 'Account\AccountTransactionController@loan_store')->name('vaucher.loan_store');
        Route::get('vaucher/loan-recieved/print/{id}', 'Account\AccountTransactionController@loan_received_print')->name('vaucher.loan_received_print.print');
        Route::post('vaucher/loan_pay_store', 'Account\AccountTransactionController@loan_pay_store')->name('vaucher.loan_pay_store');
        Route::get('vaucher/loan-pay/print/{id}', 'Account\AccountTransactionController@loan_pay_print')->name('vaucher.loan_pay_print.print');




        Route::resource('vaucher', 'Account\AccountTransactionController');


        // Fiexd Assets
        Route::get('fixed-assets/datatable', 'Account\FixedAssetsController@datatable')->name('fixed-assets.datatable');
        Route::get('fixed-assets/add_category', 'Account\FixedAssetsController@add_category')->name('fiexd-assets.add_category');
        Route::get('fixed-assets/assets_datatable', 'Account\FixedAssetsController@assets_datatable')->name('fixed-assets.assets_datatable');
        Route::post('fixed-assets/category_store', 'Account\FixedAssetsController@category_store')->name('fiexd-assets.category_store');
        Route::patch('fixed-assets/category_update/{id}', 'Account\FixedAssetsController@category_update')->name('fiexd-assets.category_update');

        Route::get('fixed-assets/category_edit/{id}', 'Account\FixedAssetsController@category_edit')->name('fiexd-assets-category.edit');
        Route::resource('fiexd-assets', 'Account\FixedAssetsController');


        // :::::::::::::::::::::::::::::  Report Section ::::::::::::::::::::::::::::::::::::::::: 
        Route::get('report/index', 'ReportController@index')->name('report.index');
        Route::get('report/trial-balance', 'ReportController@trial_balance')->name('report.trial_balance');
        Route::get('report/trial-balance-show', 'ReportController@trial_balance_show')->name('report.trial_balance_show');


        Route::get('report/ledger-book', 'ReportController@day_book')->name('report.ledger_book');
        Route::get('report/ledger-book-show', 'ReportController@day_book_show')->name('report.ledger_book_show');
        Route::get('report/ledger-book-category/{category}', 'ReportController@ledger_book_category')->name('report.category');
        Route::get('report/ledger-book-supplier/{id}', 'ReportController@ledger_book_supplier')->name('report.supplier');
        Route::get('report/ledger-book-customer/{id}', 'ReportController@ledger_book_customer')->name('report.customer');
        Route::get('report/ledger-book-name/{id}', 'ReportController@ledger_book_name')->name('report.ledger-book.name');

        // Day book
        Route::get('report/day-book', 'ReportController@original_day_book_show')->name('report.day_book');
        Route::get('get-day-book-report', 'ReportController@get_day_book_report')->name('get_day_book_report');

        Route::get('report/receipt-payment-register', 'ReportController@recept_payment')->name('report.recept_payment');
        Route::get('report/receipt-payment-register-show', 'ReportController@recept_payment_show')->name('report.recept_payment_show');

        // Loan Report
        Route::get('report/loan', 'ReportController@loan')->name('report.loan');
        Route::get('report/loan-show', 'ReportController@loan_show')->name('report.loan_show');
        Route::get('report/loan-unique/{id}', 'ReportController@loan_unique')->name('report.loan.unique');

        Route::get('report/cash-bank-book', 'ReportController@cashbank_book')->name('report.cashbank_book');
        Route::get('report/balance-sheet', 'ReportController@balance_sheet')->name('report.balance_sheet');

        // customre-due
        Route::get('report/customre-due', 'ReportController@customer_due')->name('report.customre-due');
        Route::get('report/show-customer-due-report', 'ReportController@customer_due_ajax')->name('report.show-customer-due-report');
        Route::get('report/customer-due/unique-customer/{id}', 'ReportController@unique_customer')->name('report.customer-due.unique-customer');

        // supplier-due
        Route::get('report/supplier-due', 'ReportController@supplier_due')->name('report.supplier-due');
        Route::get('report/show-supplier-due-report', 'ReportController@supplier_due_ajax')->name('report.show-supplier-due-report');
        Route::get('report/supplier-due/unique-supplier/{id}', 'ReportController@unique_supplier')->name('report.supplier-due.unique-supplier');

        // direct-income
        Route::get('report/direct-income', 'ReportController@direct_income')->name('report.direct-income');
        Route::get('report/direct-income-show', 'ReportController@direct_income_show')->name('report.direct-income-show');

        // direct-expense
        Route::get('report/direct-expense', 'ReportController@direct_expense')->name('report.direct-expense');
        Route::get('report/direct-expense-show', 'ReportController@direct_expense_show')->name('report.direct-expense-show');


        // :::::::::::::::::::::::::::::  LOan Manage ::::::::::::::::::::::::::::::::::::::::: 
        Route::get('loan/summary/datatable', 'LoanController@summaryDatatable')->name('loan.summary.datatable');
        Route::get('loan/datatable', 'LoanController@datatable')->name('loan.datatable');
        Route::get('loan/summery', 'LoanController@summery')->name('loan.summery');
        Route::get('loan/pay/{id}', 'LoanController@pay')->name('loan.pay');
        Route::post('loan/pay-amount', 'LoanController@pay_amount')->name('loan.pay-amount');
        Route::resource('loan', 'LoanController');

        // ::::::::::::::::::::::::::::::  Customer Manage ::::::::::::::::::::::::::::::::::::::: 
        Route::get('customer/datatable', 'CustomerController@datatable')->name('customer.datatable');
        Route::get('quick-customer','CustomerController@quick_add')->name('quick_customer');
        Route::post('quick-customer','CustomerController@postquick_add')->name('postquick_customer');
        Route::get('customer/payment-list/{id}','TransactionPaymentController@getCustomerPayment');
        Route::get('customer/make-payment/{id}','CustomerController@make_payment')->name('customer.make_payment');
        Route::resource('customer', 'CustomerController');

        // :::::::::::::::::::::::::::::: Supplier Manage ::::::::::::::::::::::::::::::::
        Route::get('supplier/datatable', 'SupplierController@datatable')->name('supplier.datatable');
        Route::get('make-payment/{id}','SupplierController@make_payment')->name('supplier.make_payment');
        Route::get('supplier/payment-list/{id}','TransactionPaymentController@getSupplierPayment');
        Route::resource('supplier', 'SupplierController');

        // :::::::::::::::::::::::::::::: Product Initialize :::::::::::::::::::::::::::::::: 
        Route::group(['as' => 'product-initiazile.', 'prefix' => 'product-initiazile', 'namespace' => 'Product'], function () {
            // :::::::::::::::::::::::::::: Product Category :::::::::::::::::::::::::::: 
            Route::get('category/datatable', 'CategoryController@datatable')->name('category.datatable');
            Route::post('category/get-category', 'CategoryController@get_category')->name('category.get_category');
            Route::resource('category', 'CategoryController');

            // ::::::::::::::::::::::::::::: Product Brand :::::::::::::::::::::::::::::::::::: 
            Route::get('brand/datatable', 'BrandController@datatable')->name('brand.datatable');
            Route::resource('brand', 'BrandController');

            // ::::::::::::::::::::::::::::: Product Unit :::::::::::::::::::::::::::::::::::: 
            Route::get('unit/datatable', 'UnitController@datatable')->name('unit.datatable');
            Route::resource('unit', 'UnitController');

            // ::::::::::::::::::::::::::::: Product Box :::::::::::::::::::::::::::::::::::: 
            Route::get('box/datatable', 'BoxController@datatable')->name('box.datatable');
            Route::resource('box', 'BoxController');

            // ::::::::::::::::::::::::::::: Taxrate :::::::::::::::::::::::::::::::::::: 
            Route::get('taxrate/datatable', 'TaxRateController@datatable')->name('taxrate.datatable');
            Route::resource('taxrate', 'TaxRateController');
        });
        
        // :::::::::::::::::::::::::::::: Product Section :::::::::::::::::::::::::::::::: 
        Route::group(['as' => 'products.', 'prefix' => 'products', 'namespace' => 'Product'], function () {
            // ::::::::::::::::::::::::::::: Product :::::::::::::::::::::::::::::::::::: 
            Route::get('products/datatable', 'ProductsController@datatable')->name('products.datatable');
            Route::get('product-filter','ProductsController@product_filter')->name('product_filter');
            Route::resource('products', 'ProductsController');

            // ::::::::::::::::::::::::::::: Add Category From Product Page :::::::::::::::::::::::::
            Route::get('open-category-form', 'ProductsController@add_category')->name('products.add_category');
            Route::post('submit-category-form', 'ProductsController@save_category')->name('products.save_category');

            // ::::::::::::::::::::::::::::: Add Supplier From Product Page :::::::::::::::::::::::::
            Route::get('open-supplier-form', 'ProductsController@add_supplier')->name('products.add_supplier');
            Route::post('submit-supplier-form', 'ProductsController@save_supplier')->name('products.save_supplier');

            // ::::::::::::::::::::::::::::: Add Brand From Product Page :::::::::::::::::::::::::
            Route::get('open-brand-form', 'ProductsController@add_brand')->name('products.add_brand');
            Route::post('submit-brand-form', 'ProductsController@save_brand')->name('products.save_brand');

            // ::::::::::::::::::::::::::::: Add Box From Product Page :::::::::::::::::::::::::
            Route::get('open-box-form', 'ProductsController@add_box')->name('products.add_box');
            Route::post('submit-box-form', 'ProductsController@save_box')->name('products.save_box');

            // ::::::::::::::::::::::::::::: Add Unit From Product Page :::::::::::::::::::::::::
            Route::get('open-unit-form', 'ProductsController@add_unit')->name('products.add_unit');
            Route::post('submit-unit-form', 'ProductsController@save_unit')->name('products.save_unit');

            // ::::::::::::::::::::::::::::: Add Tax From Product Page :::::::::::::::::::::::::
            Route::get('open-tax-form', 'ProductsController@add_tax')->name('products.add_tax');
            Route::post('submit-tax-form', 'ProductsController@save_tax')->name('products.save_tax');
		});

        // ::::::::::::::::::::::::::::: purchase ::::::::::::::::::::::::::::::::::::::::::
     Route::group(['as' => 'pur_voucher.', 'prefix' => 'purchase-voucher'],function () {
          Route::resource('purchase','PurchaseController');
          Route::get('product','PurchaseController@product');
          Route::get('add-product','PurchaseController@product_row');
          Route::get('view/{id}','PurchaseController@view')->name('view');
          Route::get('purchase/payment/{id}','PurchaseController@payment')->name('purchase_payment');
          Route::get('purchase/print-payment/{id}','PurchaseController@printpayment')->name('purchase.printpayment');
         
          Route::resource('return','PurchaseReturnController');
          Route::get('return-check','PurchaseReturnController@return_check');
          Route::get('return-add/{id}','PurchaseReturnController@add_return')->name('add_return');
          Route::get('return/print/{id}','PurchaseReturnController@view')->name('return_print');

     });

      // ::::::::::::::::::::::::::::: sale ::::::::::::::::::::::::::::::::::::::::::
     Route::group(['as' => 'sale_voucher.', 'prefix' => 'sale-voucher'],function () {
         Route::resource('sale','SaleController');
         Route::get('product','SaleController@product');
         Route::get('add-product','SaleController@product_row');
         Route::get('view/{id}','SaleController@view')->name('view');
         Route::get('sale/payment/{id}','SaleController@payment')->name('sale_payment');
         Route::get('sale/print-payment/{id}','SaleController@printpayment')->name('sale.printpayment');

          Route::resource('return','SaleReturnController');
          Route::get('return-check','SaleReturnController@return_check');
          Route::get('return-add/{id}','SaleReturnController@add_return')->name('add_return');
          Route::get('return/print/{id}','SaleReturnController@view')->name('return_print');
     });

      // ::::::::::::::::::::::::::::: Transaction Payment ::::::::::::::::::::::::::::::::::::::::::
      Route::post('purchase/payment','TransactionPaymentController@purchase_payment')->name('post_purchase_payment');
      Route::post('sale/payment','TransactionPaymentController@sale_payment')->name('post_sale_payment');
      Route::post('supplier/payment','TransactionPaymentController@postPaySupplierDue')->name('postPaySupplierDue');
      Route::post('customer/payment','TransactionPaymentController@postPayCustomerDue')->name('postPayCustomerDue');
      Route::get('customer/opening_payment/{id}','TransactionPaymentController@customer_opening_payment_print')->name('customer_opening_payment_print');
      Route::get('supplier/opening_payment/{id}','TransactionPaymentController@supplier_opening_payment_print')->name('supplier_opening_payment_print');



        // ::::::::::::::::::::::::::::: Vehicle Section ::::::::::::::::::::::::::::::::::::::::::
        Route::get('vehicle-type/datatable', 'Vehicle\VehicleTypeController@datatable')->name('vehicle-type.datatable');
        Route::resource('vehicle-type', 'Vehicle\VehicleTypeController');
        Route::get('vehicle/datatable', 'Vehicle\VehicleController@datatable')->name('vehicle.datatable');
        Route::get('vehicle/trans/{id}', 'Vehicle\VehicleController@trans')->name('vehicle.trans');



        Route::get('vehicle/report', 'Vehicle\VehicleController@report')->name('report.vehicle');
        Route::get('report/vehicle_show', 'Vehicle\VehicleController@vehicle_show')->name('report.vehicle_show');

        Route::get('vehicle/vehicle-income', 'Vehicle\VehicleController@report_income')->name('report.vehicle-income');
        Route::get('report/vehicle_income_show', 'Vehicle\VehicleController@vehicle_income_show')->name('report.vehicle_income_show');

        Route::get('report/vehicle-show-income/{id}', 'Vehicle\VehicleController@vehicle_show_income')->name('report.vehicle-show-income');

        Route::get('report/vehicle-show-expence/{id}', 'Vehicle\VehicleController@vehicle_show_expence')->name('report.vehicle-show-expence');


        Route::resource('vehicle', 'Vehicle\VehicleController');


        Route::get('vehicle-transaction/datatable', 'Vehicle\VehicleTransactionController@datatable')->name('vehicle-transaction.datatable');
        Route::get('vehicle-transaction/data', 'Vehicle\VehicleTransactionController@data')->name('vehicle-transaction.data');
        Route::resource('vehicle-transaction', 'Vehicle\VehicleTransactionController');

        // ::::::::::::::::::::::::::::: User Role Permission :::::::::::::::::::::::::::::::::::::::  
        Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
			Route::get('/role', 'RoleController@index')->name('role');
			Route::get('/role/datatable', 'RoleController@datatable')->name('role.datatable');
			Route::post('/role/store', 'RoleController@store')->name('role.store');
			Route::get('/role/edit/{id}', 'RoleController@edit')->name('role.edit');
			Route::post('/role/edit', 'RoleController@update')->name('role.update');
			Route::delete('/role/delete/{id}', 'RoleController@destroy')->name('role.delete');
			//user:::::::::::::::::::::::::::::::::
			Route::get('/', 'UserController@index')->name('index');
			Route::any('/store', 'UserController@store')->name('store');
			Route::put('/change/{value}/{id}', 'UserController@status')->name('change');
			Route::get('/edit/{id}', 'UserController@edit')->name('edit');
			Route::put('/edit/{id}', 'UserController@update')->name('update');
			Route::delete('/delete/{id}', 'UserController@destroy')->name('delete');
		});


        //Sales Report:::::::::::::::
        Route::get('report/sales-report','SalesReportController@index')->name('report.sales_report');
        Route::get('report/sales','SalesReportController@sales')->name('report.sales');
        Route::get('report/sales','SalesReportController@sales')->name('report.sales');
        Route::get('get_sales_report','SalesReportController@get_sales_report');
        Route::get('report/sales-payment','SalesReportController@sales_payment')->name('report.sales_payment');
        Route::get('get_salespayment_report','SalesReportController@get_salespayment_report');
        Route::get('report/sales-return','SalesReportController@sales_return')->name('report.sales_return');
        Route::get('get_sale_return_report','SalesReportController@get_sale_return_report');
        Route::get('report/category-sale','SalesReportController@category_sale')->name('report.category_sale');
        Route::get('get_category_sale_report','SalesReportController@get_category_sale_report');
        Route::get('brand_sale','SalesReportController@brand_sale')->name('report.brand_sale');
        Route::get('get_brand_sale_report','SalesReportController@get_brand_sale_report');
        //Purchase Report:::::::::::::
        Route::get('report/purchase-report','PurchaseReportController@index')->name('report.purchase_report');
        Route::get('report/purchase','PurchaseReportController@purchase')->name('report.purchase');
        // Route::get('report/purchase','PurchaseReportController@purchase')->name('report.purchase');
        Route::get('get_purchase_report','PurchaseReportController@get_purchase_report');
        Route::get('report/purchase-payment','PurchaseReportController@purchase_payment')->name('report.purchase_payment');
        Route::get('get_purchasepayment_report','PurchaseReportController@get_purchasepayment_report');
        Route::get('report/purchase-return','PurchaseReportController@purchase_return')->name('report.purchase_return');
        Route::get('get_purchase_return_report','PurchaseReportController@get_purchase_return_report');

        //Profit loss
        Route::get('report/profit-loss','ReportController@profit_loss')->name('report.profit_loss');
        //Product Report
        Route::get('report/product-report','ReportController@product_report')->name('report.product_report');
        Route::get('report/today-product-report','ReportController@today_product_report')->name('report.today_product_report');

        //Payment Account
        Route::get('payment/account','Account\AccountTransactionController@account_payment')->name('Payment_account');
        Route::get('payment/account/list/{id}','Account\AccountTransactionController@account_list')->name('accounting.getLinkAccount');
        Route::post('payment/postacountlist','Account\AccountTransactionController@postLinkAccount')->name('accounting.postLinkAccount');

    });

    Route::get('today','HomeController@today')->name('today');
    Route::get('invoice-layout','HomeController@invoice_layout')->name('invoice_layout');
    Route::get('invoice-layout/invoice','HomeController@invoice_layout_create')->name('layout.invoice');
    Route::post('invoice-layout/invoice','HomeController@invoice_layout_update')->name('layout.invoice_post');
    Route::get('/home', 'HomeController@index')->name('admin.home');

});

// :::::::::::::::::::::::::: Installation Route :::::::::::::::::::::::::::::::::::::::::::::::::
Route::get('pre-setup', 'Install\InstallController@index');
Route::get('pre-setup/database', 'Install\InstallController@database');
Route::post('pre-setup/process_install', 'Install\InstallController@process_install');
Route::post('pre-setup/store_user', 'Install\InstallController@store_user');
Route::post('pre-setup/finish', 'Install\InstallController@final_touch');

// ::::::::::::::::::::::::: Sadik LOg :::::::::::::::::::::::::::::::::::::::::::::::::::::::::: 
Route::get('add-to-log', 'HomeController@myTestAddToLog');