window.onload = function(){
	$(".clamped-text-container").each( function (index){
		//TODO : Replace 16 with package.json param
		var staticHeight=$(this).parent().height() - 16;
		$clamp(this,{clamp:staticHeight.toString()+"px",useNativeClamp:false,nukeElements:false});
	});
};