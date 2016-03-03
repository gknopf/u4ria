<?php
$fields = array();
$fields['video_link']= $_GET['url'];
// get type and thumb for youtube and vimeo
if (strpos($fields['video_link'], 'www.youtube.com') !== false) {
  $fields['video_type'] = 1;

  preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=embed\/)[^"&\n]+|(?<=‌​(?:v|i)=)[^&\n]+|(?<=youtu.be\/)[^&\n]+#', $fields['video_link'], $matches);
  $fields['video_id'] = $matches[0];
} else if (strpos($fields['video_link'], 'vimeo.com') !== false) {
  $fields['video_type'] = 2;

  preg_match('/(\d+)/', $fields['video_link'], $matches);
  $fields['video_id'] = $matches[0];

}
?>
<?php 
if ($fields['video_type'] ==1) :
?>
<iframe width="500" height="300" 
        src="http://www.youtube.com/embed/<?php echo $fields['video_id']  ?>?feature=oembed&amp;autoplay=1&amp;wmode=opaque&amp;rel=0&amp;showinfo=0&amp;modestbranding=1&amp;version=3&amp;ps=docs&amp;nologo=1&amp;theme=light&amp;color=white&amp;iv_load_policy=0&amp;cc_load_policy=1" 
        frameborder="0" allowfullscreen="">
</iframe>
<?php elseif($fields['video_type'] ==2): ?>
<iframe src="http://player.vimeo.com/video/<?php echo $fields['video_id']  ?>?portrait=0&amp;color=ffffff&amp;title=0&amp;byline=0&amp;autoplay=1" 
        width="500" height="300" frameborder="0" 
        webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
<?php else: ?>
<?php endif; ?>