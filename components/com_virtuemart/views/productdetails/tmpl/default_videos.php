<?php

defined('_JEXEC') or die('Restricted access');

if ($this->product->product_videos): ?>
  <ul id="category_videos" class="jcarousel-skin-ie7 video_list">
    <?php $video_array = $this->product->product_videos; ?>
    <?php foreach ($video_array as $key => $value): ?>
      <li class="floatleft">
          <?php $linkvideo = JRoute::_('index.php?option=com_virtuemart&view=videos&tmpl=component&virtuemart_product_id='.$this->product->virtuemart_product_id); ?>
          <a rel="" class="" href="<?php echo $linkvideo ?>" onclick="window.open(this.href, 'Video Product Page','left=200,top=10,width=1000,height=1500,toolbar=0,resizable=0, scrollbars=1'); return false;">
          <!--<a rel="{handler: 'iframe', size: {x: 520, y: 320}}" class="modal" href="view_videos.php?url=<?php echo $value->video_link;?>" target="_blank">-->
          <img alt="" src="<?php echo $value->video_thumb; ?>">
        </a>
        <span><?php echo $value->video_title; ?></span>
      </li>
    <?php endforeach; ?>
    <div class="clear"></div>
  </ul>
<?php else: ?>
<p class="nodemo">No Videos Demo</p>
<?php endif; ?>
