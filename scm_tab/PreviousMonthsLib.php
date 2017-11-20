<?php
    /**
     *
     * Previous Months object
     *
     * @author		Lawrence Oliver C. Sunglao <locsunglao@yahoo.com>
     */
    class PreviousMonths {
        /**
        *
        * Returns a list of ISO date and description
        *
        */
        static function GetPreviousMonths($num_of_months) {
            $now = new DateTime();
            $given_date_str = $now->format('Y-m-01 00:00:00');
            $reference_date = new DateTime($given_date_str);
            $return_data = array();
            for ($i == 0; $i < $num_of_months; $i++) {
                if ($i == 0) {  //current month
                    $return_data[] = array("date" => $reference_date->format("Y-m-d"), "desc" => "Current Month");
                }
                else {
                    $return_data[] = array("date" => $reference_date->format("Y-m-d"), "desc" => $reference_date->format("F - Y"));
                }
                $reference_date->modify("-1 months");
            }
            return $return_data;
        }
    }
?>
