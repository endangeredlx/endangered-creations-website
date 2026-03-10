/**
 * 
 *
 * 
 *
 * 		I did this for my homies back home.
 *   
 *   
 *
 * 
 */

$(document).ready( function() {

	$("#main_menu li a.has_sub").click( drop_down ).hover( function() { $(this).addClass("subhover"); }, function() { $(this).removeClass("subhover"); });
	$('.wysiwyg').wysiwyg();
	$('body').delegate('.make_album_cover','click',make_album_cover);
	$('body').delegate('.move_up','click',move_pic_up);
	$('body').delegate('.move_down','click',move_pic_down);
	$('.d_palbum').click( delete_photo_album );
	$('.delete_photo').click( delete_photo );
	$('#delete_entry_photo').click( delete_entry_photo );
	$('.d_entry').click( delete_entry );
	$('.d_port').click( delete_port_item );
	$('body').delegate('.hl_type', 'change', change_articles );
	$('body').delegate('.hl_entry_select', 'change', change_hl_image );
	$('body').delegate('#SaveLayout', 'click', save_layout );
			
});

/*---------------------------------------------------------------------------------------*/
/////////////////////////////////////////////////////////////////////////////////////////
//
//    HOME/LAYOUT FUNCTIONS
//
/////////////////////////////////////////////////////////////////////////////////////////
/*---------------------------------------------------------------------------------------*/

function change_articles()
{
	var type = $(this).val();
	var pos = $(this).parent().attr('hlid');
	var populate_me = $(this).parent().find('#article_area');
	$.ajax({
		url: "index.php?admin/get_" + type + "/" + pos,
		type: 'POST',
		success: function(data) {
			populate_me.html( data );
		}
	});
}

function change_hl_image()
{
	var type = $(this).parent().parent().find('.hl_type').val();
	var changeMe = $(this).parent().parent().find('.hl_image');
	var pid = $(this).val();
	$.ajax({
		url: "index.php?admin/getimage_" + type + "/" + pid,
		type: 'POST',
		success: function(data) {
			changeMe.attr('style', 'background-image:url(' + data + ');');
		}
	});
}

function save_layout()
{
	var data = new Object();
	data.title2 = $('#title2').val();
	data.id2 = $('#entry2').val();
	data.type2 = $('#type2').val();
	data.title3 = $('#title3').val();
	data.id3 = $('#entry3').val();
	data.type3 = $('#type3').val();
	data.title4 = $('#title4').val();
	data.id4 = $('#entry4').val();
	data.type4 = $('#type4').val();
	$('#alerts').html('Saving...');
	$.ajax({
		url: "index.php?admin/update_layout/",
		type: 'POST',
		data: data,
		success: function(response) {
			if( response == "ok" )
			{
				window.location = "index.php?admin/home/true/";
			}
			else 
			{
				$('#alerts').html(response);
			}
		}
	});
	return false;
}

function stripUI( string )
{
	var ns = string.substr(5);
	ns = ns.split("\"");
	return ns[0];
}

/*---------------------------------------------------------------------------------------*/
/////////////////////////////////////////////////////////////////////////////////////////
//
//    END HOME/LAYOUT FUNCTIONS
//
/////////////////////////////////////////////////////////////////////////////////////////
/*---------------------------------------------------------------------------------------*/

function delete_entry() 
{
	if( confirm ('Are you sure that you want to delete \''+ $(this).parent().find("div.edit_mid a").html() +'\'? This cannot be undone.') ) 
	{
		$.ajax({
			url: "index.php?admin/delete_entry/" +$(this).parent().attr("id") ,
			type: 'POST'
		});
		$(this).parent().slideUp('slow').hide();
	}
}

function delete_photo_album()
{
	var divToSlideUp = $(this).parent();
	if ( confirm ('Are you sure that you want to delete \''+ $(this).parent().find("div.edit_mid a").html() +'\'? This cannot be undone.') ) {
		$.ajax({
			url: "index.php?admin/delete_photo_album/" + $(this).parent().attr("id") ,
			type: 'POST',
			success: function()
			{
				divToSlideUp.slideUp('slow').hide();
			}
		});
	}
}


function delete_port_item()
{
	var divToSlideUp = $(this).parent();
	if ( confirm ('Are you sure that you want to delete \''+ $(this).parent().find("div.edit_mid a").html() +'\'? This cannot be undone.') ) {
		$.ajax({
			url: "index.php?admin/delete_port/" + $(this).parent().attr("id") ,
			type: 'POST',
			success: function()
			{
				divToSlideUp.slideUp('slow').hide();
			}
		});
	}
}

function drop_down() 
{ 
	$(this).parent().find("ul.sub_menu").slideDown('fast').show();
	$(this).parent().hover(
		function() { }, 
		function() { $(this).parent().find("ul.sub_menu").slideUp('slow'); }
	);
}

function clear_me(element)
{
	var elem = "#"+element.id;
	if( $(elem).val() == element.id ) {
		$(elem).val("");
	}
}

function make_album_cover()
{										   
	var pid = $(this).parent().parent().attr('pid');	
	var aid = $(this).parent().parent().attr('aid');
	var id 	= $(this).parent().parent().attr('id');	
	var updateView = $(this).parent().parent();
	if( confirm ('Make this picture '+  pid +' the album cover?') ) 
	{
		var current_album = $(this).parent().parent().parent().find('.album_cover');
		current_album.removeClass('album_cover');
		$.ajax({
				   
			url: "index.php?admin/make_album_cover/" + pid + "/" + aid,
			type: 'POST',
			success: function(data) {
				//$(this).parent().parent().html(data);
				updateView.addClass('album_cover');
				alert('You have successfully changed the album cover!');
			}
		});
	}										   
}
	
function move_pic_up(){
							
	var myDiv = $(this).parent().parent().attr('id');
	var swDiv = $(this).parent().parent().prev().attr('id');
	var myPid = $(this).parent().parent().attr('pid');
	var swPid = $(this).parent().parent().prev().attr('pid');
	var OurAid = $(this).parent().parent().attr('aid');
	var myHtml = $(this).parent().parent().html();
	var swHtml = $(this).parent().parent().prev().html();
	
	$('#'+myDiv).html('Switching positions. Please wait...');
	$('#'+swDiv).html('Switching positions. Please wait...');
	
	$.ajax({
				   
		url: "index.php?admin/switch_photo_order/" + myPid + "/" + swPid,
		type: 'POST',
		success: function(data) {
			
			$('#'+myDiv).slideUp('fast').hide();
			$('#'+swDiv).slideUp('fast').hide();
			
			$('#'+myDiv).html(swHtml);
			$('#'+swDiv).html(myHtml);
			
			$('#'+myDiv).attr('pid',swPid);
			$('#'+swDiv).attr('pid',myPid);
			
			if(swDiv == "1")
			{
				$('#'+myDiv+' .photo_edit_edit .delete_photo').after('<div class="move_up"></div>');
				$('#'+swDiv+' .photo_edit_edit .move_up').remove();
			} 
			
			var has_down = $('#'+swDiv+' .photo_edit_edit').find('.move_down');
			
			if( has_down.length == 0 )
			{
				$('#'+swDiv+' .photo_edit_edit .move_up').after('<div class="move_down"></div>');
				$('#'+myDiv+' .photo_edit_edit .move_down').remove();
			} 
			$('#'+myDiv).slideDown('slow').show();
			$('#'+swDiv).slideDown('slow').show();
		}
	});						
}
	
function move_pic_down()
{							
	var myDiv = $(this).parent().parent().attr('id');
	var swDiv = $(this).parent().parent().next().attr('id');
	var myPid = $(this).parent().parent().attr('pid');
	var swPid = $(this).parent().parent().next().attr('pid');
	var OurAid = $(this).parent().parent().attr('aid');
	var myHtml = $(this).parent().parent().html();
	var swHtml = $(this).parent().parent().next().html();
	
	$('#'+myDiv).html('Switching positions. Please wait...');
	$('#'+swDiv).html('Switching positions. Please wait...');
	
	$.ajax({
				   
		url: "index.php?admin/switch_photo_order/" + myPid + "/" + swPid,
		type: 'POST',
		success: function(data) {
			
			$('#'+myDiv).slideUp('fast').hide();
			$('#'+swDiv).slideUp('fast').hide();
			
			$('#'+myDiv).html(swHtml);
			$('#'+swDiv).html(myHtml);
			
			$('#'+myDiv).attr('pid',swPid);
			$('#'+swDiv).attr('pid',myPid);
			
			var has_up = $('#'+swDiv+' .photo_edit_edit').find('.move_up');
			
			if( myDiv == "1" )
			{
				$('#'+swDiv+' .photo_edit_edit .delete_photo').after('<div class="move_up"></div>');
				$('#'+myDiv+' .photo_edit_edit .move_up').remove();
			} 
			
			if( has_up.length == 0 )
			{
				$('#'+swDiv+' .photo_edit_edit .delete_photo').after('<div class="move_up"></div>');
				$('#'+myDiv+' .photo_edit_edit .move_up').remove();
			} 
			$('#'+myDiv).slideDown('slow').show();
			$('#'+swDiv).slideDown('slow').show();
		}
	});						
}

function delete_entry_photo() 
{				   
	var the_image = $(this).parent().find(".edit_image");
	var this_item = this;
	var e_id = $(this).attr('e_id');
	if ( confirm ('Are you sure that you want to delete This entry\'s photo? This cannot be undone.') ) 
	{
		$.ajax(
		{
			url: "index.php?admin/delete_entry_photo/" + e_id,
			type: 'POST',
			success: function() 
			{
				the_image.fadeOut('slow').hide();
				$('#photo_edit_button').html('Add Photo');
				$(this_item).fadeOut('slow').hide();
			}
		});
	}
}

function delete_photo() 
{								  
	var pid = $(this).parent().parent().attr('pid');	
	var aid = $(this).parent().parent().attr('aid');
	var id 	= $(this).parent().parent().attr('id');
	
	if ( confirm ('Are you sure that you want to delete this photo? This cannot be undone!') ) 
	{
		$(this).parent().parent().html('Deleting. Please wait...');
		
		$.ajax({
			url: "index.php?admin/delete_photo/" + pid,
			type: 'POST',
			success: function(data) {
				//$(this).parent().parent().html(data);
				$.ajax({url:"index.php?admin/reorder_photos/" + aid, type:'POST', success: function() { $('#'+id).slideUp('slow').hide(); }});
			}
		});
	}	
}

function submit_form(elem) 
{
	elem.submit();	
}

function get_songs(element) {
	
	if ( confirm ('getting songs.') ) {
		
		$.ajax({
			url: "index.php?admin/get_artist_songs/" +$(this).parent().attr("id") ,
			type: 'POST'
		});
	}
}

function get_artist_dropdown() 
{								  
	$('#artist_songs').html('loading catalog...');						  
	$.ajax({
		url: "index.php?admin/get_artist_songs/" +$(this).val() +"/0",
		type: 'POST',
		success: function(data) {
			$('#artist_songs').html(data);
		}
	});				 
}
