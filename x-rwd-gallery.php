<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

widget_css();

if( $widget_config['forum1'] ) $bo_table = $widget_config['forum1'];
else $bo_table = bo_table(1);

if( $widget_config['width'] ) $post_width = $widget_config['width'];
else $post_width = 240;

if( $widget_config['height'] ) $post_height = $widget_config['height'];
else $post_height = 180;

$limit = 4;

$list = g::posts( array(
			"bo_table" 	=>	$bo_table,
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
		
		if ( $count_image >= 4 ) break;
			$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $post_width, $post_height);    					            
			if($thumb['src']) {
				$img = '<img class="img_left" src="'.$thumb['src'].'">';
				$count_image ++;
			} /*
			elseif ( $image_from_tag = g::thumbnail_from_image_tag( $list[$i]['wr_content'], $bo_table, $post_widthwidth-2, $post_widthheight-1 )) {
				$img = "<img class='img_left' src='$image_from_tag'/>";
				$count_image ++;
			}*/
			else {
				$img = '<img class="img_left" src="'.x::url()."/widget/".$widget_config['name'].'/img/no-image.png"/>';
				$no_image = g::thumbnail_from_image_tag( $img, $bo_table, $post_width-2, $post_height-1 );
				$img = "<img class='img_left' src='$no_image'/>";
				$count_image ++;
			}
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
