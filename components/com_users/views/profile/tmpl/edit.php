<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$user = JFactory::getUser();
?>
<style type="text/css">
    .field{ padding-bottom: 5px;}
    .sizeinput{ width: 200px}
    .sizeinputselect{ width: 204px; height: 22px;}
</style>
<script type="text/javascript">
    function resetMonthAndDayByYear() {
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
        document.getElementById('jform_day').innerHTML = $dayText31;
        document.getElementById('jform_month').value = 0;
    }
    function resetMonthAndDayByMonth() {
        $y = document.getElementById('yearField').value;
        $m = document.getElementById('jform_month').value;
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
            document.getElementById('jform_day').innerHTML = $dayText29;
        } else {
            if ($m == 2) {
                document.getElementById('jform_day').innerHTML = $dayText28;
            } else {
                if ($m == 1 || $m == 3 || $m == 5 || $m == 7 || $m == 8 || $m == 10 || $m == 11 || $m == 12) {
                    document.getElementById('jform_day').innerHTML = $dayText31;
                } else {
                    document.getElementById('jform_day').innerHTML = $dayText30;
                }
            }
        }
    }
</script>
<h2>Edit Profile</h2>
<div id="regform" class="registration<?php echo $this->pageclass_sfx ?>">
    <h3>Your Personal Detail</h3>

    <?php if ($this->params->get('show_page_heading')) : ?>
        <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php endif; ?>

    <form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=profile.save'); ?>" method="post" class="form-validate">
        <?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one. ?>
            <?php $fields = $this->form->getFieldset($fieldset->name); ?>
                <fieldset class="<?php echo $fieldset->name; ?>">
                    <?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.
                        ?>
                        <legend><?php echo JText::_($fieldset->label); ?></legend>
                    <?php endif; ?>
                    <dl>
                        <?php
                        foreach ($fields as $field):
                                if ($field->name == 'jform[gender]') {
                                ?>
                        <div class="field <?php echo $field->name; ?>">
                                        <dt>
                                        <?php echo $field->label; ?>
                                        </dt>
                                        <dd>
                                <input type="radio" name="jform[gender]" value="1" id="gender_1"
                                       <?php if($field->value == 1)
                                           {echo 'checked';}else{echo ''; }?>/>Male
                                <input type="radio" name="jform[gender]" value="2" id="gender_2"
                                       <?php if($field->value == 2)
                                           {echo 'checked';}else{echo ''; }?>/>Female
                                </dd>
                                    </div>
                                <?php
                            }else{
                                if ($field->name != 'jform[day]' &&
                                        $field->name != 'jform[month]' && $field->name != 'jform[year]') {
                                    ?>
                                    <div class="field <?php echo $field->name; ?>">
                                        <dt>
                                        <?php echo $field->label; ?>
                                        <?php if (!$field->required && $field->type != 'Spacer'): ?>

                                        <?php endif; ?>
                                        </dt>
                                        <dd><?php echo ($field->type != 'Spacer') ? $field->input : "&#160;"; ?></dd>
                                    </div>
                                <?php
                                }else {
                                    if ($field->name == 'jform[year]') {
                                        ?>
                                        <div class="field <?php echo $field->name; ?>">
                                            <dt>
                                            <?php echo $field->label; ?>
                                            <?php if (!$field->required && $field->type != 'Spacer'): ?>

                        <?php endif; ?>
                                            </dt>
                                            <dd><select name ="jform[year]" class="sizeinputselectbirthday"
                                                        id="yearField"
                                                        onchange="resetMonthAndDayByYear();">
                                        <option value="0">Year</option>
                                        <?php
                                        $year = 0;
                                        if (!empty($user->birth_day)) {
                                            $time = strtotime($user->birth_day);
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
                                                </select>
                                        <select onchange="resetMonthAndDayByMonth();" class="required" name="jform[month]" id="jform_month">
                                        <option selected="selected" value="0">Month</option>
                                            <?php
                                            } else if ($field->name == 'jform[month]') {
                                                ?>
                                                <?php
                                        $month = "";
                                        $monthNo = 0;
                                        if (!empty($user->birth_day)) {
                                            $time = strtotime($user->birth_day);
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
                                        ?></select>
                                            <?php } else {
                                                ?>
                                        <select size="1" class="required" name="jform[day]" id="jform_day">
                                        <option selected="selected" value="0">Day</option>
                                        <?php
                                        $day = 0;
                                        if (!empty($user->birth_day)) {
                                            $time = strtotime($user->birth_day);
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
                                    </select></dd></div>
                                        <?php
                                    }
                                }
                            } endforeach; ?>
                    </dl>
                </fieldset>
<?php endforeach; ?>

        <div>
            <button type="submit" class="regbutton">SUBMIT >></button>
<?php echo JText::_('COM_USERS_OR'); ?>
            <a style="border: 1px solid #B00C97;;padding: 3px;color: #B00C97;" href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="profile.save" />
<?php echo JHtml::_('form.token'); ?>
        </div>
    </form>
</div>
