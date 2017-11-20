<?php

function get_tz_options($selectedzone, $label, $desc = '')
{
  echo '<div class="label"><label for="edited_user_timezone">'.$label.':</label></div>';
  echo '<div class="input"><select name="edited_user_timezone">';
  function timezonechoice($selectedzone) {
    $all = timezone_identifiers_list();

    $i = 0;
    foreach($all AS $zone) {
      $zone = explode('/',$zone);
      $zonen[$i]['continent'] = isset($zone[0]) ? $zone[0] : '';
      $zonen[$i]['city'] = isset($zone[1]) ? $zone[1] : '';
      $zonen[$i]['subcity'] = isset($zone[2]) ? $zone[2] : '';
      $i++;
    }

    asort($zonen);
    $structure = '';
    foreach($zonen AS $zone) {
      extract($zone);
      if($continent == 'Africa' || $continent == 'America' || $continent == 'Antarctica' || $continent == 'Arctic' || $continent == 'Asia' || $continent == 'Atlantic' || $continent == 'Australia' || $continent == 'Europe' || $continent == 'Indian' || $continent == 'Pacific') {
        if(!isset($selectcontinent)) {
          $structure .= '<optgroup label="'.$continent.'">'; // continent
        } elseif($selectcontinent != $continent) {
          $structure .= '</optgroup><optgroup label="'.$continent.'">'; // continent
        }

        if(isset($city) != ''){
          if (!empty($subcity) != ''){
            $city = $city . '/'. $subcity;
          }
          $structure .= "<option ".((($continent.'/'.$city)==$selectedzone)?'selected="selected "':'')." value=\"".($continent.'/'.$city)."\">".str_replace('_',' ',$city)."</option>"; //Timezone
        } else {
          if (!empty($subcity) != ''){
            $city = $city . '/'. $subcity;
          }
          $structure .= "<option ".(($continent==$selectedzone)?'selected="selected "':'')." value=\"".$continent."\">".$continent."</option>"; //Timezone
        }

        $selectcontinent = $continent;
      }
    }
    $structure .= '</optgroup>';
    return $structure;
  }
  echo timezonechoice($selectedzone);
  echo '</select>';
  echo '<span class="notes"> '.$desc.' </span></div>';
}
echo get_tz_options();
?> 