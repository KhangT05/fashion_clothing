(function ($) {
    "use strict";
    var DAMH = {};
    DAMH.toggleChat = () => {
        var chatContainer = $("#chatContainer");
        var chatButton = $("#chatButton");
        chatContainer.toggleClass('show');
        chatButton.toggleClass('active');
        var icon = chatButton.find('i');
        if (chatContainer.hasClass('show')) {
            icon.attr('class', 'bi bi-x-lg');
        } else {
            icon.attr('class', 'fa fa-comment');
        }
    }
    $(document).ready(() => {
        $(document).on('click', '#chatButton', '.chat-header .btn', function () {
            DAMH.toggleChat();
        })
    });
})(jQuery);
// DAMH.sendMessage = function () {
//     var input = $('#messageInput');
//     var message = input.val().trim();

//     if (message === '') return;

//     var chatBody = $('#chatBody');
//     var currentTime = new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });

//     // Tạo message mới
//     var messageDiv = $('<div class="message sent"></div>').html(`
//             <div class="avatar-sm">
//                 <i class="bi bi-person-fill"></i>
//             </div>
//             <div class="message-content">
//                 <div class="message-bubble">
//                     ${message}
//                 </div>
//                 <div class="message-time text-end">${currentTime}</div>
//             </div>
//         `);

//     chatBody.append(messageDiv);
//     input.val('');

//     // Scroll xuống cuối
//     chatBody.scrollTop(chatBody[0].scrollHeight);

//     // Giả lập phản hồi tự động
//     setTimeout(function () {
//         DAMH.autoReply();
//     }, 1000);
// };

// // Tự động trả lời (demo)
// DAMH.autoReply = function () {
//     var chatBody = $('#chatBody');
//     var currentTime = new Date().toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });

//     var replyDiv = $('<div class="message received"></div>').html(`
//             <div class="avatar-sm">
//                 <i class="bi bi-person-fill"></i>
//             </div>
//             <div class="message-content">
//                 <div class="message-bubble">
//                     Cảm ơn bạn đã nhắn tin. Chúng tôi sẽ phản hồi sớm nhất có thể!
//                 </div>
//                 <div class="message-time">${currentTime}</div>
//             </div>
//         `);

//     chatBody.append(replyDiv);
//     chatBody.scrollTop(chatBody[0].scrollHeight);
// };

// // Khởi tạo khi document ready
// $(document).ready(function () {
//     // Click button chat
//     $('#chatButton').on('click', function () {
//         DAMH.toggleChat();
//     });

//     // Click nút gửi
//     $('#chatButton').siblings('.chat-container').find('.chat-input-group button').on('click', function () {
//         DAMH.sendMessage();
//     });

//     // Enter để gửi
//     $('#messageInput').on('keypress', function (e) {
//         if (e.which === 13) {
//             DAMH.sendMessage();
//         }
//     });
// });