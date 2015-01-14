$(function() {
	  	  $("tr.inner-row").css('background-color', 'rgb(102, 152, 204, 0.1)');
		  $("tr:not(.accordion)").hide();
		  $("tr.inner").hide();
		  $("tr.normal").show();
		  $("tr.accordion").click(function(){
		  	$(this).nextUntil(".accordion", "tr").toggle();
		  	$("td.nest").hide();
		  	$("tr.nest-show").show();
		  	//if($(this).css('background-color')=="rgb(153, 204, 255)"){ $(this).css('background-color', '#99CCCC'); }
		  	//else{ $(this).css('background-color', '#FFFFFF'); }
		  	
		  	var name = $(this).attr('name');
		  	var parent_name = $(this).parent().attr('id');

		  	if(parent_name == 'armor-mods'){
			  	if(name == 'collapsed'){
			  		$(this).css('background-color', '#8FBCDD');
			  		$(this).attr('name', 'expanded')
			  	}
			  	else{
			  		$(this).prop('name', 'collapsed');
			  		$(this).css("background-color", '#FFFFFF');
			  	}
			 }

			 if(parent_name == 'weapon-mods'){
			  	if(name == 'collapsed'){
			  		$(this).css('background-color', 'rgb(102, 152, 204, 0.5)');
			  		$(this).attr('name', 'expanded')
			  	}
			  	else{
			  		$(this).prop('name', 'collapsed');
			  		$(this).css("background-color", '#FFFFFF');
			  	}
			 }


			 else if(parent_name == 'uniques'){
			 	if(name == 'collapsed'){
				 	$(this).css('background-color', '#CC9966');
				  	$(this).attr('name', 'expanded');
				}
				else{
					$(this).prop('name', 'collapsed');
			  		$(this).css("background-color", '#FFFFFF');
				}
			 }
		    });

		  $("tr.nest-accordion").click(function(){
		  	var name = $(this).attr('name');
		  	var parent_name = $(this).parent().attr('id');
		  	
		  	if(parent_name == 'armor-mods'){
			  	if(name == 'collapsed'){
			  		$(this).css('background-color', 'rgb(102, 152, 204, 0.5)');
			  		$(this).children().show();
			  		$(this).attr('name', 'expanded');
			  	}
			  	else{ 
			  		$(this).css('background-color', '#FFFFFF');
			  		$(this).children().hide();
			  		$(this).children(":first").toggle();
			  		$(this).attr('name', 'collapsed');
			  	}
			 }

			else if(parent_name == 'uniques'){

			 	if(name == 'collapsed'){
			 		$(this).css('background-color', '#FFF');
			  		$(this).children().show();
			  		$(this).attr('name', 'expanded');
			  		$(this).hover(function(){
			  			$(this).addClass('inactive');
			  		})
			 	}
			 	else{
			 		$(this).css('background-color', '#DDDDD');
			  		$(this).children().hide();
			  		$(this).children(":first").toggle();
			  		$(this).attr('name', 'collapsed');
			 	}
			}
	 });
 });
