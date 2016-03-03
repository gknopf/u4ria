<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h2 style="color: #B00C97; margin-bottom: 20px; margin-top: 20px;">Gift Certificate</h2>
<label>
    To buy a gift certificate, kindly fill in the information below
</label>
<form method="post" class="product js-recalculate" action="<?php echo JRoute::_('index.php'); ?>">
    <div style="margin-top: 20px;margin-left: 20px;">
        <div>
            <div style="width: 100px; float: left;">
                Message

            </div>
            <div>
                <textarea style="width: 200px;"></textarea>
            </div>
        </div>
        <div>
            <div style="width: 100px; float: left;">
                Gift

            </div>
            <div>
                <select style="width: 206px;" name="virtuemart_product_id[]">
                    <?php
                    foreach ($this->giftcertificate as $key => $value) {
                        echo "<option value = '" . $value->virtuemart_product_id . "'>" .
                        $value->product_name .
                        "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div>
            <div style="width: 100px; float: left;">
                Quantity

            </div>
            <div>
                <input name="quantity" type="text" style="width: 202px;"></input>
            </div>
        </div>
        <div>

            <input type="checkbox" checked="false"  name="jform[age_check]1" id="jform_age_check1" value="" onclick="check1()" class="required" aria-required="true" required="required">

            <label id="jform_age_check-lbl1" for="jform_age_check1" class=" required">
                I understand that this gift certificate will expire one year after purchasing
                <span class="star">&nbsp;*</span></label>                                                                                </dt>
        </div>
        <div>

            <input type="checkbox" checked="false"  name="jform[age_check]2" id="jform_age_check2" value="" onclick="check2()" class="required" aria-required="true" required="required">

            <label id="jform_age_check-lbl2" for="jform_age_check2" class=" required">
                I understand that this gift certificate is not refundable
                <span class="star">&nbsp;*
                </span></label>                                                                                </dt>
        </div>
        <div>

            <input type="checkbox" checked="false"  name="jform[age_check]" id="jform_age_check" value="" onclick="check()" class="required" aria-required="true" required="required">

            <label id="jform_age_check-lbl" for="jform_age_check" class=" required">I am 18 years of age or older (depending on the  jurisdiction of your home country or state)<span class="star">&nbsp;*</span></label>                                                                                </dt>
        </div>
        <?php
        JPluginHelper::importPlugin('captcha');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onInit', 'dynamic_recaptcha_1');

//html code inside form tag
# are we submitting the page?
        ?>
        <div id="dynamic_recaptcha_1"></div>
        <script>
    document.getElementById('jform_age_check').checked = false;
        document.getElementById('jform_age_check1').checked = false;
            document.getElementById('jform_age_check2').checked = false;
        function check1()
        {
            if (document.getElementById('jform_age_check1').value == 1) {
            document.getElementById('jform_age_check1').value = "";
            document.getElementById('jform_age_check1').checked = false;
            } else {
    document.getElementById('jform_age_check1').value = 1;
        document.getElementById('jform_age_check1').checked = true;
            } 
            }
        function check2()
        {
            if (document.getElementById('jform_age_check2').value == 1) {
            document.getElementById('jform_age_check2').value = "";
            document.getElementById('jform_age_check2').checked = false;
            } else {
    document.getElementById('jform_age_check2').value = 1;
        document.getElementById('jform_age_check2').checked = true;
            }
            }
        function check()
        {
            if (document.getElementById('jform_age_check').value == 1) {
            document.getElementById('jform_age_check').value = "";
            document.getElementById('jform_age_check').checked = false;
            } else {
    document.getElementById('jform_age_check').value = 1;
                document.getElementById('jform_age_check').checked = true;
            }

        }

        </script>
        <input type="submit" name="addtocart" class="addtocart-button22" value="ADD TO CART" />
            <input type="hidden" name="option" value="com_virtuemart" />
    <input type="hidden" name="view" value="cart" />
    <input type="hidden" name="task" value="addGc" />
    <input type="hidden" name="controller" value="cart" />  
    </div>
</form>