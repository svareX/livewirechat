<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="chat_container bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200">

        <div class="chat_list_container">

            @livewire('chat.chat-list')
        </div>

        <div class="chat_box_container">

            @livewire('chat.chatbox')

            @livewire('chat.send-message')
        </div>

    </div>

    <script>
        window.addEventListener('chatSelected', event => {
            if (window.innerWidth < 768) {
                $('.chat_list_container').hide();
                $('.chat_box_container').show();
            }
            $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);
            let height = $('.chatbox_body')[0].scrollHeight;
            window.livewire.emit('updateHeight', {
                height: height,
            });
        });
        $(window).resize(function() {
            if (window.innerWidth > 768) {
                $('.chat_list_container').show();
                $('.chat_box_container').show();
            }
        });
        $(document).on('click', '.return', function() {
            $('.chat_list_container').show();
            $('.chat_box_container').hide();
        });
    </script>

    <script>
        $(document).on('scroll', '#chatBody', function() {
            alert('aasd');

            var top = $('.chatbox_body').scrollTop();
            if (top == 0) {

                window.livewire.emit('loadmore');
            }


        });
    </script>

</div>
