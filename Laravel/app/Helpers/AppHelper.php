<?php



namespace App\Helpers;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\File;


class AppHelper
{
    public function bladeHelper($someValue)
    {
        return "increment $someValue";
    }

    public function RemoveSpaces($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function ReplaceSystemKeywords($string, $extraKeywordFrom = null, $extraKeywordTo = null)
    {

        $templates = ["@currentyearfull", "@currentyearshort", "@currentmonthnumeric", "@currentmonthfull", "@currentmonthshort", "@currentdayofmonthnumeric", "@currentdayofweekshort", "@currentdayofweekfull"];
        $words   = [date("Y"), date("y"), date("m"), date("F"), date("M"), date("d"), date("D"), date("l")];

        if (isset($extraKeywordFrom) & isset($extraKeywordTo)) {
            $string = str_replace($extraKeywordFrom, $extraKeywordTo, $string);
        }

        return str_replace($templates, $words, $string);
    }

    public function ReplaceSystemKeywordsWithStoreSettings($storeSettings, $string,  $extraKeywordFrom = null, $extraKeywordTo = null)
    {

        if ($string == null || trim($string) == '') {
            return "";
        }
        $currentMonthShort = $this->GetCurrentMonthShortWithStoreSetting($storeSettings);
        $currentMonthFull = $this->GetCurrentMonthFullWithStoreSetting($storeSettings);

        $templates = ["@currentyearfull", "@currentyearshort", "@currentmonthnumeric", "@currentmonthfull", "@currentmonthshort", "@currentdayofmonthnumeric", "@currentdayofweekshort", "@currentdayofweekfull"];
        $words   = [date("Y"), date("y"), date("m"), $currentMonthFull, $currentMonthShort, date("d"), date("D"), date("l")];

        if (isset($extraKeywordFrom) & isset($extraKeywordTo)) {
            $string = str_replace($extraKeywordFrom, $extraKeywordTo, $string);
        }

        return str_replace($templates, $words, $string);
    }

    private function GetCurrentMonthFullWithStoreSetting($storeSettings)
    {
        $month = date("m");
        if (isset($storeSettings->MonthsFull)) {
            $monthsList = explode(",", $storeSettings->MonthsFull);
            return $monthsList[((int) $month - 1)];
        }
        //  print_r(date("F"));
        return date("F");
    }

    private function GetCurrentMonthShortWithStoreSetting($storeSettings)
    {
        $month = date("m");

        if (isset($storeSettings->MonthsShort)) {
            $monthsList = explode(",", $storeSettings->MonthsShort);
            return $monthsList[((int) $month - 1)];
        }
        //print_r(date("M"));
        return date("M");
    }

    public function ReplaceSEOKeywords($string, $keywordsInSettings, $keywordsInStore)
    {
        $storekeywordsList = explode(",", $keywordsInStore);
        $settingsKeywordsList = explode(",", $keywordsInSettings);


        $storeKeyCounter = 0;
        $settingKeyCounter = 0;

        for ($i = 1; $i < 9; $i++) {
            $KeyTo = '';

            if (isset($storekeywordsList[$storeKeyCounter]) & !empty($storekeywordsList[$storeKeyCounter])) {
                $KeyTo = $storekeywordsList[$storeKeyCounter];
                $storeKeyCounter++;
            } elseif (isset($settingsKeywordsList[$settingKeyCounter]) & !empty($settingsKeywordsList[$settingKeyCounter])) {
                $KeyTo = $settingsKeywordsList[$settingKeyCounter];
                $settingKeyCounter++;
            }

            $string = str_replace("@Key" . ($i), $KeyTo, $string);
        }

        return $string;
    }

    public function DateToString($date)
    {

        if (isset($date)) {
            $splitedDate = explode('-', explode(' ', $date)[0]);
            if (count($splitedDate) == 3) {

                return $splitedDate[2] . '/' . $splitedDate[1] . '/' . $splitedDate[0];
            }
        }

        return null;
    }
    public function StringToDate($dateString)
    {
        $dateFormat = "Y-m-d h:i:s";
        if (isset($dateString)) {
            $splitedDate =  explode('/', $dateString);
            if (count($splitedDate) == 3) {
                $d = mktime(0, 0, 0, (int) $splitedDate[1], (int) $splitedDate[0], (int) $splitedDate[2]);
                return date($dateFormat, $d);
            }
        }

        return null;
    }

    public function GetPostedValue($id)
    {
        $value = isset($_POST[$id]) ? $_POST[$id] : '';
        return $value;
    }

    public function MoveToPublicFolder($subdirectory, $filename)
    {
        if (App::environment() === 'production') {
            $old_path = storage_path('app/public/' . $subdirectory . '/' . $filename);
            $new_path = '/home/saveecou/public_html/storage/' . $subdirectory . '/' . $filename;
            if (File::exists($old_path)) {
                File::move($old_path, $new_path);
            }
        }
    }

    public static function instance()
    {
        return new AppHelper();
    }
}
