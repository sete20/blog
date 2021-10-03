@include('layouts.header')
    <div id="app">
        <nav class="bg-white shadow-sm navbar navbar-expand-md navbar-light">
            <div class="container">

                
            </div>
        </nav>
        
        <main class="py-4">
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>
    
    <script src="{{ asset('js/app.js') }}"defer></script>
    <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function(){
    $('.switch-tologin-modal').on('click',function(){
      $('#register-modal').modal('hide');
      $('#login-modal').modal('show');
    })
    $('.switch-toregister-modal').on('click',function(){
      $('#login-modal').modal('hide');
      $('#register-modal').modal('show');
    })
  })
</script>
