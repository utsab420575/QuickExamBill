@push('styles')
    <style>
        .card-list-of-verified-computerized-result {
            background-color: white; /* starting point */
            transition: background-color 0.6s ease-in-out;
        }

        .card-list-of-verified-computerized-result.fade-highlight {
            background-color: #28a745; /* strong green */
        }

        .card-list-of-verified-computerized-result.fade-out {
            background-color: white;
        }

        select.is-invalid {
            border-color: red;
        }
    </style>
@endpush
<form id="form-list-of-verified-computerized-result" action="{{ route('committee.input.verified.computerized.grade.sheet.store') }}" method="POST">
    @csrf
    <input type="hidden" id="sid" name="sid" value="{{$sid}}">
    <div class="row mb-5">
        <div class="col-md-12">
            <section class="card card-featured card-featured-primary ">
                <header class="card-header">
                    <h2 class="card-title">List of Teachers Verified Computerized Grade Sheets & GPA List (@**/- per student)</h2>
                </header>

                <div class="card-body card-list-of-verified-computerized-result" >
                    <div class="row mb-2">
                        <div class="col-md-4 mb-4">
                            <div class="form-group">
                                <label for="verified_computerized_grade_sheet_rate">Per Student Rate</label>
                                <input type="number"  name="verified_computerized_grade_sheet_rate" value="24" step="any" class="form-control" placeholder="Enter per student rate" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                        </div>
                        <div class="col-md-4 mb-4">
                        </div>
                    </div>

                    <div class="form-group row pb-3">

                        <div class="col-md-9">
                            <label for="verified_computerized_result_teachers">Select Scrutinizers</label>
                            <select name="verified_computerized_result_teachers[]"
                                    multiple data-plugin-selectTwo
                                    id="verified_computerized_result_teachers"
                                    class="form-control  populate"  required>
                                <option value="" disabled>-- Select Teacher --</option>
                                @foreach($groupedTeachers as $deptFullName => $deptTeachers)
                                    <optgroup label="{{ $deptFullName }}">
                                        @foreach($deptTeachers as $teacher)
                                            <option value="{{ $teacher->id }}">
                                                {{ $teacher->user->name }}  - {{ $teacher->department->shortname }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        {{-- Total Students --}}
                        <div class="col-md-3">
                            <label for="verified_computerized_result_total_students">Total Students</label>
                            <input type="number"
                                   name="verified_computerized_result_total_students"
                                   min="1"
                                   steps="any"
                                   value="{{$totalStudentInSession}}"
                                   class="form-control"
                                   required>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button id="submit-list-of-verified-computerized-result" type="submit" class="btn btn-primary">
                            Submit Verified Computerized Grade Sheet Committee
                        </button>
                    </div>
                </div>


            </section>


        </div>
    </div>
</form>



@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('form-list-of-verified-computerized-result');

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                // ✅ Validate teacher selections(we're done it by using required)
               /* const teacherSelects = form.querySelectorAll('select[name^="teachers"]');
                let allSelected = true;

                teacherSelects.forEach(select => {
                    if (select.selectedOptions.length === 0) {
                        allSelected = false;
                        select.classList.add('is-invalid'); // red border if invalid
                    } else {
                        select.classList.remove('is-invalid');
                    }
                });

                if (!allSelected) {
                    Swal.fire({
                        title: 'Missing Teacher',
                        text: 'Please select at least one teacher for each course.',
                        icon: 'warning'
                    });
                    return; // ❌ stop form submission
                }*/
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to save the committee data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, save it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData(form);

                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: formData
                        })
                            .then(response => {
                                if (!response.ok) {
                                    // Return the error JSON and throw it
                                    return response.json().then(err => {
                                        throw new Error(err.message || 'Unknown error occurred.');
                                    });
                                }
                                return response.json(); // if response is OK
                            })
                            .then(data => {
                                console.log("Server response:", data); // Debug log
                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });

                                const submitBtn = document.getElementById('submit-list-of-verified-computerized-result');
                                submitBtn.textContent = 'Already Saved';             // ✅ Change text
                                submitBtn.disabled = true;                           // ✅ Disable button
                                submitBtn.classList.remove('btn-primary');           // ✅ Remove old style
                                submitBtn.classList.add('btn-success');              // ✅ Add success style

                                const cards = document.querySelectorAll('.card-list-of-verified-computerized-result');

                                cards.forEach(card => {
                                    card.classList.add('fade-highlight');

                                    setTimeout(() => {
                                        card.classList.add('fade-out');
                                    }, 1000);

                                    setTimeout(() => {
                                        card.classList.remove('fade-highlight', 'fade-out');
                                    }, 1900);
                                });


                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: error.message||'Something went wrong. Please try again.',
                                    icon: 'error'
                                });
                            });
                    }
                });
            });
        });
    </script>
@endpush

