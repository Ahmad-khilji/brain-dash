@extends('admin.layouts.app')
@section('title')
    Admin Dashboard | Brain Dash
@endsection
@section('content')
    <div class="pagetitle d-flex justify-content-between ">

        @if (session('error'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Error!",
                        html: "{!! nl2br(html_entity_decode(session('error'))) !!}",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                });
            </script>
        @endif

        @if (session('success'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "Success!",
                        text: "{!! html_entity_decode(session('success')) !!}",
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                });
            </script>
        @endif



    </div>

    <!-- create new category modal -->
    {{-- <div class="modal fade" id="createNewCategory" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleCreate">Create Three Letter Word</h5>
                    <h5 style="display: none;" class="modal-title" id="modalTitleupdate">Edit Three Letter Word</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Vertical Form -->
                    <form class="row g-3">

                        <div class="col-6">
                            <label for="letter" class="form-label">Word</label>
                            <input type="text" class="form-control" id="letter">
                        </div>
                        <div class="col-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" placeholder="YYYY-MM-DD">
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="theme" name="theme" aria-label="Category">
                                    <option value="">Select Theme</option>
                                    @foreach ($themes as $theme)
                                        <option value="{{ $theme->id }}">{{ $theme->theme_name }}</option>
                                    @endforeach
                                </select>
                                <label for="theme" class="form-label">Theme</label>
                            </div>
                        </div>

                    </form>
                    <!-- Vertical Form -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="savethreeWord()" id="saveCategoryLoader">Save
                        Three Letter Word</button>
                    <button style="display: none;" type="button" class="btn btn-primary" onclick="updatethreeWord()"
                        id="updateCategoryLoader">Update Three Letter Word</button>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- create new category modal -->

    <div class="modal fade" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Faqs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Vertical Form -->
                    <form class="row g-3">

                        <div class="col-6">
                            <label for="question_edit" class="form-label">Question</label>
                            <input type="text" class="form-control" id="question_edit">
                        </div>

                        <div class="col-6">
                            <label for="option_a_edit" class="form-label">Option A</label>
                            <input type="text" class="form-control" id="option_a_edit">
                        </div>
                        <div class="col-6">
                            <label for="option_b_edit" class="form-label">Option B</label>
                            <input type="text" class="form-control" id="option_b_edit">
                        </div>
                        <div class="col-6">
                            <label for="option_c_edit" class="form-label">Option C</label>
                            <input type="text" class="form-control" id="option_c_edit">
                        </div>
                        <div class="col-6">
                            <label for="option_d_edit" class="form-label">Option D</label>
                            <input type="text" class="form-control" id="option_d_edit">
                        </div>

                    </form><!-- Vertical Form -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateFaqs()" id="updateCategoryLoader">Update
                        Faqs</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteCategory" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete Faqs</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="category_del_title"></p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" onclick="deleteFaqs()"
                        id="deleteCategoryLoader">Yes</button>
                </div>
            </div>
        </div>
    </div>






    <!-- Delete Confirmation Modal -->
    {{-- <div class="modal fade" id="deleteThemeModal" tabindex="-1" aria-labelledby="deleteThemeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteThemeModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete all themes? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="deleteAllCategoryLoader"
                        onclick="deleteAllThree()">Delete</button>
                </div>
            </div>
        </div>
    </div> --}}


    {{-- <div class="modal fade" id="deleteThreeWordModal" tabindex="-1" aria-labelledby="deleteThreeWordLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteThreeWordLabel">Delete Three Letter Words</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Select words you want to delete:</p>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="selectAllWords"
                            onclick="toggleSelectAll(this)">
                        <label class="form-check-label" for="selectAllWords">Select All</label>
                    </div>
                    <div id="threeWordList"></div> <!-- Words dynamically load here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="deleteSelectedThreeWords()">Delete
                        Selected</button>
                </div>
            </div>
        </div>
    </div> --}}

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                            <div class="class pagetitle">
                                <h1>Question / MCQS</h1>
                            </div>

                            <form id="uploadForm" class="d-flex justify-content-end"
                                action="{{ route('super_admin.faqs.import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div>
                                    {{-- <button onclick="openDeleteThreeModal()" type="button" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button> --}}

                                    <button type="button" class="btn btn-success" id="importCsvBtn"
                                        style="width: 150px;height: 38px;">Import
                                        CSV</button>
                                    <input class="form-control d-none" id="formFile" type="file" name="file"
                                        accept=".csv" required>
                            </form>


                            {{-- <button data-bs-toggle="modal" data-bs-target="#createNewCategory" type="button"
                                name="button" class="btn btn-primary">Create Three Letter Word</button> --}}

                        </div>
                    </div>

                    <!-- Date Filter -->
                    {{-- <div class="row mb-3">
                        <div class="col-md-5">
                            <input type="date" id="start_date" class="form-control" placeholder="Start Date">
                        </div>
                        <div class="col-md-5">
                            <input type="date" id="end_date" class="form-control" placeholder="End Date">
                        </div>
                        <div class="col-md-2">
                            <button id="filter" class="btn btn-primary">Filter</button>
                            <button id="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </div> --}}

                    <!-- Table with stripped rows -->
                    <table id="category-table" class="table">
                        <thead>
                            <tr>

                                <th>Question</th>
                                <th>Option One</th>
                                <th>Option Two</th>
                                <th>Option Three</th>
                                <th>Option Four</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated by DataTables -->
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById("importCsvBtn").addEventListener("click", function() {
            Swal.fire({
                title: "Upload CSV File",
                html: `
                <img src="{{ asset('admin/assets/img/questionimg.png') }}" alt="Upload Image" class="mb-3 w-100 object-fit-cover">
                <input type="file" id="popupFileInput" class="form-control mb-2" accept=".csv">
                <span id="popupFileName"></span>
            `,
                showCancelButton: true,
                confirmButtonText: "Upload",
                cancelButtonText: "Cancel",
                didOpen: () => {
                    const fileInput = document.getElementById("popupFileInput");
                    fileInput.addEventListener("change", function() {
                        document.getElementById("popupFileName").innerText = "Selected: " +
                            fileInput.files[0].name;
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const fileInput = document.getElementById("popupFileInput");
                    if (fileInput.files.length > 0) {
                        document.getElementById("formFile").files = fileInput.files;
                        document.getElementById("uploadForm").submit();
                    } else {
                        Swal.fire("No File Selected", "Please choose a file to upload.", "warning");
                    }
                }
            });
        });
    </script>
    <script>
        let table;
        $(document).ready(function() {
            table = $('#category-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('super_admin.faqs.index') }}',
                    type: 'GET',
                },
                pageLength: 50, // Default number of rows to show
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ], // Dropdown options
                columns: [{
                        data: 'question',
                        name: 'question',
                        orderable: false
                    },
                    {
                        data: 'option_a',
                        name: 'option_one',
                        orderable: false
                    },
                    {
                        data: 'option_b',
                        name: 'option_two',
                        orderable: false
                    },
                    {
                        data: 'option_c',
                        name: 'option_three',
                        orderable: false
                    },
                    {
                        data: 'option_d',
                        name: 'option_four',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: "text-center"
                    }
                ]
            });


        });
    </script>

    <script>
        function editModal(id, question, option_a, option_b, option_c, option_d) {
            $('#updateCategoryLoader').attr('data-id', id);
            $('#question_edit').val(question);
            $('#option_a_edit').val(option_a);
            $('#option_b_edit').val(option_b);
            $('#option_c_edit').val(option_c);
            $('#option_d_edit').val(option_d);
            $('#editCategoryModal').modal('show');
        }

        function updateFaqs() {
            // Get form data
            $('#updateCategoryLoader').addClass('loading');
            const question = $('#question_edit').val();
            const option_a = $('#option_a_edit').val();
            const option_b = $('#option_b_edit').val();
            const option_c = $('#option_c_edit').val();
            const option_d = $('#option_d_edit').val();


            // Prepare FormData
            let formData = new FormData();
            formData.append('question', question);
            formData.append('option_a', option_a);
            formData.append('option_b', option_b);
            formData.append('option_c', option_c);
            formData.append('option_d', option_d);
            let id = $('#updateCategoryLoader').attr("data-id");
            let routeTemplate = "{{ route('super_admin.faqs.update', ['id' => ':id']) }}";
            let url = routeTemplate.replace(':id', id);
            // AJAX Request
            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                contentType: false, // Required for FormData
                processData: false, // Prevent jQuery from processing the data
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#updateCategoryLoader').removeClass('loading');
                    if (response.status) {
                        // Success response
                        $('#editCategoryModal').modal('hide'); // Hide modal
                        toastifySuccess(response.message); // Display success message
                        table.draw(); // Reload data table
                    } else {
                        toastifyError(response.message || 'Something went wrong.');
                    }
                },
                error: function(request) {
                    $('#updateCategoryLoader').removeClass('loading');
                    let errorResponse = JSON.parse(request.responseText);

                    if (errorResponse.errors == null) {
                        toastifyError(errorResponse.message);
                    } else {
                        let error_list = '<ul>';
                        $.each(errorResponse.errors, function(field_name, error) {
                            error_list += '<li>' + error + '</li>';
                        });
                        error_list += '</ul>';
                        toastifyError(error_list);
                    }
                },
            });
        }



        function deleteModal(id, question) {
            $('#deleteCategoryLoader').attr('data-id', id);
            $('#category_del_title').text('Are You Sure you want to delete this Faqs?');
            $('#deleteCategory').modal('show');
        }

        function deleteFaqs() {
            $('#deleteCategoryLoader').addClass('loading');
            let dataId = $('#deleteCategoryLoader').attr("data-id");
            let url = "{{ route('super_admin.faqs.delete') }}";
            $.ajax({
                type: "post",
                url: url,
                data: {
                    id: dataId
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#deleteCategoryLoader').removeClass('loading');
                    console.log(response);
                    if (response.status == true) {
                        // todo toastr
                        toastifySuccess(response.message);
                        $('#deleteCategory').modal('hide');
                        table.draw();
                    }
                },
                error: function(request) {
                    $('#deleteCategoryLoader').removeClass('loading');
                    let errorResponse = JSON.parse(request.responseText);

                    if (errorResponse.errors == null) {
                        toastifyError(errorResponse.message);
                    } else {
                        let error_list = '<ul>';
                        $.each(errorResponse.errors, function(field_name, error) {
                            error_list += '<li>' + error + '</li>';
                        });
                        error_list += '</ul>';
                        toastifyError(error_list);
                    }
                },
            });



        }
    </script>
@endsection
