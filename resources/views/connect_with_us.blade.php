<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gaam Raam</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('front/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />



</head>

<body class="antialiased">
<header>
         <nav class="navbar navbar-expand-lg">
             <div class="container">
                 <a class="navbar-brand" href="{{url('/')}}">
                     <img src="{{asset('front/images/Gaam_Raam_logo.png')}}" alt="">
                 </a>
                 <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                 </button>
                 <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav m-auto mb-2 mb-lg-0 mt-0">
                         <li class="nav-item">
                             <a class="nav-link active" aria-current="page" href="{{url('/')}}">Home</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" aria-current="page" href="#">About Us</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" aria-current="page" href="#">Testimonial</a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" aria-current="page" href="{{url('contact')}}">Contact Us</a>
                         </li>
                     </ul>
                     <div class="side_content">
                        <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                        <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                        <a href="{{url('connect_with_us')}}" class="custom_btn btn">Connect me</a>
                     </div>
                 </div>
             </div>
         </nav>
     </header>
    <div class="main">
        <section class="get_a_form">
            <div class="container">
                <h1>Connect With Us</h1>
                <div class="connect_form">
                    <form action="{{ route('contact-us') }}" method="POST" >
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" name="name" aria-describedby="nam">
                                </div>
                            </div>
                         
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" class="form-control" name="mobile" aria-describedby="phone_number">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email_address">Email Address</label>
                                    <input type="text" class="form-control" name="email" aria-describedby="email_address">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="phone_number">State</label><span class="text-danger" >*</span>
                                    <select class="form-control select2" name="state" id="state" style="">
                                        <option selected disabled  >--Select State--</option>
                                        @php $states = \App\Models\State::all(); @endphp
                                        @if($states->isNotEmpty())
                                            @foreach($states as $state)
                                            <option class="form-control" value="{{ $state->id }}"  >{{ $state->name ?? '' }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="email_address">City</label><span class="text-danger" >*</span>
                                    <select name="city" id="city" class="form-control select2" required>
                                        <option selected disabled>--Select City--</option>
                                    </select>   
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="email_address">Course</label><span class="text-danger" >*</span>
                                    <select name="course" id="course" class="form-control select2" required>
                                        <option selected disabled>--Select Course--</option>
                                        <option value="SSC" >SSC</option>
                                        <option value="UPSC" >UPSC</option>

                                    </select>   
                                </div>
                            </div>
                          
                            <button class="custom_btn btn mx-2">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    @if (Session::has('success') || Session::has('error') || $errors->any())
    <script>
        @if (Session::has('success'))
            var messageType = 'success';
            var messageColor = 'blue';
            var message = "{{ Session::get('success') }}";
        @elseif (Session::has('error'))
            var messageType = 'warning';
            var messageColor = 'orange';
            var message = "{{ Session::get('error') }}";
        @elseif ($errors->any())
            var messageType = 'error';
            var messageColor = 'red';
            var message = @json($errors->all());
        @endif
    
        if (Array.isArray(message)) {
            message.forEach(function (msg) {
                iziToast[messageType]({
                    message: msg,
                    position: 'topRight',
                    timeout: 4000,
                    displayMode: 0,
                    color: messageColor,
                    theme: 'light',
                    messageColor: 'black',
                });
            });
        } else {
            iziToast[messageType]({
                message: message,
                position: 'topRight',
                timeout: 4000,
                displayMode: 0,
                color: messageColor,
                theme: 'light',
                messageColor: 'black',
            });
        }
    </script>
    @endif
    <script>
        $(document).ready(function() {
        $('.select2').select2({
            allowClear: true
        });
    });
    </script>

    <script>
         $("#state").on('change', function(){
            var stateId = $(this).val();
            console.log(stateId);

            $.ajax({
                url: "{{ url('get-city') }}/"+stateId,
                method : "GET",

                success:function(response){
                    if(response){
                        var dataString = JSON.stringify(response);
                        console.log(dataString);

                        var cityDropdown = $('select[name="city"]');
                        cityDropdown.empty();
                        cityDropdown.append('<option selected disabled>--Select City--</option>');

                        $.each(response, function(index, city) {
                            cityDropdown.append('<option value="' + city.id + '">' + city.name + '</option>');
                        });

                    }else{
                        console.error("Empty response received.");
                        alert("Empty response received.");
                    }


                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', error);
                }

            });
        });
    </script>
        
</body>

</html>