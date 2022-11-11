$('.update-user-status').on('change', function (){

    let status = $(this).val();
    let user_id = $(this).attr('data-user-id');

    $.ajax({
        url: "/users/"+user_id+"/update-status/"+status,
        method: "GET",
        success: function (response, status, jqXHR) {
            console.log(response);
            if(response.status == "success"){
                alertFunc('success', response.msg);
            }else{
                alertFunc('failed', response.msg);
            }
        },
        error: function (jqXHR, status, result) {
            console.log(result)
        }
    });
})

$('.update-customers-status').on('change', function (){

    let status = $(this).val();
    let user_id = $(this).attr('data-user-id');

    $.ajax({
        url: "/customers/"+user_id+"/update-status/"+status,
        method: "GET",
        success: function (response, status, jqXHR) {
            console.log(response);
            if(response.status == "success"){
                alertFunc('success', response.msg);
            }else{
                alertFunc('failed', response.msg);
            }
        },
        error: function (jqXHR, status, result) {
            console.log(result)
        }
    });
})

//Show alert
function alertFunc(color, msg) {
    var alert = $('<div class="alert alert-'+color+'"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+msg+'</div>').hide();
    var timeOut;
    //alert.prependTo('.notifications');
    //alert.fadeIn();
    alert.appendTo('.notifications');
    alert.slideDown();

    //Is autoclosing alert
    var delay = 3000;
    if(delay != undefined)
    {
        delay = parseInt(delay);
        clearTimeout(timeOut);
        timeOut = window.setTimeout(function() {
            alert.fadeOut(200, function(){ $(this).remove();});
        }, delay);
    }
    // remove last notification if more then six
    var countAlert = $(".notifications").children().length;
    if (countAlert > 3){
        $(".notifications .alert").first().remove();
    }
}


function newChatCount() {
	$.ajax({
        url: "/chats/new-messages/count",
        data: {},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "GET",
        success: function (response, status, jqXHR) {
            console.log(response);
            
			if (response.data) {
				for (let id in response.data.chats) {
					if (response.data.chats[id] > 0)
						$('.cutomerlist .new-chat-count[data-id="' + id + '"]').html(response.data.chats[id]);
				}

				if (response.data.total > 0)
				$('#new-chats-count').html(response.data.total)
			}
        },
        error: function (jqXHR, status, result) {
            console.log(result);
        }
    });
}

newChatCount()

setInterval(() => {
	newChatCount()
}, (1000 * 10)) // every 10 seconds