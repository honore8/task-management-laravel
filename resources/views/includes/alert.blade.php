@if (session()->has('success'))
    <div class="alert alert-success fade-message text-white text-center">
         <p>{{ session()->get('success') }}</p>
    </div><br />

    <script>
    $(function(){
        setTimeout(function() {
            $('.fade-message').slideUp();
        }, 2000);
    });
    </script>
@endif 