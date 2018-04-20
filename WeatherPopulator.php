<?php

// this class takes the raw JSON and outputs the data as an HTML table
class WeatherPopulator {
    public static function jsonToHTML($apiJSON = '') {
        $parsed_json = json_decode($apiJSON, true);
        $htmlOutput = "";

        if ($parsed_json && is_array($parsed_json)) {
            $htmlOutput .= self::convertToHTML($parsed_json);
        }

        return $htmlOutput;
    }

    private static function convertToHTML($parsed_json) {

        $htmlTable = "<table><tbody>";
        foreach ($parsed_json as $key => $val) {

            $keyHTML = self::dataValidation($key);

            $htmlTable .= "<tr>";
            $htmlTable .= "<td>{$keyHTML}</td>";
            $htmlTable .= "<td>";

            if (is_array($val)) {
                if (!empty($val)) {
                    $htmlTable .= self::convertToHTML($val);
                }
            } else {
                $valHTML = self::dataValidation($val);
                $htmlTable .= "{$valHTML}";
            }

            $htmlTable .= "</td></tr>";
        }

        $htmlTable .= "</tbody></table>";

        return $htmlTable;
    }

    private static function dataValidation($data) {
        // this function serves as a wrapper where one could add any extra validation

        $validatedData = htmlspecialchars($data, ENT_QUOTES);

        return $validatedData;
    }
    
}

?>
