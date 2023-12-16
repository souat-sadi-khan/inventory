<?php

use App\Models\Admin\Account;
use App\Models\Customer;
use App\Models\Supplier;
use App\Setting;
use Illuminate\Database\Seeder;

class GeneralSettingSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  Create default navbar top
        Setting::create([
            'name'      =>  'navbar_position',
            'value'     =>  'top',
        ]);

        // Create Log Event
        Setting::create([
            'name'      => 'log_event',
            'value'     => 'created,updated,deleted',
        ]);

        //  Create log_delete_date
        Setting::create([
            'name'      =>  'log_delete_date',
            'value'     =>  '365',
        ]);

        //  Create log_delete_date
        Setting::create([
            'name'      =>  'log_report',
            'value'     =>  'on',
        ]);

        // ip_filter off
        Setting::create([
            'name'      =>  'ip_filter',
            'value'     =>  'off',
        ]);


        // Default Account
        Account::create([
            'category'      =>  'Cash_in_hand',
            'name'     =>  'Cash In Hand',
            'status'     =>  'Active',
            'is_default'     =>  1,
        ]);


        Account::create([
            'category'      =>  'Current_Assets',
            'name'     =>  'Product',
            'status'     =>  'Active',
            'is_default'     =>  1,
        ]);


        Account::create([
            'category'      =>  'Direct_Income',
            'name'     =>  'Product Sale Income',
            'status'     =>  'Active',
            'is_default'     =>  1,
            'is_default'     =>  1,
        ]);



        Account::create([
            'category'      =>  'Direct_Expanses',
            'name'     =>  'Product Sale Discount',
            'status'     =>  'Active',
            'is_default'     =>  1,
        ]);

        Account::create([
            'category'      =>  'Direct_Income',
            'name'     =>  'Product Purchase Discount',
            'status'     =>  'Active',
            'is_default'     =>  1,
            'is_liabilities'     =>  0,
        ]);


        Account::create([
            'category'      =>  'Current_Leabillties',
            'name'     =>  'Sale Shipping Charge',
            'status'     =>  'Active',
            'is_default'     =>  1,
            'is_liabilities'     =>  1,
        ]);

        Account::create([
            'category'      =>  'Current_Leabillties',
            'name'     =>  'Sale Tax',
            'status'     =>  'Active',
            'is_default'     =>  1,
            'is_liabilities'     =>  1,
        ]);

        Account::create([
            'category'      =>  'Direct_Expanses',
            'name'     =>  'Purchase Tax',
            'status'     =>  'Active',
            'is_default'     =>  1,
        ]);

        Account::create([
            'category'      =>  'Direct_Expanses',
            'name'     =>  'Purchase Shipping Charge',
            'status'     =>  'Active',
            'is_default'     =>  1,
        ]);

       $customer =  Customer::create([
            'customer_name'      =>  'Walk_in_Customer',
            'customer_mobile'     =>  '01xxxxxxxxx',
            'customer_email'     =>  'ww@gmail.com',
            'status'     =>  true,
        ]);

        // Default Account
        Account::create([
            'category'      =>  'Customer',
            'name'     =>  'Walk in Customer',
            'customer_id'     =>  $customer->id,
            'status'     =>  'Active',
            'is_default'     =>  1,
        ]);

       $supplier = Supplier::create([
            'sup_name'      =>  'Walk_in_Supplier',
            'sup_mobile'     =>  '01xxxxxxxxx',
            'sup_email'     =>  'ws@gmail.com',
            'status'     =>  true,
        ]);

        // Default Account
        Account::create([
            'category'      =>  'Supplier',
            'name'     =>  'Walk in Supplier',
            'supplier_id'     =>  $supplier->id,
            'status'     =>  'Active',
            'is_default'     =>  1,
            'is_liabilities'     =>  1,
        ]);
    }
}
