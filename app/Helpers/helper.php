<?php
// Get Time Zone List
use App\InvoiceLayout;
use App\Models\Admin\Account;
use App\Models\Admin\AccountTransaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;


function tz_list()
{
    $zones_array = array();
    $timestamp = time();
    foreach (timezone_identifiers_list() as $key => $zone) {
        date_default_timezone_set($zone);
        $zones_array[$key]['zone'] = $zone;
        $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
    }
    return $zones_array;
}


function getUserRoleName($user_id)
{
    $user = User::findOrFail($user_id);

    $roles = $user->getRoleNames();

    $role_name = '';

    if (!empty($roles[0])) {
        $array = explode('#', $roles[0], 2);
        $role_name = !empty($array[0]) ? $array[0] : '';
    }
    return $role_name;
}

// currency list
function curency()
{
    return $currency = [
        'AED' => '&#1583;.&#1573;', // ?
        'AFN' => '&#65;&#102;',
        'ALL' => '&#76;&#101;&#107;',
        'AMD' => '',
        'ANG' => '&#402;',
        'AOA' => '&#75;&#122;', // ?
        'ARS' => '&#36;',
        'AUD' => '&#36;',
        'AWG' => '&#402;',
        'AZN' => '&#1084;&#1072;&#1085;',
        'BAM' => '&#75;&#77;',
        'BBD' => '&#36;',
        'BDT' => '&#2547;', // ?
        'BGN' => '&#1083;&#1074;',
        'BHD' => '.&#1583;.&#1576;', // ?
        'BIF' => '&#70;&#66;&#117;', // ?
        'BMD' => '&#36;',
        'BND' => '&#36;',
        'BOB' => '&#36;&#98;',
        'BRL' => '&#82;&#36;',
        'BSD' => '&#36;',
        'BTN' => '&#78;&#117;&#46;', // ?
        'BWP' => '&#80;',
        'BYR' => '&#112;&#46;',
        'BZD' => '&#66;&#90;&#36;',
        'CAD' => '&#36;',
        'CDF' => '&#70;&#67;',
        'CHF' => '&#67;&#72;&#70;',
        'CLF' => '', // ?
        'CLP' => '&#36;',
        'CNY' => '&#165;',
        'COP' => '&#36;',
        'CRC' => '&#8353;',
        'CUP' => '&#8396;',
        'CVE' => '&#36;', // ?
        'CZK' => '&#75;&#269;',
        'DJF' => '&#70;&#100;&#106;', // ?
        'DKK' => '&#107;&#114;',
        'DOP' => '&#82;&#68;&#36;',
        'DZD' => '&#1583;&#1580;', // ?
        'EGP' => '&#163;',
        'ETB' => '&#66;&#114;',
        'EUR' => '&#8364;',
        'FJD' => '&#36;',
        'FKP' => '&#163;',
        'GBP' => '&#163;',
        'GEL' => '&#4314;', // ?
        'GHS' => '&#162;',
        'GIP' => '&#163;',
        'GMD' => '&#68;', // ?
        'GNF' => '&#70;&#71;', // ?
        'GTQ' => '&#81;',
        'GYD' => '&#36;',
        'HKD' => '&#36;',
        'HNL' => '&#76;',
        'HRK' => '&#107;&#110;',
        'HTG' => '&#71;', // ?
        'HUF' => '&#70;&#116;',
        'IDR' => '&#82;&#112;',
        'ILS' => '&#8362;',
        'INR' => '&#8377;',
        'IQD' => '&#1593;.&#1583;', // ?
        'IRR' => '&#65020;',
        'ISK' => '&#107;&#114;',
        'JEP' => '&#163;',
        'JMD' => '&#74;&#36;',
        'JOD' => '&#74;&#68;', // ?
        'JPY' => '&#165;',
        'KES' => '&#75;&#83;&#104;', // ?
        'KGS' => '&#1083;&#1074;',
        'KHR' => '&#6107;',
        'KMF' => '&#67;&#70;', // ?
        'KPW' => '&#8361;',
        'KRW' => '&#8361;',
        'KWD' => '&#1583;.&#1603;', // ?
        'KYD' => '&#36;',
        'KZT' => '&#1083;&#1074;',
        'LAK' => '&#8365;',
        'LBP' => '&#163;',
        'LKR' => '&#8360;',
        'LRD' => '&#36;',
        'LSL' => '&#76;', // ?
        'LTL' => '&#76;&#116;',
        'LVL' => '&#76;&#115;',
        'LYD' => '&#1604;.&#1583;', // ?
        'MAD' => '&#1583;.&#1605;.', //?
        'MDL' => '&#76;',
        'MGA' => '&#65;&#114;', // ?
        'MKD' => '&#1076;&#1077;&#1085;',
        'MMK' => '&#75;',
        'MNT' => '&#8366;',
        'MOP' => '&#77;&#79;&#80;&#36;', // ?
        'MRO' => '&#85;&#77;', // ?
        'MUR' => '&#8360;', // ?
        'MVR' => '.&#1923;', // ?
        'MWK' => '&#77;&#75;',
        'MXN' => '&#36;',
        'MYR' => '&#82;&#77;',
        'MZN' => '&#77;&#84;',
        'NAD' => '&#36;',
        'NGN' => '&#8358;',
        'NIO' => '&#67;&#36;',
        'NOK' => '&#107;&#114;',
        'NPR' => '&#8360;',
        'NZD' => '&#36;',
        'OMR' => '&#65020;',
        'PAB' => '&#66;&#47;&#46;',
        'PEN' => '&#83;&#47;&#46;',
        'PGK' => '&#75;', // ?
        'PHP' => '&#8369;',
        'PKR' => '&#8360;',
        'PLN' => '&#122;&#322;',
        'PYG' => '&#71;&#115;',
        'QAR' => '&#65020;',
        'RON' => '&#108;&#101;&#105;',
        'RSD' => '&#1044;&#1080;&#1085;&#46;',
        'RUB' => '&#1088;&#1091;&#1073;',
        'RWF' => '&#1585;.&#1587;',
        'SAR' => '&#65020;',
        'SBD' => '&#36;',
        'SCR' => '&#8360;',
        'SDG' => '&#163;', // ?
        'SEK' => '&#107;&#114;',
        'SGD' => '&#36;',
        'SHP' => '&#163;',
        'SLL' => '&#76;&#101;', // ?
        'SOS' => '&#83;',
        'SRD' => '&#36;',
        'STD' => '&#68;&#98;', // ?
        'SVC' => '&#36;',
        'SYP' => '&#163;',
        'SZL' => '&#76;', // ?
        'THB' => '&#3647;',
        'TJS' => '&#84;&#74;&#83;', // ? TJS (guess)
        'TMT' => '&#109;',
        'TND' => '&#1583;.&#1578;',
        'TOP' => '&#84;&#36;',
        'TRY' => '&#8356;', // New Turkey Lira (old symbol used)
        'TTD' => '&#36;',
        'TWD' => '&#78;&#84;&#36;',
        'TZS' => '',
        'UAH' => '&#8372;',
        'UGX' => '&#85;&#83;&#104;',
        'USD' => '&#36;',
        'UYU' => '&#36;&#85;',
        'UZS' => '&#1083;&#1074;',
        'VEF' => '&#66;&#115;',
        'VND' => '&#8363;',
        'VUV' => '&#86;&#84;',
        'WST' => '&#87;&#83;&#36;',
        'XAF' => '&#70;&#67;&#70;&#65;',
        'XCD' => '&#36;',
        'XDR' => '',
        'XOF' => '',
        'XPF' => '&#70;',
        'YER' => '&#65020;',
        'ZAR' => '&#82;',
        'ZMK' => '&#90;&#75;', // ?
        'ZWL' => '&#90;&#36;',
    ];
}

// format date
function formatDate($date)
{
    $dtobj = Carbon::parse($date);
    if (get_option('date_format') == 'y-m-d') {
        return $dtformat = $dtobj->format('F jS, Y');
    }
    if (get_option('date_format') == 'Y-m-d') {
        return $dtformat = $dtobj->format('M jS, Y');
    }
    if (get_option('date_format') == 'h-i-s') {
        return $dtformat = $dtobj->format('g:i A');
    }
    if (get_option('date_format') == 'time') {
        return $dtformat = $dtobj->format('h:i A');
    } else {
        return $dtformat = $dtobj->format('F jS, Y');
    }
}

//permission
function split_name($name)
{
    $data = [];
    foreach ($name as $value) {
        $per = explode('.', $value->name);
        $data[toWord($per[0])][] = $value->name;
    }
    return $data;
}

function toWord($word)
{
    $word = str_replace('_', ' ', $word);
    $word = str_replace('-', ' ', $word);
    $word = ucwords($word);
    return $word;
}

function tospane($data)
{
    $per = explode('.', $data);
    return toWord($per[1]);
}

// make_slug
function make_slug($string)
{
    $string = remove_special_char($string);
    $string = text_shorten($string);
    $string = str_replace(' ', '-', $string);
    return $string;
}

function text_shorten($text, $limit = 200)
{
    $text = $text . " ";
    $text = substr($text, 0, $limit);
    $text = substr($text, 0, strrpos($text, ' '));
    return $text;
}//textShorten
function remove_special_char($string)
{
    $string = html_entity_decode($string);
    $string = strip_tags($string);
    $string = htmlspecialchars($string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = str_replace(array('[\', \', ]', '(', ')', '{', '}', '[', ']', '|', '?', '-', '_', ',', '~', '`', '/', '\\', '"', "'", ':'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/!|@|#|%|&/', '', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = str_replace('&times;', 'x', $string);
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
    $string = preg_replace('/\s+/u', ' ', trim($string)); // for multiple spaces
    $string = preg_replace('/-+/', ' ', $string); //for multiple -
    return strtolower(trim($string, ' '));
}

// if (!function_exists('get_option')) {
//     function get_option($name)
//     {
//         if(!\Illuminate\Support\Facades\Schema::hasTable('settings')){
//             return '';
//         }
//         $setting = DB::table('settings')->where('name', $name)->get();
//         if (!$setting->isEmpty()) {
//             return $setting[0]->value;
//         }
//         return "";
//     }
// }
if (!function_exists('get_option')) {

    function get_option($name, $default = null)
    {
        try {
            DB::connection()
                ->getPdo();
            if (!\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                return $default;
            }
            $setting = \Illuminate\Support\Facades\DB::table('settings')->where('name', $name)->first();
            if ($setting) {
                return $setting->value;
            }
            return $default;
        } catch (Exception $e) {
            return $default;
        }
    }
}

function accountCheck2($type)
{
    if ($type > 0) {
        $data = $type . ' Dr';
    } else if ($type < 0) {
        $a = $type * (-1);
        $data = $a . ' Cr';
    } else {
        $data = $type;
    }

    return $data;
}

function accountCheck3($type)
{
    if ($type > 0) {
        $data = $type;
    } else if ($type < 0) {
        $a = $type * (-1);
        $data = $a;
    } else {
        $data = $type;
    }

    return $data;
}


function dabit_credit($debit, $credit)
{

    $value = accountCheck($credit - $debit);
    return $value;
}

function dabit_credit2($debit, $credit)
{

    $value = accountCheck2($credit - $debit);
    return $value;
}

function dabit_credit3($debit, $credit)
{

    $value = accountCheck3($credit - $debit);
    return $value;
}


function accountCheck($type)
{

    if ($type > 0) {
        $data = '<span class="text-success">' . number_format($type, 2) . ' (Cr)' . '</span>';
    } else if ($type < 0) {
        $a = $type * (-1);
        $data = '<span class="text-danger">' . number_format($a, 2) . ' (Dr)' . '</span>';
    } else {
        $data = number_format($type, 2);
    }

    return $data;
}


function ref($num)
{
    switch ($num) {
        case $num < 10:
            return "000" . $num;
            break;
        case $num >= 10 && $num < 100:
            return "00" . $num;
            break;
        case $num > +10 && $num >= 100 && $num < 1000:
            return "0" . $num;
            break;
        default:
            return $num;;
    }
}

function random_num($type)
{
    return substr($type, 0, 3) . time() . rand(10, 100) . 'R';
}

function acrandom_num($type)
{
    return substr($type, 0, 4) . time() . rand(10, 100) . 'Ac';
}

function convert_number_to_words($number)
{

    $hyphen = '-';
    $conjunction = '  ';
    $separator = ' ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = array(
        0 => 'Zero',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Fourty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety',
        100 => 'Hundred',
        1000 => 'Thousand',
        1000000 => 'Million',
        1000000000 => 'Billion',
        1000000000000 => 'Trillion',
        1000000000000000 => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int)($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int)($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string)$fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}


function invoice($type)
{
    $model = InvoiceLayout::where('type', $type)->first();
    $invoice = null;
    if ($model) {
        $invoice = json_decode($model->value);
    }
    return $invoice;
}


function account_calculation($account, $type, $start_date = Null, $end_date = Null)
{

    $account = Account::where('category', $account)->get()->pluck('id');
    $trans = AccountTransaction::whereIn('account_id', $account)->where('type', $type);
    if ($start_date and $end_date) {
        $trans = $trans->where('operation_date', '>=', $start_date)->where('operation_date', '<=', $end_date);
    } elseif ($start_date) {
        $trans = $trans->where('operation_date', $start_date);
    } else {
        $trans = $trans;
    }

    return $trans->sum('amount');
}

function authorize(array $permission, $ajax = false)
{

    $permit = false;
    foreach ($permission as $p) {
        if (auth()->user()->can($p)) {
            $permit = true;
        }
    }
    if (!$permit) {
        if ($ajax) {
            throw ValidationException::withMessages(['message' => 'Unauthorized Action']);
        } else {
            abort(403);
        }
    }

}

const LIABILITIES = [
    'Current_Leabillties',
    'Direct_Income',
    'Unsecured_Loans',
    'Capital_Account',
    'Investment',
    'Supplier'
];

const ASSET = [
    'Bank_Account',
    'Current_Assets',
    'Direct_Expanses',
    'Employee',
    'Fixed_Assets',
    'Customer',
];

function check_liabilities ($category){
    if (in_array($category, ASSET)){
        return 0;
    }
    return 1;
}

function check_debit_credit($account_id, $position= 'from')
{
    $account = Account::find($account_id);
    $is_liabilities = $account->is_liabilities;

    if ($position == 'from' and !$is_liabilities){
        return 'Credit';
    }

    return 'Debit';
}
