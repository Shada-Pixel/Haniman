<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    {{-- Header Style --}}
    <x-slot name="headerstyle">
        {{-- Datatable css --}}
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </x-slot>
    <div class="relative">


        <div class="flex flex-col sm:flex-row gap-6">
            {{-- All present today --}}
            <div class="basis-1/2">
                <div class="card">
                    <div class="p-6">
                        <h2 class="font-bold text-lg mb-2">All Present Daily</h2>
                        <form action="" method="get" id="dailyreport">
                            <input type="date" name="targatedDay" id="targatedDay" value="{{ $targatedDate }}"
                                class="dark:text-gray-950">
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <table id="reportTable" class="display stripe text-xs sm:text-base" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th>Presence</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="mb-6">

                    <div class="card">
                        <div class="p-6">
                            <h2 class="font-bold text-lg mb-2">Employees on weekend</h2>
                            <ul class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                                @forelse ($employees as $employee)
                                    <li>{{ $employee->name . ' (' . $employee->emp_id . ')' }}</li>
                                @empty
                                    <li>No employee have weekend today</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Daily scans --}}
            <div class="basis-1/2">
                <div class="card">
                    <div class="p-6">
                        <h2 class="font-bold text-lg mb-2">Daily Scans</h2>
                        <form action="" method="get" id="dailyscanreport">
                            <input type="date" name="scanedDay" id="scanedDay" value="{{ $targatedDate }}"
                                class="dark:text-gray-950">
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="p-6">
                        <table id="scanTable" class="display stripe text-xs sm:text-base" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Scan Type</th>
                                    <th>Photo</th>
                                    <th>Scan Time</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- flex-end -->
        <!-- Modal -->
        <div id="modal" class="modal-backdrop fixed inset-0 items-center justify-center z-50 hidden bg-slate-950/60">
            <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                <div class="p-4">
                    <img id="modalImage" src="https://via.placeholder.com/400" alt="Image"
                        class="w-full h-auto rounded">
                </div>
                <div class="p-4 flex justify-end">
                    <button id="closeModal" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">
                        Close
                    </button>
                </div>
            </div>
        </div>

    </div>



    <x-slot name="script">
        <!-- Datatable script-->
        <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        {{-- <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> --}}
        <script>

            $(document).ready(function() {

                var datatablelist = null;

                $('#targatedDay').on('change', function() {
                    datatablelist.draw();
                });



                datatablelist = $('#reportTable').DataTable({
                    dom: 'Bfrtip',
                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: "{!! route('reports.present') !!}",
                        data: function(d) {
                            d.targatedDay = $('#targatedDay').val();
                        },
                        beforeSend: function() {
                            // setting a timeout
                            console.log($('#targatedDay').val());
                        },
                    },
                    pageLength: 100,
                    columns: [{
                            "render": function(data, type, full, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'emp_id',
                            name: 'emp_id'
                        },
                        {
                            data: null,
                            render: function(data) {
                                if (data.ads == 1) {
                                    var statusLabels =
                                        '<span  class="text-green-500 text-sm px-2 inline-block">Present</span>';
                                } else {
                                    var statusLabels =
                                        '<span  class="text-red-500 text-sm px-2 inline-block">Absent</span>';
                                }
                                // console.log(data);

                                return statusLabels;
                            }
                        },
                        {
                            data: null,
                            render: function(data) {
                                if (data.state == 1) {
                                    var statusLabels =
                                        '<span  class="text-green-500 text-sm px-2 inline-block">In</span>';
                                } else {
                                    var statusLabels =
                                        '<span  class="text-red-500 text-sm px-2 inline-block">Out</span>';
                                }
                                // console.log(data);

                                return statusLabels;
                            }
                        }
                    ]
                });


                var scanList = null;

                $('#scanedDay').on('change', function() {
                    scanList.draw();
                });



                scanList = $('#scanTable').DataTable({
                    dom: 'Bfrtip',
                    processing: true,
                    serverSide: true,
                    searching: true,
                    paging: false,
                    info: false,

                    ajax: {
                        url: "{!! route('reports.dailyscan') !!}",
                        data: function(d) {
                            d.targatedDay = $('#scanedDay').val();
                        },
                        beforeSend: function() {
                            // setting a timeout
                            console.log($('#scanedDay').val());
                        },
                    },
                    pageLength: 100,
                    columns: [{
                            "render": function(data, type, full, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: null,
                            render: function(data) {
                                return data.employee.name;
                            }
                        },
                        {
                            data: null,
                            render: function(data) {
                                if (data.scan_type == 1) {
                                    var statusLabels =
                                        '<span  class="text-green-500 text-sm px-2 inline-block">In</span>';
                                } else {
                                    var statusLabels =
                                        '<span  class="text-red-500 text-sm px-2 inline-block">Out</span>';
                                }
                                // console.log(data);

                                return statusLabels;
                            }
                        },
                        {
                            data: null,
                            render: function(data) {
                                // var statusLabels = `<img  src="${BASE_URL}storage/66fffd4566ba3.png"/>`;

                                if (data.capture) {
                                    var statusLabels =
                                        `<img  src="${BASE_URL}storage/capture${data.capture.image}" class="w-10 openModal cursor-pointer" onClick="openModal('${BASE_URL+'storage/capture'+data.capture.image}');"/>`;
                                } else {
                                    var statusLabels =
                                        '<p class="text-red-500 text-sm px-2 inline-block">No Image</p>';
                                }

                                return statusLabels;
                            }
                        },
                        {
                            data: null,
                            render: function(data) {
                                let dateTimeString = data.scan_time;
                                let timeOnly = dateTimeString.split(' ')[1];
                                let [hours, minutes, seconds] = timeOnly.split(':');
                                let period = hours >= 12 ? 'PM' : 'AM';
                                hours = hours % 12 || 12; // Convert '0' hours to '12' for 12 AM
                                let timeIn12HourFormat = `${hours}:${minutes} ${period}`;
                                return timeIn12HourFormat;
                            }
                        },
                    ]
                });

            });


            // Open modal
            var openModal = function(link){
                $("#modalImage").attr('src', link);
                $("#modal").removeClass("hidden").addClass("flex");
            }


            // Close modal
            $("#closeModal, #modal").click(function(event) {
                if (event.target.id === "closeModal" || event.target.id === "modal") {
                    $("#modal").removeClass("flex").addClass("hidden");
                }
            });
        </script>
    </x-slot>
</x-app-layout>
