<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

widget_css();

if( $widget_config['forum1'] ) $_bo_table = $widget_config['forum1'];
else $_bo_table = $widget_config['default_forum_id'];

if( $widget_config['width'] ) $post_width = $widget_config['width'];
else $post_width = 240;

if( $widget_config['height'] ) $post_height = $widget_config['height'];
else $post_height = 180;

$limit = 4;

$list = g::posts( array(
			"bo_table" 	=>	$_bo_table,
			"limit"		=>	$limit,
			"select"	=>	"idx,domain,bo_table,wr_id,wr_parent,wr_is_comment,wr_comment,ca_name,wr_datetime,wr_hit,wr_good,wr_nogood,wr_name,mb_id,wr_subject,wr_content"
				)
		);	
//di($list);exit;		
?>
<div class='x-gallery-outer'>
<ul class="x-gallery">
<?
	$count_image = 0;
	for ($i=0; $i<count($list); $i++) {
		$_wr_id = $list[$i]['wr_id'];
		if ( $count_image >= 4 ) break;
			$thumb = x::post_thumbnail($_bo_table, $_wr_id, $post_width, $post_height);    					            
			if( empty($thumb['src'])) {
				$_wr_content = db::result("SELECT wr_content FROM $g5[write_prefix]$_bo_table WHERE wr_id='$_wr_id'");
				$image_from_tag = g::thumbnail_from_image_tag( $_wr_content, $_bo_table, $post_width, $post_height);
				if ( empty($image_from_tag) ) $image_from_tag = g::thumbnail_from_image_tag( '<img class="img_left" src="'.x::url()."/widget/".$widget_config['name'].'/img/no-image.png"/>', $_bo_table, $post_width-2, $post_height-1 );
				$img = "<img class='img_left' src='$image_from_tag'/>";
			} else 	$img = '<img class="img_left" src="'.$thumb['src'].'">';
			$count_image ++;
?>	
		<li>
			<div class='post' no="<?=$count_image?>">
				<div class='photo'><a href="<?=$list[$i]['url']?>"><?=$img?></a></div>
				<div class='text'>
					<div class='title'><a href="<?=$list[$i]['url']?>"><?php echo cut_str($list[$i]['wr_subject'], 20, "..") ?></a></div>
					<div class='desc'><a href="<?=$list[$i]['url'] ?>"><?php echo get_text(cut_str(strip_tags($list[$i]['wr_content']), 65, '...' )) ?></a></div>
				</div>
			</div>
		</li>
<?php } ?>
</ul>
<div style='clear:both;'></div>
</div>
