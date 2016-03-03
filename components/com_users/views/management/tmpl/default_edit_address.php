<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<style type="text/css">
    .field{ padding-bottom: 5px;}
    .sizeinput{ width: 200px}
    .sizeinputselect{ width: 204px; height: 22px;}
</style>
<script type="text/javascript">
    function resetMonthAndDayByYear(formx) {
        $dayText31 = "<option value='0'>Day</option>" +
                "<option value='1'>1</option>" +
                "<option value='2'>2</option>" +
                "<option value='3'>3</option>" +
                "<option value='4'>4</option>" +
                "<option value='5'>5</option>" +
                "<option value='6'>6</option>" +
                "<option value='7'>7</option>" +
                "<option value='8'>8</option>" +
                "<option value='8'>9</option>" +
                "<option value='10'>10</option>" +
                "<option value='11'>11</option>" +
                "<option value='12'>12</option>" +
                "<option value='13'>13</option>" +
                "<option value='14'>14</option>" +
                "<option value='15'>15</option>" +
                "<option value='16'>16</option>" +
                "<option value='17'>17</option>" +
                "<option value='18'>18</option>" +
                "<option value='19'>19</option>" +
                "<option value='20'>20</option>" +
                "<option value='21'>21</option>" +
                "<option value='22'>22</option>" +
                "<option value='23'>23</option>" +
                "<option value='24'>24</option>" +
                "<option value='25'>25</option>" +
                "<option value='26'>26</option>" +
                "<option value='27'>27</option>" +
                "<option value='28'>28</option>" +
                "<option value='29'>29</option>" +
                "<option value='30'>30</option>" +
                "<option value='31'>31</option>";
        document.getElementById('jform_day' + formx).innerHTML = $dayText31;
        document.getElementById('jform_month' + formx).value = "0";
    }
    function resetMonthAndDayByMonth(formx) {
        $y = document.getElementById('yearField' + formx).value;
        $m = document.getElementById('jform_month' + formx).value;
        $dayText28 = "<option value='0'>Day</option>" +
                "<option value='1'>1</option>" +
                "<option value='2'>2</option>" +
                "<option value='3'>3</option>" +
                "<option value='4'>4</option>" +
                "<option value='5'>5</option>" +
                "<option value='6'>6</option>" +
                "<option value='7'>7</option>" +
                "<option value='8'>8</option>" +
                "<option value='8'>9</option>" +
                "<option value='10'>10</option>" +
                "<option value='11'>11</option>" +
                "<option value='12'>12</option>" +
                "<option value='13'>13</option>" +
                "<option value='14'>14</option>" +
                "<option value='15'>15</option>" +
                "<option value='16'>16</option>" +
                "<option value='17'>17</option>" +
                "<option value='18'>18</option>" +
                "<option value='19'>19</option>" +
                "<option value='20'>20</option>" +
                "<option value='21'>21</option>" +
                "<option value='22'>22</option>" +
                "<option value='23'>23</option>" +
                "<option value='24'>24</option>" +
                "<option value='25'>25</option>" +
                "<option value='26'>26</option>" +
                "<option value='27'>27</option>" +
                "<option value='28'>28</option>";
        $dayText29 = "<option value='0'>Day</option>" +
                "<option value='1'>1</option>" +
                "<option value='2'>2</option>" +
                "<option value='3'>3</option>" +
                "<option value='4'>4</option>" +
                "<option value='5'>5</option>" +
                "<option value='6'>6</option>" +
                "<option value='7'>7</option>" +
                "<option value='8'>8</option>" +
                "<option value='8'>9</option>" +
                "<option value='10'>10</option>" +
                "<option value='11'>11</option>" +
                "<option value='12'>12</option>" +
                "<option value='13'>13</option>" +
                "<option value='14'>14</option>" +
                "<option value='15'>15</option>" +
                "<option value='16'>16</option>" +
                "<option value='17'>17</option>" +
                "<option value='18'>18</option>" +
                "<option value='19'>19</option>" +
                "<option value='20'>20</option>" +
                "<option value='21'>21</option>" +
                "<option value='22'>22</option>" +
                "<option value='23'>23</option>" +
                "<option value='24'>24</option>" +
                "<option value='25'>25</option>" +
                "<option value='26'>26</option>" +
                "<option value='27'>27</option>" +
                "<option value='28'>28</option>" +
                "<option value='29'>29</option>";
        $dayText30 = "<option value='0'>Day</option>" +
                "<option value='1'>1</option>" +
                "<option value='2'>2</option>" +
                "<option value='3'>3</option>" +
                "<option value='4'>4</option>" +
                "<option value='5'>5</option>" +
                "<option value='6'>6</option>" +
                "<option value='7'>7</option>" +
                "<option value='8'>8</option>" +
                "<option value='8'>9</option>" +
                "<option value='10'>10</option>" +
                "<option value='11'>11</option>" +
                "<option value='12'>12</option>" +
                "<option value='13'>13</option>" +
                "<option value='14'>14</option>" +
                "<option value='15'>15</option>" +
                "<option value='16'>16</option>" +
                "<option value='17'>17</option>" +
                "<option value='18'>18</option>" +
                "<option value='19'>19</option>" +
                "<option value='20'>20</option>" +
                "<option value='21'>21</option>" +
                "<option value='22'>22</option>" +
                "<option value='23'>23</option>" +
                "<option value='24'>24</option>" +
                "<option value='25'>25</option>" +
                "<option value='26'>26</option>" +
                "<option value='27'>27</option>" +
                "<option value='28'>28</option>" +
                "<option value='29'>29</option>" +
                "<option value='30'>30</option>";
        $dayText31 = "<option value='0'>Day</option>" +
                "<option value='1'>1</option>" +
                "<option value='2'>2</option>" +
                "<option value='3'>3</option>" +
                "<option value='4'>4</option>" +
                "<option value='5'>5</option>" +
                "<option value='6'>6</option>" +
                "<option value='7'>7</option>" +
                "<option value='8'>8</option>" +
                "<option value='8'>9</option>" +
                "<option value='10'>10</option>" +
                "<option value='11'>11</option>" +
                "<option value='12'>12</option>" +
                "<option value='13'>13</option>" +
                "<option value='14'>14</option>" +
                "<option value='15'>15</option>" +
                "<option value='16'>16</option>" +
                "<option value='17'>17</option>" +
                "<option value='18'>18</option>" +
                "<option value='19'>19</option>" +
                "<option value='20'>20</option>" +
                "<option value='21'>21</option>" +
                "<option value='22'>22</option>" +
                "<option value='23'>23</option>" +
                "<option value='24'>24</option>" +
                "<option value='25'>25</option>" +
                "<option value='26'>26</option>" +
                "<option value='27'>27</option>" +
                "<option value='28'>28</option>" +
                "<option value='29'>29</option>" +
                "<option value='30'>30</option>" +
                "<option value='31'>31</option>";
        if ((($y % 4) == 0) && ($m == 2)) {
            document.getElementById('jform_day' + formx).innerHTML = $dayText29;
        } else {
            if ($m == 2) {
                document.getElementById('jform_day' + formx).innerHTML = $dayText28;
            } else {
                if ($m == 1 || $m == 3 || $m == 5 || $m == 7 || $m == 8 || $m == 10 || $m == 11 || $m == 12) {
                    document.getElementById('jform_day' + formx).innerHTML = $dayText31;
                } else {
                    document.getElementById('jform_day' + formx).innerHTML = $dayText30;
                }
            }
        }
    }
</script>
<form method="post" id="userForm" name="chooseShipmentRate" action="<?php echo JRoute::_('index.php'); ?>" class="form-validate">
<?php
        if($this->address_type != 'ST'){?>
<h2 style="color : #666; padding-left: 10px ;font-size: 16px;  line-height: 32px; background: #f0f0f0;">
                            Your Billing Address
                        </h2>
    <table  class="adminForm user-details">            
        <?php
            foreach ($this->userFields['fields'] as $field) {
                    ?>
                    <tr>
                        <td class="key" title="<?php echo $field['description'] ?>" >
                            <label class="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>_field">
                                <?php echo $field['title'] . ($field['required'] ? ' *' : '') ?>
                            </label>
                        </td>
                        <td>
                            <?php if ($field['type'] == 'radio' && $field['name'] == 'gender') {
                                ?>
                                <input type="radio" name="gender" value="1" id="gender_1"
                                       <?php if($field['value'] == 1)
                                           {echo 'checked';}else{echo ''; }?>/>Male
                                <input type="radio" name="gender" value="2" id="gender_2"
                                       <?php if($field['value'] == 2)
                                           {echo 'checked';}else{echo ''; }?>/>Female
                                <?php
                            } elseif ($field[name] != 'date_of_birth') {
                                        echo $field['formcode'];
                                    } else {
                                        ?>

                            <select name ="date_of_birth[year]" class="required"
                                            id="yearField2"
                                            onchange="resetMonthAndDayByYear(2);">
                                        <option value="0">Year</option>
                                        <?php
                                        $year = 0;
                                        if (!empty($field[value])) {
                                            $time = strtotime($field[value]);
                                            $year = date("Y", $time);
                                        }
                                        $y = date("Y");
                                        $x = $y - 18;
                                        for (; $x >= 1901; $x--) {
                                            if ($x == $year) {
                                                echo '<option selected="0"selected" value="' . $x . '">' . $x . '</option>';
                                            } else {
                                                echo '<option value="' . $x . '">' . $x . '</option>';
                                            }
                                        }
                                        ?>
                                    </select><select onchange="resetMonthAndDayByMonth(2);" class="required" name="date_of_birth[month]" id="jform_month2">
                                        <option selected="selected" value="0">Month</option>    
                                        <?php
                                        $month = "";
                                        $monthNo = 0;
                                        if (!empty($field[value])) {
                                            $time = strtotime($field[value]);
                                            $month = date("F", $time);
                                        }
                                        for ($i = 1; $i <= 12; $i++) {
                                            $monthName = date("F", mktime(0, 0, 0, $i, 10));
                                            if ($month == $monthName) {
                                                $monthNo = $i;
                                                ?>
                                                <option selected="selected" value="<?php echo $i; ?>"><?php echo $monthName; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $i; ?>"><?php echo $monthName; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </select>
                                    <select size="1" class="required" name="date_of_birth[day]" id="jform_day2">
                                        <option selected="selected" value="0">Day</option>
                                        <?php
                                        $day = 0;
                                        if (!empty($field[value])) {
                                            $time = strtotime($field[value]);
                                            $day = date("d", $time);
                                        }

                                        $totalDay = 31;
                                        if ((($year % 4) == 0) && ($monthNo == 2)) {
                                            $totalDay = 29;
                                        } else {
                                            if ($monthNo == 2) {
                                                $totalDay = 28;
                                            } else {
                                                if ($monthNo == 0 || $monthNo == 1 || $monthNo == 3 || $monthNo == 5 || $monthNo == 7 || $monthNo == 8 || $monthNo == 10 || $monthNo == 11 || $monthNo == 12) {
                                                    $totalDay = 31;
                                                } else {
                                                    $totalDay = 30;
                                                }
                                            }
                                        }
                                        for ($i = 1; $i <= $totalDay; $i++) {
                                            if ($i == $day) {
                                                ?>
                                                <option selected="selected" value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } else { ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php
                    }
                }
                ?>
                                    </select>
            <?php
        }
                            ?>
                        </td>
                    </tr>
                    <?php
            }
        ?>
    </table>
<?php
if($this->address_type == 'XT'){
				echo JText::_ ('COM_VIRTUEMART_USER_FORM_ST_SAME_AS_BT');
                                if (!class_exists ('VmHtml')) {
                                        require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'html.php');
                                }?>
            <input id="STsameAsBT" type="checkbox" name="STsameAsBT" value="1" onclick="stSameAsBT(this.id);">
             <?php 
}
                                }
        ?>
<?php
        if($this->address_type != 'BT'){?>        
<h2 style="color : #666; padding-left: 10px ;font-size: 16px;  line-height: 32px; background: #f0f0f0;">
                            Your Shipping Address
                        </h2>
    <table  class="adminForm user-details">            
        <?php
        foreach ($this->userFieldsST['fields'] as $field) {            
                ?>
                <tr>
                    <td class="key" title="<?php echo $field['description'] ?>" >
                        <label class="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>_field">
                            <?php echo $field['title'] . ($field['required'] ? ' *' : '') ?>
                        </label>
                    </td>
                    <td>
                        <?php if ($field['type'] == 'radio' && $field['name'] == 'shipto_gender') {
                            ?>
                            <input type="radio" name="shipto_gender" value="1" id="shipto_gender_1"
                                       <?php if($field['value'] == 1)
                                           {echo 'checked';}else{echo ''; }?>/>Male
                                <input type="radio" name="shipto_gender" value="2" id="shipto_gender_2"
                                       <?php if($field['value'] == 2)
                                           {echo 'checked';}else{echo ''; }?>/>Female
                            <?php
                        } elseif ($field[name] != 'shipto_date_of_birth') {
                            echo $field['formcode'];
                        } else {
                            ?>

                        <?php echo $field->name; ?>
                            
                                    <?php echo $field->label; ?>
                            <select name ="shipto_date_of_birth[year]" class="required"
                                        id="yearField1"
                                        onchange="resetMonthAndDayByYear(1);">
                                    <option value="0">Year</option>
                                    <?php
                                    $year = 0;
                                    if (!empty($field[value])) {
                                        $time = strtotime($field[value]);
                                        $year = date("Y", $time);
                                    }
                                    $y = date("Y");
                                    $x = $y - 18;
                                    for (; $x >= 1901; $x--) {
                                        if ($x == $year) {
                                            echo '<option selected="0"selected" value="' . $x . '">' . $x . '</option>';
                                        } else {
                                            echo '<option value="' . $x . '">' . $x . '</option>';
                                        }
                                    }
                                    ?>
                                </select><select onchange="resetMonthAndDayByMonth(1);" class="required" name="shipto_date_of_birth[month]" id="jform_month1">
                                    <option selected="selected" value="0">Month</option>
                                    <?php
                                    $month = "";
                                    $monthNo = 0;
                                    if (!empty($field[value])) {
                                        $time = strtotime($field[value]);
                                        $month = date("F", $time);
                                    }
                                    for ($i = 1; $i <= 12; $i++) {
                                        $monthName = date("F", mktime(0, 0, 0, $i, 10));
                                        if ($month == $monthName) {
                                            $monthNo = $i;
                                            ?>
                                            <option selected="selected" value="<?php echo $i; ?>"><?php echo $monthName; ?></option>
                <?php } else { ?>
                                            <option value="<?php echo $i; ?>"><?php echo $monthName; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select><select size="1" class="required" name="shipto_date_of_birth[day]" id="jform_day1">
                                    <option selected="selected" value="0">Day</option>
                                    <?php
                                    $day = 0;
                                    if (!empty($field[value])) {
                                        $time = strtotime($field[value]);
                                        $day = date("d", $time);
                                    }
                                    $totalDay = 31;
                                    if ((($year % 4) == 0) && ($monthNo == 2)) {
                                        $totalDay = 29;
                                    } else {
                                        if ($monthNo == 2) {
                                            $totalDay = 28;
                                        } else {
                                            if ($monthNo == 0 || $monthNo == 1 || $monthNo == 3 || $monthNo == 5 || $monthNo == 7 || $monthNo == 8 || v == 10 || $monthNo == 11 || $monthNo == 12) {
                                                $totalDay = 31;
                                            } else {
                                                $totalDay = 30;
                                            }
                                        }
                                    }
                                    for ($i = 1; $i <= $totalDay; $i++) {
                                        if ($i == $day) {
                                            ?>
                                            <option selected="selected" value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } else { ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php
                            }
                        }
                        ?>
                                </select>
                <?php
            }
                        ?>
                    </td>
                </tr>
                <?php
        }
        ?>
    </table>
<input type="hidden" name="shipto_address_type_name" value="Shipping" />
        <?php
     }
        ?>   
<div>                    
    <button type="submit" class="regbutton">CONFIRM >></button>
</div>
    <input type="hidden" name="option" value="com_users" />
    <input type="hidden" name="view" value="management" />
    <input type="hidden" name="task" value="management.editaddress" />
    <input type="hidden" name="address_type" value="<?php echo $this->address_type;?>" />
    <?php
if (!empty($this->virtuemart_userinfo_id)) {
    echo '<input type="hidden" name="shipto_virtuemart_userinfo_id" value="' . (int) $this->virtuemart_userinfo_id . '" />';
}
echo JHTML::_('form.token');
?>
</form>    
