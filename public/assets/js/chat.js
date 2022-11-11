var timeoutCount=0;
$(function(){

    $('.chatBubble').on('click','.footerDv button',function(){

        let id = $(this).attr('data-active-id');
        var txt = $('.chatBubble .footerDv .typeDv textarea').val();

        let name = (admin_name) ? admin_name : 'admin';
        let d = new Date();
        let t = ((d.getHours() < 10) ? '0' + d.getHours() : d.getHours()) + ':';
        t += ((d.getMinutes() < 10) ? '0' + d.getMinutes() : d.getMinutes());
        let chatBody = `
        <div class="chat-msg me ">
            <div class="msg-box">
                <div class="msg">
                <strong>${name}</strong>
                <div>${urlify(txt)}</div>
                </div>
                <span class="timestamp">${d.toLocaleDateString()} ${t}</span>
            </div>
        </div>
        `;
        //$('.chatBubble .bubblesDv').append('<p class="me temp"><span>'+txt+'</span></p>');
        $('.chatBubble .bubblesDv').append(chatBody)
        $('.chatBubble .footerDv .typeDv textarea').val('');

        gotoBottom();
        sendMsgAjax(id,txt);

    });
});

window.onload=gotoBottom();
function sendMsgAjax(id,txt){
    window.timeoutCount++;

    $.ajax({
        url: "/chats",
        data: {
            "unique_id": id,
            "text": txt,
            // "_token": "{{ csrf_token() }}",
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        success: function (response, status, jqXHR) {
            console.log(response);
            if(response.status == 'success'){
                $('.chatBubble .bubblesDv p.me').removeClass('temp');
                window.timeoutCount=0;
                $('.chatBubble .noNetworkError').slideUp();
            }else{

            }
        },
        error: function (jqXHR, status, result) {
            setTimeout(function(){
                sendMsgAjax(id,txt);
            },5000);
            $('.chatBubble .noNetworkError').slideDown();
            console.log(result, window.timeoutCount);
        }
    });
}

function gotoBottom(){
    // $('.chatBubble .bubblesDv').stop().animate({scrollTop:$('.chatBubble .bubblesDv #marker').offset().top}, 500, 'swing', function() {});
    $('.chatBubble .bubblesDv').stop().animate({scrollTop: document.getElementById('chat-history').scrollHeight}, 500, 'swing', function() {});
}
function fetchLatestChat(id)
{
    $.ajax({
        url: "/chats/"+id,
        method: "GET",
        success: function (response, status, jqXHR) {
            // console.log(response);
            if(response.isFound == 1){
            //    need to update
                var allchats = response.record;
                var chatBody = '';
                let by = '';
                let name = '';
                allchats.forEach(function(item,key){
					by = (item.is_admin) ? 'me' : 'other';
					name = (item.is_admin) ? item.user.name : 'Customer';
					let d = new Date(item.created_at);
					let t = ((d.getHours() < 10) ? '0' + d.getHours() : d.getHours()) + ':';
					t += ((d.getMinutes() < 10) ? '0' + d.getMinutes() : d.getMinutes());
					chatBody += `
					<div class="chat-msg ${by} ">
						<div class="msg-box">
							<div class="msg">
							<strong>${name}</strong>
							<div>${urlify(item.text)}</div>
							</div>
							<span class="timestamp">${d.toLocaleDateString()} ${t}</span>
						</div>
					</div>
					`;

                    // if(item.is_admin){
                    //     chatBody = chatBody+'<p class="me"><span>'+item.user.name+'</span><span>'+item.text+'</span><span>'+item.created_at+'</span></p>';
                    // }else{
                    //     chatBody = chatBody+'<p><span>Customer</span><span>'+item.text+'</span><span>'+item.created_at+'</span></p>';
                    // }
                });
                chatBody=chatBody+'<span id="marker"></span>';
                $('.chatBubble .bubblesDv').html(chatBody);
                setTimeout(function(){
                    gotoBottom();
                },500);
            }
        },
        error: function (jqXHR, status, result) {}
    });
}

function urlify(text) {
	var urlRegex = /(https?:\/\/[^\s]+)/g;
	return text.replace(urlRegex, function(url) {
	  return '<a href="' + url + '" target="_blank">' + url + '</a>';
	})
	// or alternatively
	// return text.replace(urlRegex, '<a href="$1">$1</a>')
}


