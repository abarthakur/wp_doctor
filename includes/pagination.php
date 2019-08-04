<?php
/* --------------------------------------------------------------------
Pagination
-------------------------------------------------------------------- */

function doc_get_page_link_base_url($is_query_var){
	//structure of "format" depends on whether we're using pretty permalinks
	// need an unlikely integer
	$big = 999999999;
	$base_url=null;
	if( !$is_query_var) {
		//format = '?pag=%#%';
		$base_url=str_replace( $big, '%#%', esc_url(get_pagenum_link($big)) );
	} else {
		//format = 'page/%#%/';
		$base_url=@add_query_arg('pag','%#%');
	}
	return $base_url;
}

function doc_generate_page_links($base_url,$end_size,$mid_size,$total,$current){
	$links=array();

	$push_links = function($start,$end,$base_url,&$links)
	{
		for ($i=$start;$i<=$end;$i++){
			$link=str_replace('%#%',strval($i),$base_url);
			array_push($links,array("text"=>strval($i),"link"=>$link));
		}
	};

	if($current>1){
		$link=str_replace('%#%',strval($current-1),$base_url);
		array_push($links,array("text"=>"Prev","link"=>$link));
	}
	else{
		array_push($links,array("text"=>"Prev","link"=>""));
	}

	if ($current-1<=$mid_size+$end_size){
		$push_links(1,$current-1,$base_url,$links);
	}
	else{
		$push_links(1,$end_size,$base_url,$links);
		array_push($links,array("text"=>"...","link"=>""));
		$push_links($current-$mid_size,$current-1,$base_url,$links);
	}

	array_push($links,array("text"=>$current,"link"=>"current"));

	if ($total-$current<=$mid_size+$end_size){
		$push_links($current+1,$total,$base_url,$links);
	}
	else{
		$push_links($current+1,$current+$mid_size,$base_url,$links);
		array_push($links,array("text"=>"...","link"=>""));
		$push_links($total-$endsize+1,$total,$base_url,$links);
	}

	if($total > $current){
		$link=str_replace('%#%',strval($current+1),$base_url);
		array_push($links,array("text"=>"Next","link"=>$link));
	}
	else{
		array_push($links,array("text"=>"Next","link"=>""));
	}

	return $links;
}


function doc_print_page_links($aria_label,$links)
{?>
	<nav aria-label="<?php echo $aria_label;?>">
		<ul class="pagination">
		<?php
			for ($i=0;$i<count($links);$i++){
				$link=$links[$i]["link"];
				$classes="";
				if (!$link or $link==""){
					$classes .= "disabled";
					$link="#";
				}
				elseif ($link=="current"){
					$classes .=" active";
					$links[$i]["text"] .= '<span class="sr-only">(current)</span>';
					$link="#";
				}
				?>
				<li class="page-item <?php echo $classes;?>">
					<a class="page-link" href="<?php echo $link;?>"><?php echo $links[$i]["text"]?></a>
				</li>
				<?php
			}
		?>
		</ul>
	</nav>
<?php
}
?>
