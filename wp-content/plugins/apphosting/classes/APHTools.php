<?php
/**
 * DESCRIPTION.
 *
 *   app hosting WordPress Plugin for domain hosting pal
 *
 *  @author    Paragon Kingsley
 *  @copyright 2023 Paragon Kingsley
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License ("AFL") v. 3.0
 */
require_once dirname(__FILE__).'/APHCurrency.php';

class APHTools
{
    public static function codeGenerator($length = 15)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = strlen($chars);

        for ($i = 0, $token = ''; $i < $length; ++$i) {
            $index = rand(0, $count - 1);
            $token .= substr($chars, $index, 1);
        }

        return $token;
    }

    public static function createDate($end_date)
    {
        $userdate = new DateTime($end_date);
        if (!is_object($userdate)) {
            return false;
        }
        return  $userdate->format('Y-m-d');
    }


     public static function isEmail($email)
     {
         return !empty($email) && preg_match(self::cleanNonUnicodeSupport('/^[a-z\p{L}0-9!#$%&\'*+\/=?^`{}|~_-]+[.a-z\p{L}0-9!#$%&\'*+\/=?^`{}|~_-]*@[a-z\p{L}0-9]+(?:[.]?[_a-z\p{L}0-9-])*\.[a-z\p{L}0-9]+$/ui'), $email);
     }


    public static function isBirthDate($date)
    {
        if (empty($date) || $date == '0000-00-00') {
            return true;
        }
        if (preg_match('/^([0-9]{4})-((?:0?[1-9])|(?:1[0-2]))-((?:0?[1-9])|(?:[1-2][0-9])|(?:3[01]))([0-9]{2}:[0-9]{2}:[0-9]{2})?$/', $date, $birth_date)) {
            if ($birth_date[1] > date('Y') && $birth_date[2] > date('m') && $birth_date[3] > date('d')
                || $birth_date[1] == date('Y') && $birth_date[2] == date('m') && $birth_date[3] > date('d')
                || $birth_date[1] == date('Y') && $birth_date[2] > date('m')) {
                return false;
            }
            return true;
        }
        return false;
    }


    public static function cleanNonUnicodeSupport($pattern)
    {
        if (!defined('PREG_BAD_UTF8_OFFSET')) {
            return $pattern;
        }
        return preg_replace('/\\\[px]\{[a-z]{1,2}\}|(\/[a-z]*)u([a-z]*)$/i', '$1$2', $pattern);
    }


    public static function isName($name)
    {
        $validityPattern = self::cleanNonUnicodeSupport(
            '/^[^0-9!<>,;?=+()@#"°{}_$%:¤|]*$/u'
        );

        return preg_match($validityPattern, $name);
    }




    public static function getCountryCode($country)
    {
        $codes =array('NG'=>'+234', 'GH'=>'+233', 'US'=>'+1', );
        return $codes[$country];
    }

    public static function formatNumber($number, $country)
    {
        $number = trim($number);
        $ccode = self::getCountryCode($country);
        if (Tools::substr($number, 0, 1) == 0) {
            $no = $ccode.(Tools::substr($number, 1));
        } else {
            $no = $ccode.(trim($number));
        }

        return $no;
    }


    public static function ajaxReport($status, $message, $contents = '', $url = '')
    {
        $response = array('status'=>$status, 'message'=>$message, 'url'=>$url);
        if (is_array($contents)) {
            if (count($contents) >0) {
                foreach ($contents as $c => $v) {
                    $response[$c] = $v;
                }
            }
        } else {
            $response['contents'] = $contents;
        }
        echo json_encode($response);
        wp_die();
    }


    public static function displayError($message)
    {
        return self::ajaxReport('NK', $message);
    }

    public static function displaySuccess($message, $status = "OK")
    {
        return self::ajaxReport($status, $message);
    }

    public static function displaySuccessURL($url, $message="Success", $status = "OK")
    {
        return self::ajaxReport($status, $message='Success', '', $url);
    }


        public static function subText($value, $limit = 99)
        {
            if (mb_strwidth($value, 'UTF-8') <= $limit) {
                return $value;
            }

            do {
                $len          = mb_strwidth($value, 'UTF-8');
                $len_stripped = mb_strwidth(strip_tags($value), 'UTF-8');
                $len_tags     = $len - $len_stripped;

                $value = mb_strimwidth($value, 0, $limit + $len_tags, '', 'UTF-8');
            } while ($len_stripped > $limit);

            // Load as HTML ignoring errors
            $dom = new \DOMDocument();
            @$dom->loadHTML('<?xml encoding="utf-8" ?>'.$value, LIBXML_HTML_NODEFDTD);

            // Fix the html errors
            $value = $dom->saveHtml($dom->getElementsByTagName('body')->item(0));

    // Remove body tag
            $value = mb_strimwidth($value, 6, mb_strwidth($value, 'UTF-8') - 13, '', 'UTF-8'); // <body> and </body>
    // Remove empty tags
            return preg_replace('/<(\w+)\b(?:\s+[\w\-.:]+(?:\s*=\s*(?:"[^"]*"|"[^"]*"|[\w\-.:]+))?)*\s*\/?>\s*<\/\1\s*>/', '', $value);
        }



    public static function displayContent($contents, $message="success")
    {
        return self::ajaxReport('OK', $message, '', $contents);
    }


    public static function toNg($amount)
    {
        $rate = APHCurrency::getRate('NGN');
        return round($rate * $amount, 4);
    }

    public static function displayNg($amount)
    {
        $amount = self::toNg($amount);
        return '₦'.number_format($amount, 2);
    }

    public static function showNgPrice($amount)
    {
        return '₦'.number_format($amount, 2);
    }

    public static function displayDollar($dollar)
    {
        return '$'.number_format($dollar, 2);
    }


    public static function sendJSON($arr)
    {
        echo json_encode($arr);
        wp_die();
    }

    public static function postJson($arr)
    {
        echo json_encode($arr);
        wp_die();
    }

    public static function sellPrice($amount)
    {
        $per = (float) get_option('APH_DOMAIN_PERCENT_SELL');

        if ($per < 1) {
            $per = 25;
        }
        $t = ($per/100) * $amount;
        return $t + $amount;
    }

    public static function showCleanDate($tdate)
    {
        return date('F j, Y, g:i a', $tdate);
    }



    public static function justDate($tdate)
    {
        return date('Y-m-d', strtotime($tdate));
    }


    public static function slashDate($tdate)
    {
        return date('d/m/Y', strtotime($tdate));
    }


    public static function cleanText($text)
    {
        $text =  strip_tags(trim($text));
        $name =  preg_replace("/[^a-zA-Z0-9]+/", " ", $text);
        return trim($name);
    }






    public static function getDateDiff($a, $b)
    {
        $datetime1 = new DateTime($a);
        $datetime2 = new DateTime($b);
        $interval = $datetime1->diff($datetime2);
        return $interval->format('%a');
    }


    public static function isValidateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }



    public static function cleanDisplay($text)
    {
        return str_replace([','], [' / '], $text);
    }


    public static function isDate($date)
    {
        if (DateTime::createFromFormat('Y-m-d', $date) !== false) {
            return true;
        }
        return false;
    }


    public static function sendJ($arr)
    {
        return FWTools::jsonEncode($arr) ;
    }


    public static function futureDate($str_date)
    {
        return date('Y-m-d', strtotime(date('Y-m-d').' + '.$str_date));
    }

    public static function addToDate($date, $addition)
    {
        return date('Y-m-d', strtotime($date.' + '.$addition));
    }

    public static function removeFromDate($date, $substract)
    {
        return date('Y-m-d', strtotime($date.' - '.$substract));
    }




    public static function naError($e)
    {
        echo'<div class="red_alert_box text-center">
                                '.$e.'
                            </div>';
    }

    public static function naSuccess($e)
    {
        echo'<div class="green_alert_box">
                                '.$e.'
                            </div>';
    }
    public static function naInfo($e)
    {
        echo'<div class="info_alert_box">
                                '.$e.'
                            </div>';
        ;
    }



    public static function getValue($var)
    {
        if (isset($_GET)) {
            if (isset($_GET[$var])) {
                return trim(htmlentities($_GET[$var]));
            }
        }

        if (isset($_POST)) {
            if (isset($_POST[$var])) {
                return trim(htmlentities($_POST[$var]));
            }
        }

        return '';
    }
}
