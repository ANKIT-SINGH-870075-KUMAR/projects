<!-- Create Dynamic Input Fields -->
<?php
require 'ddata.php';

function createInputFields(Array $numFields, Array $dropdownOptions): void {
  forEach($numFields as $key => $value){
    switch($value[1]){
        case $value[1] == "text" || $value[1] == 'email' || $value[1] == 'password' || $value[1] == 'number':
            echo '
            <div class="form-control>
            <label for="'.$value[0].'">'.$key.'</label>
            <input type="'. $value[1] .'" name="'.$value[0].'" placeholder="Please enter your '.$key.'">
            </div>
            ';
            break;
        case "dropdown":
            echo '
                <div class="form-control">
                <label for="'.$value[0].'">'.$key.'</label>
                <select name="'.$value[0].'">
                    <option value="">Select '. $key .'</option>'.
                    forEach($dropddownOptions[$key] as $optionValue => $optionText){
                        echo '<option value="'.$optionValue.'">'.$optionText.'</option>';
                    }.'
                </select>
                </div>
                    ';
            break;
        case "radio":
            echo '
            <div class="form-control">
            <label>'.$key.'</label>
            <div class="radio-group">
            <input type="'.$value[1].'" name="'.$value[0].'" value="Member"> Member
            <input type="'.$value[1].'" name="'.$value[0].'" value="Non-Member"> Non Member
            </div>
            </div>
            ';
            break;
    }
  }
}

createInputFields($numFields, $dropddownOptions);

?> 