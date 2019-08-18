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
};