window.onload = function(){
	//Startup code 

	$(".clamped-text-container").each( function (index){
		//TODO : Replace 16 with package.json param
		var staticHeight=$(this).parent().height() - 16;
		$clamp(this,{clamp:staticHeight.toString()+"px",useNativeClamp:false,nukeElements:false});
	});

	//check if default query matches current number of posts or else load more
	$(".preview-post-wall").each( function(index,value){
		var url=$(".default.pwall-tag-link:first",$(this)).attr("href");
		url=parsePWallUrl(url);
		//matche regex and get count
		var reg= /\?count=(\d*)/i;
		var matches=reg.exec(url);
		var count=parseInt(matches[1]);
		if ($(".post-col",$(this)).length!=count){
			loadQueryIntoWall(url,$(this));
		}

	});

	//Handlers
	$(".place-tabbed-pane [role='tab']").click(function(event){
		var selected=$(this).attr('aria-selected');
		if (selected!="true" && selected!="false"){
			return;
		};
		$(this).siblings(".place-tabbed-pane [role='tab']").attr('aria-selected','false');
		$(this).attr('aria-selected','true');
	
		var targetId=$(this).attr('aria-controls');
		$("[role='tabpanel'].active",$(this).closest(".place-tabbed-pane")[0]).removeClass('active');
		$('#' + targetId).addClass('active');
	});


	$( ".appform" ).on( "submit", function( event ) 
	{
		event.preventDefault();
		console.log( $( this ).serialize() );
		var params=$( this ).serialize();
		var url="/post-form";
		$.post(url,params,function(data,status){
			if (status=="success"){
				console.log(data);
			}
		});
	});

	$(".taglist .pwall-tag-link").on("click", function(event){
		event.preventDefault();
		var activeChanged=changeActiveTag($(this));
		if (!activeChanged){
			return;
		}
		var $wall=$($(this).closest(".preview-post-wall")[0]);
		var activeTag=$(".pwall-tag-link.active",$wall)[0];
		var url=$(activeTag).attr("href");
		url = parsePWallUrl(url);
		loadQueryIntoWall(url,$wall);
	});
};


function changeActiveTag($clicked){
	//the default tag has been clicked, while active
	if ($clicked.hasClass("default") && $clicked.hasClass("active")){
		//nothing to do
		return false;
	}
	//some non defualt, active tag is clicked
	else if ($clicked.hasClass("active")){
		//make "default" tag as active
		$clicked.removeClass("active");
		var defaultTag = $clicked.siblings(".default");
		$(defaultTag).addClass("active");
		return true;
	}
	//some inactive tag is clicked
	else{
		//make this tag as active
		$clicked.siblings(".pwall-tag-link").removeClass("active");
		$clicked.addClass("active");
		return true;
	}
}


function parsePWallUrl(url){
	var urlParts=url.split("?");
	var countError=new Error("Tag wall url "+url+" doesn't specify count");
	//url must has a query string
	if (urlParts.length<1){
		throw countError;
	}
	var query=urlParts[1];
	//separate other query params from count params
	var params=query.split("&");
	var countParams=[];
	var otherParams=[];
	for (var i=0;i<params.length;i++){
		if (params[i].startsWith("count")){
			countParams.push(params[i]);
		}
		else{
			otherParams.push(params[i]);
		}
	}
	//query string must contain at least one query string parameter
	if (countParams.length<1){
		throw countError;
	}

	// get the count for the largest min-width parameter that matches. 
	// For ex, for count, count_440, count_768, if the min-width is 550, 
	// we must send count_440's value as the count parameter.
	var count=0;
	var maxMinWidth=-1;
	var parMinWidth=0;
	for (var i=0;i<countParams.length;i++){
		var pair=countParams[i].split("=");
		var cparts=pair[0].split("_");
		if (cparts.length==1){//default count
			parMinWidth=0;
		}
		else if (cparts.length==2){
			parMinWidth=parseInt(cparts[1]);
		}
		else{
			throw new Error ("Invalid count parameter "+pair[0])
		}
		if (parMinWidth > maxMinWidth &&
			window.matchMedia("(min-width: "+parMinWidth.toString()+"px)").matches){
			count=parseInt(pair[1]);
			maxMinWidth=parMinWidth;
		}
	}
	//construct the new url
	var newUrl = urlParts[0]+"?";
	newUrl += "count=" + count.toString()
	for (var i=0; i<otherParams.length;i++){
		newUrl+="&"+otherParams[i];
	}
	return newUrl;
}


function loadQueryIntoWall(url,$wall){
	$.get(url,function(data,status,jqxhr){
		var html=$.parseHTML(data);
		var $results=$(".post-preview-card",html);
		var $wallrow=$($(".posts-container .row",$wall)[0]);
		var colClasses=$wallrow.children(".post-col")[0].classList;
		$wallrow.children(".post-col").remove();
		$results.each(function(index,el){
			var newCol=document.createElement("div");
			$(newCol).addClass(colClasses.value);
			newCol.appendChild(el);
			$wallrow.append(newCol);
		});

		$wall.find(".clamped-text-container").each( function (index){
			//TODO : Replace 16 with package.json param
			var staticHeight=$(this).parent().height() - 10;
			$clamp(this,{clamp:staticHeight.toString()+"px",useNativeClamp:false,nukeElements:false});
		});
	});
}