<?php

namespace App\Laravue;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final class Acl
{
    const CASH_ACCOUNT_TYPE_CODE = 5194794;
    const EXPENDITURE_ACCOUNT_TYPE_CODE = 5194795;
    const SALES_ACCOUNT_TYPE_CODE = 5194796;
    const PROFIT_ACCOUNT_TYPE_CODE = 5194797;

    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_SALES = 'sales';

    const PERMISSION_VIEW_MENU_PERMISSION = 'view menu permission';
    const PERMISSION_VIEW_MENU_ADMINISTRATOR = 'view menu administrator';
    const PERMISSION_VIEW_MENU_STORE = 'view menu store';
    const PERMISSION_VIEW_MENU_ALL_PRODUCT = 'view menu all product';
    const PERMISSION_VIEW_MENU_REGISTER_PURCHASE = 'view menu register purchase';
    const PERMISSION_VIEW_MENU_RECENT_PURCHASES = 'view menu recent purchases';
    const PERMISSION_VIEW_MENU_ACCOUNTS = 'view menu financial accounts';
    const PERMISSION_VIEW_MENU_INVESTMENTS = 'view menu investments';
    const PERMISSION_VIEW_MENU_SALES_TRANSACTIONS = 'view menu sales transactions';
    const PERMISSION_VIEW_MENU_REGISTER_SALES = 'view menu register sales';
    const PERMISSION_VIEW_MENU_TRANSACTIONS = 'view menu transaction';
    const PERMISSION_VIEW_MENU_PURCHASED_GOODS_REPORT = 'view menu purchased goods report';
    const PERMISSION_VIEW_MENU_UNITS = 'view menu units';
    const PERMISSION_VIEW_MENU_PURCHASE_ORDER = 'view menu purchase order';
    const PERMISSION_VIEW_MENU_CURRENT_STOCK = 'view menu current stock';
    const PERMISSION_VIEW_MENU_COMPANY_USERS = 'view menu company users';
    const PERMISSION_VIEW_MENU_PRODUCTS = 'view menu products';
    const PERMISSION_VIEW_MENU_REGISTER_PRODUCT = 'view menu register product';
    const PERMISSION_VIEW_MENU_PURCHASES = 'view menu purchases';
    const PERMISSION_VIEW_MENU_FINANCIALS = 'view menu financials';
    const PERMISSION_VIEW_MENU_SALES = 'view menu sales';
    const PERMISSION_VIEW_MENU_REPORTS = 'view menu reports';
    const PERMISSION_VIEW_MENU_ADMINISTRATION = 'view menu administration';
    const PERMISSION_VIEW_MENU_STOCK = 'view menu stock';
    const PERMISSION_VIEW_MENU_SETTINGS = 'view menu settings';
    const PERMISSION_VIEW_MENU_ACCOUNT_SETTINGS = 'view menu account settings';
    const PERMISSION_VIEW_MENU_EXPIRY_PRODUCTS = 'view menu expired products';
    const PERMISSION_VIEW_MENU_COMPANY = 'view menu company';
    const PERMISSION_VIEW_MENU_EXPENDITURE = 'view menu expenditure';
    const PERMISSION_VIEW_MENU_UNIT_CATEGORY = 'view menu unit category';
    const PERMISSION_VIEW_MENU_SYSTEM_SETTINGS = 'view menu system settings';
    const PERMISSION_VIEW_MENU_ALL_STORE = 'view menu all store';
    const PERMISSION_VIEW_MENU_ACCOUNT_TYPES = 'view menu account types';
    const PERMISSION_VIEW_MENU_STOCK_PURCHASE = 'view menu stock purchase';
    const PERMISSION_VIEW_MENU_REGISTER_STOCK_PURCHASE = 'view menu register stock purchase';
    const PERMISSION_VIEW_MENU_PURCHASE_FULL_DISPATCH = 'view menu purchase full dispatch';
    const PERMISSION_VIEW_MENU_PURCHASE_PARTIAL_DISPATCH = 'view menu purchase partial dispatch';


    const PERMISSION_USER_MANAGE = 'manage user';
    const PERMISSION_VIEW_USER_DETAILS = 'view user details';
    const PERMISSION_PERMISSION_MANAGE = 'manage permission';
    const PERMISSION_COMPANY_SHOW = 'show company';
    const PERMISSION_COMPANY_STORE = 'store company';
    const PERMISSION_COMPANY_DELETE = 'delete company';
    const PERMISSION_COMPANY_SHOW_STORES = 'view company stores';
    const PERMISSION_COMPANY_SHOW_ALL_COMPANY = 'view all companies';
    const PERMISSION_COMPANY_UPDATE = 'update company';

    //permission management permissions
    const PERMISSION_VIEW_ALL_PERMISSIONS = 'view all permissions';
    const PERMISSION_SYNC_PERMISSIONS = 'sync permissions';

    //store management permissions
    const PERMISSION_CREATE_STORE = 'create store';
    const PERMISSION_UPDATE_STORE = 'update store';
    const PERMISSION_VIEW_ALL_COMPANY_STORE = 'view all company store';
    const PERMISSION_MANAGE_STORE = 'manage store';


    //product management permissions
    const PERMISSION_VIEW_PRODUCT_STORE = 'view product store';
    const PERMISSION_CREATE_PRODUCT = 'create product';
    const PERMISSION_UPDATE_PRODUCT = 'update product';
    const PERMISSION_VIEW_PRODUCT_SETTINGS = 'view product settings';

    //purchase management permissions
    const PERMISSION_REGISTER_PURCHASE = 'register purchase';

    //Unit management permission
    const PERMISSION_MANAGE_UNITS = 'manage units';

    // permissions
    const PERMISSION_UPDATE_USER_STORE = 'update user stores';
    const PERMISSION_SWITCH_STORE = 'switch store';
    const PERMISSION_RECOVER_USER_PASSWORD = 'recover user password';

    const PERMISSION_VIEW_USER_PROFILE = 'view user profile';
    const PERMISSION_VIEW_STORE_DASHBOARD = 'view store dashboard';
    const PERMISSION_CREATE_UNIT_CATEGORY = 'create unit category';
    const PERMISSION_VIEW_MENU_PLAN = 'view menu plan';



    /**
     * @param array $exclusives Exclude some permissions from the list
     * @return array
     */
    public static function permissions(array $exclusives = []): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $permissions = Arr::where($constants, function ($value, $key) use ($exclusives) {
                return !in_array($value, $exclusives) && Str::startsWith($key, 'PERMISSION_');
            });

            return array_values($permissions);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }

    /** @return array */
    public static function getCashAccountCode()
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $cashAccountCode = Arr::where($constants, function ($value, $key) {
                return Str::startsWith($key, 'CASH_');
            });

            return array_values($cashAccountCode);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }

    public static function menuPermissions(): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $permissions = Arr::where($constants, function ($value, $key) {
                return Str::startsWith($key, 'PERMISSION_VIEW_MENU_');
            });

            return array_values($permissions);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }

    /**
     * @return array
     */
    public static function roles(): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $roles = Arr::where($constants, function ($value, $key) {
                return Str::startsWith($key, 'ROLE_');
            });

            return array_values($roles);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }
}
