window.onload = function(){
	$(".clamped-text-container").each( function (index){
		//TODO : Replace 16 with package.json param
		var staticHeight=$(this).parent().height() - 16;
		$clamp(this,{clamp:staticHeight.toString()+"px",useNativeClamp:false,nukeElements:false});
	});

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
		var $this=$(this);
		var url="";
		if ($this.hasClass("default") && $this.hasClass("active")){
			return;
		}
		if ($this.hasClass("active")){
			$this.removeClass("active");
			var default_tag = $this.siblings(".default");
			url=$(default_tag).attr("href");
			$(default_tag).addClass("active");
		}
		else{
			$this.siblings(".pwall-tag-link").removeClass("active");
			url=$this.attr("href");
			$this.addClass("active");
		}
		$.get(url,function(data,status,jqxhr){
			var html=$.parseHTML(data);
			var $results=$(".post-preview-card",html);
			var $wall=$($this.closest(".preview-post-wall")[0]);
			var $wallrow=$($(".posts-container .row",$wall)[0]);
			var colClasses=$wallrow.children(".post-col")[0].classList;
			console.log(colClasses);
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
	});
};