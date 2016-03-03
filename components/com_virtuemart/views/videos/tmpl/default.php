<?php
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
$vmSiteurl = " var vmSiteurl = '" . JURI::root() . "';\n";
$document->addScriptDeclaration($vmSiteurl);
vmJsApi::css('jquery-ui', 'components/com_virtuemart/assets/css/ui');
vmJsApi::css('showvideo', 'components/com_virtuemart/assets/css/video_slide_skins/ie7');
vmJsApi::css('product_alert');
vmJsApi::js('jquery.jcarousel.min');
$document->addStyleDeclaration('
.jcarousel-skin-ie7 > div{
    margin:0 auto;
}
#category_videos li > div {
    margin-bottom:15px;
}
h3{
width: 888px;
margin: 0 auto;
border-bottom: 2px solid #92287f;
padding: 15px 0;
font-size: 22px;
color: #92287f;
}
.video_img{position: relative;overflow: hidden;}
.video_img img{
  width: 435px;
  height: 303px;
}
.video_img span{
        background: url(images/vplay.png) no-repeat center center;
    height: 33px;
    left: 185px;
    position: absolute;
    top: 145px;
    width: 67px;
}
p{
color: #92287f;
font-weight: bold;
margin-bottom: 5px
}
.jcarousel-skin-ie7 .jcarousel-next-horizontal,
.jcarousel-skin-ie7 .jcarousel-prev-horizontal{
top: 280px;
}
');
$vmSac = "
jQuery(document).ready(function() {
    jQuery('#category_videos').jcarousel({
        scroll:2
    });     
});
";
$document->addScriptDeclaration($vmSac);
$video_array = $this->videos;
?>
<h3><?php echo $this->page_title; ?></h3>
        <?php if ($this->videos): ?>
        <ul id="category_videos" class="jcarousel-skin-ie7 fullnewvideo">
        <?php for ($i = 0; $i < count($video_array); $i+=2): ?>   
                        <li class="floatleft">
                                <div>
                                    <p style="height: 40px;"><?php echo $video_array[$i]->video_title; ?></p>
                                        <p class="video_img" name="<?php echo $i?>"
                                           id="<?php echo getVideo($video_array[$i]->video_link)->vid; ?>"
                                           vid="<?php echo getVideo($video_array[$i]->video_link)->vid; ?>" 
                                           vtype="<?php echo getVideo($video_array[$i]->video_link)->vtype; ?>">
                                                <span class="video_button"></span>
                                                <?php // echo getVideo($video_array[$i + 1]->video_link)->view; ?>
                                                <?php echo '<img src="'.getVideo($video_array[$i]->video_link)->img.'" />'; ?>
                                        </p>
                                </div>
                                <div>
                                        <p style="height: 40px;"><?php echo $video_array[$i + 1]->video_title; ?></p>
                                        <p class="video_img" name="<?php echo $i?>"
                                           id="<?php echo getVideo($video_array[$i + 1]->video_link)->vid; ?>"
                                           vid="<?php echo getVideo($video_array[$i + 1]->video_link)->vid; ?>" 
                                           vtype="<?php echo getVideo($video_array[$i + 1]->video_link)->vtype; ?>">
                                                <span class="video_button"></span>
                                                <?php // echo getVideo($video_array[$i + 1]->video_link)->view; ?>
                                                <?php echo '<img src="'.getVideo($video_array[$i + 1]->video_link)->img.'" />'; ?>                                                
                                        </p>
                                </div>
                        </li>
        <?php endfor; ?>
        </ul>
<?php endif; ?>
<!-- FORM EDIT-->
<script>
jQuery(function(){
  jQuery('p.video_img').click(function(){
    showvideo(this, jQuery(this).attr('vtype'),jQuery(this).attr('vid'))
  });
});
function showvideo(div, type,id){
        if(type==1){
            jQuery(div).html('<iframe width="435" height="303" src="//www.youtube.com/embed/' + id + '?rel=0&amp;autoplay=1" frameborder="0" showinfo="0" nologo="1" allowfullscreen></iframe>');    
        }
        if(type==2){
            jQuery(div).html('<iframe src="//player.vimeo.com/video/'  + id + '?portrait=0&amp;color=ffffff&amp;title=0&amp;byline=0&amp;autoplay=0" width="435" height="303" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');    
        }
}
</script>
<?php

function getVideo($link) {
        $fields = array();
        $fields['video_link'] = $link;
        // get type and thumb for youtube and vimeo
        if (strpos($fields['video_link'], 'www.youtube.com') !== false) {
                $fields['video_type'] = 1;

                preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=‌​(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+#', $fields['video_link'], $matches);
                $fields['video_id'] = $matches[0];
                $source = '
              <iframe width="435" height="303" src="//www.youtube.com/embed/' . $fields['video_id'] . '" frameborder="0" showinfo="0" nologo="1" allowfullscreen></iframe>
            ';
                $fields['video_thumb'] = 'http://img.youtube.com/vi/' . $fields['video_id'] . '/0.jpg';
        } else if (strpos($fields['video_link'], 'vimeo.com') !== false) {
                $fields['video_type'] = 2;

                preg_match('/(\d+)/', $fields['video_link'], $matches);
                $fields['video_id'] = $matches[0];
                $source = '
                <iframe src="http://player.vimeo.com/video/' . $fields['video_id'] . '?portrait=0&amp;color=ffffff&amp;title=0&amp;byline=0&amp;autoplay=0" 
                width="435" height="303" frameborder="0" 
                webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                ';
                $vimeo_url = 'http://vimeo.com/api/v2/video/' . $fields['video_id'] . '.php'; //build url api
                $vimeo_data = unserialize(file_get_contents($vimeo_url));

                $thumb = $vimeo_data[0]['thumbnail_medium'];
                $fields['video_thumb'] = $thumb;
        }
        $video->view = $source;
        $video->vid = $fields['video_id'];
        $video->vtype = $fields['video_type'];
        $video->img = $fields['video_thumb'];
        return $video;
}
?>