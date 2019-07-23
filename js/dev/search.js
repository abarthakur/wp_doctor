$( "#searchForm" ).on( "submit", function( event ) 
{
		event.preventDefault();
		// console.log( $( this ).serialize() );
		console.log($(this));
		var form_json= $(this).serializeArray();
		console.log(form_json);
		var new_json = {};
		form_json.forEach(element => {
			if ("name" in element)
			{
				if (!(element.name in new_json)){
					new_json[element.name]=element.value;
				}
				else{
					new_json[element.name]+="+"+element.value;
				}
			}
		});
		console.log(new_json);

		var query_params=$.param(new_json,true);
		console.log(query_params);
		// var query_params=$( this ).serialize();
		var query="<?php echo esc_url( home_url( '/' ) ); ?>"+"search"
		console.log( query_params);
		console.log(query);
		
		console.log(query+"?"+query_params);
		window.location.href = query+"?"+query_params;
		
});