var config = {
    apiKey: "AIzaSyBowf1L_gcyMTitdw_JTyrk3F2YOhQ-HVs",
    authDomain: "apparkear.firebaseapp.com",
    databaseURL: "https://apparkear.firebaseio.com",
    projectId: "apparkear",
    storageBucket: "apparkear.appspot.com",
    messagingSenderId: "483483785807"
  };
  firebase.initializeApp(config);
var database = firebase.database();

var htm = "";


var chatList = firebase.database().ref('Users/' + user + '/Chatrooms');
//console.log(chatList);
chatList.orderByChild("timeStamp").on('child_added', function (snapshot) {
    //console.log(snapshot);
    var chatListing = snapshot.val();
    //console.log(chatListing.chatUser);
    var imgurl ;
    $.ajax({
        type:"post",
        url: 'ajax_setchat.php',
        data:{page:'list',chatUser:chatListing.chatUser},
        success: function(response){
            response = JSON.parse(response);
            imgurl = response.image;
            if (chatListing.isRead == 0) {
//                htm = '<li class="left clearfix allchatlist"><span class="chat-img float-left">' +
//                    '<img src="' + imgurl + '" alt="User Avatar" class="img-circle">' +
//                    '</span><div class="chat-body clearfix"><div class="header_sec"><strong class="primary-font">' + chatListing.userName + '</strong>' +
//                    '<small class="float-right">' + chatListing.time + '</small></div><div class="contact_sec"><small>' + chatListing.lastMsg + '<span class="unread_msg"></small></span>' +
//                    '</div><div class="clearfix"><a class="btn candidate-register " onclick="message(' + chatListing.chatUser + ')" style="float:right;padding: 5px 5px;font-size:12px" href="javascript:void(0)">Message</a>' +
//                    '</div> </div></li>';
                htm = '<div class="media list-img">'+
                                '<a href="javascript:void(0);" onclick="message(<?php echo $row->id; ?>)">'+
                                   ' <img class="mr-4 rounded-circle " src="'+imgurl+'" alt="Generic placeholder image">'+
                               ' </a><div class="media-body">'+
                                '<a href="javascript:void(0);" onclick="message(' + chatListing.chatUser + ')">'+
                                '<h5 class="mt-0">' + chatListing.userName + '</h5>'+
                                '<p>' + chatListing.lastMsg + '</p>'+
                                '<div class="bottom d-flex">'+
                                    '<i class="far fa-clock"></i><p>' + chatListing.time + '</p>'+
                                    '<i class="fas fa-star pl-3"></i>'+
                                    '<i class="fas fa-star"></i>'+
                                    '<i class="far fa-star"></i>'+
                                    '<i class="far fa-star"></i>'+
                                    '<i class="far fa-star"></i>'+
                                '</div></a></div></div>';
            } else {
//                htm = '<li class="left clearfix allchatlist"><span class="chat-img float-left">' +
//                    '<img src="' + imgurl + '" alt="User Avatar" class="img-circle">' +
//                    '</span><div class="chat-body clearfix"><div class="header_sec"><strong class="primary-font">' + chatListing.userName + '</strong>' +
//                    '<small class="float-right">' + chatListing.time + '</small></div><div class="contact_sec"><small>' + chatListing.lastMsg + '</small></span>' +
//                    '</div><div class="clearfix"><a class="btn candidate-register " onclick="message(' + chatListing.chatUser + ')" style="float:right;padding: 5px 5px;font-size:12px" href="javascript:void(0)">Message</a>' +
//                    '</div> </div></li>';
                htm = '<div class="media list-img">'+
                                '<a href="javascript:void(0);" onclick="message(<?php echo $row->id; ?>)">'+
                                   ' <img class="mr-4 rounded-circle" src="'+imgurl+'" alt="Generic placeholder image">'+
                               ' </a><div class="media-body">'+
                                '<a href="javascript:void(0);" onclick="message(' + chatListing.chatUser + ')">'+
                                '<h5 class="mt-0">' + chatListing.userName + '</h5>'+
                                '<p>' + chatListing.lastMsg + '</p>'+
                                '<div class="bottom d-flex">'+
                                    '<i class="far fa-clock"></i><p>' + chatListing.time + '</p>'+
                                    '<i class="fas fa-star pl-3"></i>'+
                                    '<i class="fas fa-star"></i>'+
                                    '<i class="far fa-star"></i>'+
                                    '<i class="far fa-star"></i>'+
                                    '<i class="far fa-star"></i>'+
                                '</div></a></div></div>';
            }


            // $('.allchatlist:last').before(htm);
            $('.emptychatbox').remove();
            $('#appendchatlist').append(htm);

            $("#appendchatlist").animate({
                scrollTop: $('#appendchatlist').prop("scrollHeight")
            }, 1000);
        }
    });
    

    // $('.appendchat').animate({
    //     scrollUp: $('.appendchat').prop("scrollHeight")
    // }, 500);

});


var chatDb = firebase.database().ref('Chat/' + chatroom);
//alert(chatroom);
if (chatroom != ''){
    
    chatDb.on("child_added", function (snapshot) {
        var chat = snapshot.val();

        var lastChat = firebase.database().ref('Users/' + user + '/Chatrooms/' + chatroom);
        setTimeout(function () {
            lastChat.once('value', function (snapshot) {
                console.log(snapshot.val());
                console.log(snapshot.key);
            });
            lastChat.update({
                isRead: 1,
            });
        }, 1000);
        
        var html = '';
//console.log(chat.uid+"---"+user);return false;
        if (chat.uid != user) {
//            html = '<li class="left clearfix chats"><span class="chat-img1 float-left">' +
//                '<img src="' + chatuserImage + '" alt="User Avatar" class="img-circle">' +
//                '</span><div class="chat-body1 clearfix"><p>' + chat.msg + '</p><div class="clearfix"></div>' +
//                '<div class="chat_time float-left">' + chat.time + '</div></div></li>';
            html = '<div class="media chat ml-lg-5" style="border:none;"><a href="#">' +
                '<img class="rounded-circle mr-lg-5" src="' + chatuserImage + '" alt="Generic placeholder image">' +
                '</a><div class="media-body bg">' + chat.msg + '</div></div>';
        } else {
//            html = '<li class="left clearfix admin_chat chats"><span class="chat-img1 float-right">' +
//                '<img src="' + userimage + '" alt="User Avatar" class="img-circle"></span>' +
//                '<div class="chat-body1 clearfix"><p>' + chat.msg + '</p><div class="clearfix"></div>' +
//                '<div class="chat_time float-right">' + chat.time + '</div></div></li>';
            html = '<div class="media chat mr-lg-5" style="border:none;"> '+
                          '<div class="media-body color-bg">' + chat.msg + 
                '</div><a href="#"><img class="rounded-circle float-right ml-lg-5" src="' + userimage + '" " alt="Generic placeholder image">' +
                '</a></div>';
        }
        //console.log(html)
        $('#appendchat').append(html);
        $("#appendchatscroll").animate({
            scrollTop: $('#appendchatscroll').prop("scrollHeight")
        }, 100);

        //console.log($('#appendchatscroll').prop("scrollHeight"));

    });
}

//chatUser ="";

// sendMessage();
//sendMessage(2,"hello","12:18:18",'');
function sendMessage(userId, msg, time, date) {
//console.log(userId+"---"+msg+"---"+time+"---"+date); return false;
    chatDb.push({
        uid: userId,
        msg: msg,
        time: time,
        date: date,
        timeStamp: - Date.now()
    }).then(function(response){
        //console.log(response.key); return false;
        var key = response.key;
        firebase.database().ref('Users/' + chatuser + '/Chatrooms/' + chatroom).set({
            userName: userName,
            chatId: key,
            msgSenderId: userId,
            chatUser: user,
            isRead: 0,
            lastMsg: msg,
            time: time,
            timeStamp: - Date.now()
        });

        firebase.database().ref('Users/' + user + '/Chatrooms/' + chatroom).set({
            userName: chatuserName,
            chatId: key,
            msgSenderId: userId,
            chatUser: chatuser,
            isRead: 1,
            lastMsg: msg,
            time: time,
            timeStamp: - Date.now()
        });
    });

    
}


