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
?>
<style type="text/css">
    .field{ padding-bottom: 5px;}
    .sizeinput{ width: 200px}
    .sizeinputselect{ width: 204px; height: 22px;}
</style>
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
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
<h2>Registration Form</h2>
<div id="regform" class="registration<?php echo $this->pageclass_sfx ?>">
    <h3>Your Personal Detail</h3>

    <?php if ($this->params->get('show_page_heading')) : ?>
        <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php endif; ?>

    <form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate">
        <?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one. ?>
            <?php $fields = $this->form->getFieldset($fieldset->name); ?>
            <?php if (count($fields) && $fieldset->name != 'checks'): ?>
                <fieldset class="<?php echo $fieldset->name; ?>">
                    <?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.
                        ?>
                        <legend><?php echo JText::_($fieldset->label); ?></legend>
                    <?php endif; ?>
                    <dl>
                        <?php foreach ($fields as $field):// Iterate through the fields in the set and display them. ?>
                            <?php if ($field->hidden):// If the field is hidden, just display the input.?>
                                <?php echo $field->input; ?>
                                <?php
                            else:
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
                                                    $y = date("Y");
                                                    $x = $y - 18;
                                                    for (; $x >= 1901; $x--) {
                                                        echo '<option value="' . $x . '">' . $x . '</option>';
                                                    }
                                                    ?>
                                                </select>

                                            <?php
                                            } else if ($field->name == 'jform[month]') {
                                                ?>
                                                <?php echo ($field->type != 'Spacer') ? $field->input : "&#160;"; ?>
                                            <?php } else {
                                                ?>
                                        <?php echo ($field->type != 'Spacer') ? $field->input : "&#160;"; ?></dd></div>
                                        <?php
                                    }
                                }
                            endif;
                            ?>
        <?php endforeach; ?>
                    </dl>
                </fieldset>
                <?php elseif ($fieldset->name == 'checks'): ?>
                <fieldset class="<?php echo $fieldset->name; ?>">
                    <?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.
                        ?>
                        <legend><?php echo JText::_($fieldset->label); ?></legend>
                        <?php endif; ?>
                    <dl>
                        <?php foreach ($fields as $field):// Iterate through the fields in the set and display them.?>
                            <?php if ($field->hidden):// If the field is hidden, just display the input. ?>
                                <?php echo $field->input; ?>
                            <?php else:
                                if ($field->name == 'jform[age_check]') {
                                    ?>
                                    <div class="field <?php echo $field->name; ?>">
                                        <dd><?php echo ($field->type != 'Spacer') ? $field->input : "&#160;"; ?></dd>
                                        <dt>
                                        <?php echo $field->label; ?>
                                        <?php if (!$field->required && $field->type != 'Spacer'): ?>

                                    <?php endif; ?>
                                        </dt>
                                    </div>
                <?php } else if ($field->name == 'jform[notes]') { ?>
                                    <div class="field <?php echo $field->name; ?>">
                                        <dd><?php echo ($field->type != 'Spacer') ? $field->input : "&#160;"; ?></dd>
                                        <dt>
                                        <label style="color: #B60D9D; font-weight: bold">Security check : </label>
                                        <label>Your privacy is important to us, we DO NOT rent, sell or reveal your personal infomation to 3rd parties. To learn more, read our privacy policy page.</label>
                                        </dt>
                                    </div>
                <?php }else { ?>
                                    <div class="field <?php echo $field->name; ?>">
                                        <dd style="margin: 0px;"><?php echo ($field->type != 'Spacer') ? $field->input : "&#160;"; ?></dd>                                        
                                    </div>
                                <?php } ?>
            <?php endif; ?>
                <?php endforeach; ?>
                    </dl>
                </fieldset>
    <?php endif; ?>
<?php endforeach; ?>

        <div>
            <button type="submit" class="regbutton">SUBMIT >></button>
<?php echo JText::_('COM_USERS_OR'); ?>
            <a href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="registration.register" />
<?php echo JHtml::_('form.token'); ?>
        </div>
    </form>
</div>
