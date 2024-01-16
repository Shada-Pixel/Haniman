<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter  selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                    <div class="flex gap-2">

                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="ml-5 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        {{-- @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif --}}
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center items-center">
                    <img src="{{asset('hp.svg')}}" alt="Hamneman Pharmacy" srcset="" class="h-24">
                    <h1 class="text-4xl font-bold font-mont text-gray-900">Hahneman <br> Phamacy</h1>
                </div>

                <div class="mt-16 p-6 flex justify-center items-center mx-auto max-w-2xl">


                    <div class=" motion-safe:hover:scale-[1.01] transition-all duration-250">
                        <div class="my-10 text-center space-y-5">
                            <h2 class="text-5xl font-bold text-red-500 ">Welcome!</h2>
                            <p>Please Scane your ID Before entering or leaving</p>
                        </div>
                            <h2 class="my-10 text-xl font-bold text-red-500 text-center min-h-18" >Scan Your ID Card</h2>
                            <h2 class="my-24 text-2xl font-bold text-green-500 text-center" id="scanNotification"></h2>
                    </div>
                </div>


                <div class="mt-2 opacity-0">
                    <div class="flex justify-center items-center mx-auto max-w-2xl p-6">
                        <form action="{{route('attendences.store')}}" method="post" id="idCardScanForm">
                            @csrf
                            <input type="text" name="emp_number" id="emp_number_input" autofocus >
                            <div class="lg:col-span-2 mt-3">
                                <button type="submit"
                                    class="font-mont mt-8 px-10 py-4 bg-black text-white font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 relative after:absolute after:content-['SURE!'] after:flex after:justify-center after:items-center after:text-white after:w-full after:h-full after:z-10 after:top-full after:left-0 after:bg-seagreen overflow-hidden hover:after:top-0 after:transition-all after:duration-300">Save</button>
                            </div> <!-- end button -->
                        </form>
                    </div>
                </div>

                <div class="flex justify-center mt-16 px-0 items-center">
                    <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                        <p>Developed by <a href="https://www.shadapixel.com/" target="_blank" rel="noopener noreferrer hover:scale-1.1" class="text-seagreen font-space text-bold">Shada Pixel</a></p>

                    </div>
                </div>
            </div>
        </div>


        <!-- Plugin Js -->
        <script src="{{asset('adminto/libs/jquery/jquery.min.js')}}"></script>
        <script>
            // Ajax csrf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var element = $('#scanNotification');

            $(document).ready(function() {

                $('#emp_number_input').change(function() {
                    // Trigger form submission when the input value changes
                    var inputValue = $(this).val();
                    if (inputValue.length >= 9) {
                        console.log(inputValue);
                        $('form#idCardScanForm').submit();
                    }
                });

                // $('#emp_number_input').on('input',function() {
                //     // Trigger form submission when the input value changes
                //     var inputValue = $(this).val();
                //     if (inputValue.length >= 9) {
                //         console.log(inputValue);
                //         $('form#idCardScanForm').submit();
                //     }
                // });

                $('form#idCardScanForm').submit(function(event) {
                    event.preventDefault(); // Prevent default form submission

                    var formData = $(this).serialize(); // Serialize form data

                    $.ajax({
                        type: 'POST',
                        url: '{{ route("attendences.store") }}', // Replace with your route name
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            // console.log(response.message); // Handle success response

                            element.text(response.message);
                            element.fadeIn();
                            $('form#idCardScanForm')[0].reset();
                            // Change inner text to 'Scan your ID' after another 3 seconds
                            setTimeout(function() {
                                element.fadeOut();
                            }, 3000);
                        },
                        error: function(xhr, status, error) {
                            // console.error(error); // Handle error
                            element.text('Something Wrong');
                            $('form#idCardScanForm')[0].reset();
                            // Change inner text to 'Scan your ID' after another 3 seconds
                            setTimeout(function() {
                                element.fadeOut();
                            }, 3000);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
