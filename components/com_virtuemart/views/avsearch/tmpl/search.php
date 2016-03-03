<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');   
JHTML::stylesheet('vmpanels.css', JURI::root().'components/com_virtuemart/assets/css/');
$image = JURI::base().'components/com_virtuemart/assets/images/vmgeneral/avsgo-button.png' ;
vmJsApi::css('jquery-ui', 'components/com_virtuemart/assets/css/ui');
vmJsApi::css('product_alert');
?>
<div class="vs">
<div class="avhead"><?php echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH'); ?></div>    
<form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&search=true&limitstart=0'); ?>" method="get">
<table>
	<tr>
            <td colspan="3"  class="keylable"><?php echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH_KEY'); ?></td>
        </tr>
        <tr>   
            <td colspan="3">
                 <input name="keyword" class="inputbox" type="text" size="20" value="<?php echo $this->keyword ?>"/>
            </td>
	</tr>
        <tr>
            <td width="160px"><?php echo JText::_ ('Search by Product Code'); ?></td>
            <td><input type="text" name="sku"  style="width:50%"  value="<?php echo $this->sku; ?>"/></td>
            <td class="boxText sd">
               <a  class="help_popup" >Search help[?]</a>
            </td>
        </tr>
        <tr>
            <td  width="80px"><?php echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH_CAT'); ?></td>
            <td>
           <?php             
                echo "<select name=\"category\" style=\"vertical-align :middle;display:block;width:100%\">";
                echo '<option value="">All Categories:</option>';             
$array = array(
124 => true, 
126=>true,
125 => true,				
118 => true,
121 => true,
120 => true,
123 => true,
122 => true,
119 => true,
134 => true,
135 => true,
137 => true,
138 => true,
141 => true,
142 => true,
143 => true,
139 => true,
140 => true,
131 => true,
136 => true,
133 => true,
36 => true,
145 => true,
114 => true,
115 => true,
116 => true,
117 => true,
102 => true,
103 => true,
104 => true,
110 => true,
105 => true,
106 => true,
107 => true,
108 => true,
109 => true,
129 => true,
130 => true,);
                foreach ($this->categories as $category ) {  
						if (array_key_exists($category->virtuemart_category_id, $array)){
							continue;
						}				
                        echo '<option  value="'.$category->virtuemart_category_id.'" '.$category->curent.'>'.$category->category_name.'('.$category->productcount.')</option>';
                        if ($category->childs ) {                           
                                foreach ($category->childs as $child) {   
									if (array_key_exists($child->virtuemart_category_id, $array)){
										continue;
									}												
                                        echo '<option  value="'.$child->virtuemart_category_id.'"  '.$child->curent.'>&nbsp; &nbsp; &nbsp;'.$child->category_name.'('.$child->productcount.')</option>';
                                        if($child->childs){
                                            foreach ($child->childs as $ch) {
															if (array_key_exists($ch->virtuemart_category_id, $array)){
																continue;
															}												

                                                               echo '<option  value="'.$ch->virtuemart_category_id.'" '.$ch->curent.'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;'.$ch->category_name.'('.$ch->productcount.')</option>';
                                            }      
                                        }
                                }
                          
                        }
                }
                echo "</select>";
                

            ?>   
                
            </td>
                        <td align="right"  class="boxText sd">						
                            <!--<a  rel="{handler: 'iframe', size: {x: 620, y: 324}}" class="modal" href="index.php?option=com_content&view=article&id=36&tmpl=component&task=preview">Search help[?]</a>-->
                        </td>
        </tr>
        <tr>
            <td></td>
                <td align="left" colspan="3" class="boxText">
                    <input type="checkbox" name="sinsub" value="checked" <?php echo $this->sinsub; ?>><span class="cfi">  <?php echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH_INSUB'); ?></span>
                </td>
            <td></td>
        </tr>
<!--        <tr>
            <td><?php // echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH_MANUFA'); ?></td>
            <td>
                <?php 
//                echo "<select name=\"virtuemart_manufacturer_id\" width=\"50%\" style=\"vertical-align :middle;display:block;width:50%\">";
//                echo '<option value="">All Brands: </option>';
//                foreach ($this->manufacturers as $manufacturer ) {
//                    if($manufacturer->virtuemart_manufacturer_id == $this->virtuemart_manufacturer_id)
//                            echo '<option value="'.$manufacturer->virtuemart_manufacturer_id.'" selected>'.$manufacturer->mf_name.'('.$manufacturer->count.')'.'</option>';
//                    else 
//                            echo '<option value="'.$manufacturer->virtuemart_manufacturer_id.'">'.$manufacturer->mf_name.'('.$manufacturer->count.')'.'</option>';
//                }
//                echo "</select>";
                ?>               
            </td>
            <td></td>
        </tr>-->
        <tr>
            <td><?php echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH_PRICE_FROM'); ?></td>
            <td><input type="text" name="pricefrom" style="width:50%" value="<?php echo $this->ip_pricefrom; ?>" /></td>
            <td></td>
        </tr>
        <tr>
            <td><?php echo JText::_ ('COM_VIRTUEMART_ADVANCED_SEARCH_PRICE_TO'); ?></td>
            <td><input type="text" name="priceto"  style="width:50%"  value="<?php echo $this->ip_priceto; ?>"/></td>
            <td></td>
        </tr>
        <tr>
            <td><input type="image"  src="<?php echo $image?>" class="" value="Go" style="vertical-align :middle;"></td>

            <td></td>
            <td></td>
            
        </tr>

</table>
    <input type="hidden" name="view" value="category"/>
    <input type="hidden" name="option" value="com_virtuemart"/>
    <input type="hidden" name="search" value="true"/>
</form>
</div>
<script>
        var url = "<?php echo JURI::base() ?>" + "index.php?option=com_content&view=article&id=36&tmpl=component&task=preview";
        var jhelp = jQuery.noConflict();
        jhelp(document).ready(function(){
           jhelp('.vs').append('<div id="help_popup" title="Welcome to U4ria Advanced Search!"></div>'); 
        }); 
        
        jhelp('.help_popup').click(function(){
        

        jhelp.post(url,{},function(res){  
                jhelp('#help_popup').dialog({
                    autoOpen: false,
                    modal: true,
                    width: 750,
                    height: 325  
                }); 
                jhelp('#help_popup').html(res);
                jhelp('#help_popup').dialog('open');
            });
        });  
</script>