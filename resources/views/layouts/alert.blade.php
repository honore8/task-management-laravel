@if (session()->has('success'))

    <div class="alert alert-success fade-message">
         <p>{{ session()->get('success') }}</p>
    </div><br />

    <script>
    $(function(){
        setTimeout(function() {
            $('.fade-message').slideUp();
        }, 5000);
    });
    </script>
@endif 