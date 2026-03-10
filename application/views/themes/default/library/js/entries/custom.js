/*$.noConflict();*/

var verify_comment = function() 
{
    var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
    var email = $('#comment_author_email').val();
    var author = $('#comment_author').val();
    var content = $('#comment_content').val();
    var errors = [];
    if( !emailRegEx.test( email ) ) errors.push( 'Not a valid email.' );
    if( author == '' ) errors.push( 'Must provide a name.' );
    if( content == '' ) errors.push( 'Must provide a comment.' );

    if( errors.length == 0 )
    {
        $('#add_comment_box').fadeOut('slow',function(){
            if( $('#submit_comment').attr('class') )
            {
                $('#comment_captcha').show();
                Recaptcha.create(
                    "6Lc6k8MSAAAAAAhzG-xt9emu3YRcE-9XxVMfdbjC",
                    "captcha_holder",
                    {
                        theme: "red",
                        callback: Recaptcha.focus_response_field
                    }
                );
            }
            else 
            {
                submit_comment();
            }
        });
    }
    else
    {
        var errstr = errors.join(' ');
        $('#feedback').html( errstr );
    }
    return false;
}

var submit_comment = function()
{
    var dataObj = {};
    dataObj.privatekey = '6Lc6k8MSAAAAAInaQC078DCVfalCR5WXBIgtTqe_';
    dataObj.remoteip = $('#remoteip').val();
    if( $('#submit_comment').attr('class') )
    {
        dataObj.challenge = Recaptcha.get_challenge();
        dataObj.response = Recaptcha.get_response();
    }
    dataObj.author = $('#comment_author').val();
    dataObj.record_id = $('#record_id').val();
    dataObj.parent_id = $('#parent_id').val();
    dataObj.email = $('#comment_author_email').val();
    dataObj.website = $('#comment_author_website').val();
    dataObj.content = $('#comment_content').val();
    $('#comment_captcha').hide();
    $.ajax({
        url: ChiBaseURL + '/entries/validate_comment',
        data: dataObj,
        async: false,
        crossDomain: true,
        type: 'POST',
        success: function( obj ){
            var response = json_parse( obj );
            if( response.success && response.comment_approval )
            {
                $('#comment_captcha').html( '<span>Comment submitted. Your comment is awaiting moderation.</span>');
            }
            else if( response.success && !response.comment_approval )
            {
                $('#comment_captcha').html( '<span>Comment submitted. Your comment is posted.</span>');
            }
            else if( !response.success )
            {
                $('#comment_captcha').html( '<span>Your comment was not posted please try again later.</span>');
            }
            
            $('#comment_captcha').fadeIn();
        }
    });
    return false;
}

var make_like = function()
{
    var like_response = $(this).parent().parent().find( '.count_like' );
    var eid = $( this ).parent().parent().parent().attr( 'eid' );
    var dataObj = {};
    dataObj.type = 'good';
    dataObj.magnitude = 1;
    $.ajax({
        url: ChiBaseURL + '/entries/karma/' + eid,
        data: dataObj,
        type: 'POST',
        success: function( obj ){
            var response = json_parse( obj );
            if( response.success == true )
            {
                like_response.html( response.message );
                like_response.fadeIn( 1000, function(){ like_response.fadeOut(); });
            }
        }
    });
}

var make_dislike = function()
{
    var like_response = $(this).parent().parent().find( '.count_like' );
    var eid = $( this ).parent().parent().parent().attr( 'eid' );
    var dataObj = {};
    dataObj.type = 'bad';
    dataObj.magnitude = 1;
    $.ajax({
        url: ChiBaseURL + '/entries/karma/' + eid,
        data: dataObj,
        type: 'POST',
        success: function( obj ){
            var response = json_parse( obj );
            if( response.success == true )
            {
                like_response.html( response.message );
                like_response.fadeIn( 1000, function(){ like_response.fadeOut(); });
            }
        }
    });
}

$(document).ready(function(){
    Cufon.replace('.entry h1', { fontFamily : 'LeagueGothic' });
    $('#submit_comment').click( verify_comment );
    $( '.like' ).click( make_like );
    $( '.dislike' ).click( make_dislike );
    $('body').delegate( '#submit_captcha', 'click', submit_comment );
});
