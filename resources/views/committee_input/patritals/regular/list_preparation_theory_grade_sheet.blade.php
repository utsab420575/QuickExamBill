@push('styles')
    <style>
        .card-list-of-prepares-theory-grade-sheet {
            background-color: white; /* starting point */
            transition: background-color 0.6s ease-in-out;
        }

        .card-list-of-prepares-theory-grade-sheet.fade-highlight {
            background-color: #28a745; /* strong green */
        }

        .card-list-of-prepares-theory-grade-sheet.fade-out {
            background-color: white;
        }
    </style>
@endpush
<form id="form-list-of-prepares-theory-grade-sheet" action="{{ route('committee.input.regular.theory.grade.sheet.store') }}" method="POST">
    @csrf
    <input type="hidden" id="sid" name="sid" value="{{$sid}}">
    <div class="row mb-5">
        <div class="col-md-12">
            <section class="card card-featured card-featured-primary">
                <header class="card-header">
                    <h2 class="card-title">List of Teachers for the Preparation of Grade Sheet(Theoritical (@**/- per student per subject))
                    </h2>
                </header>

                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4 mb-4">
                            <div class="form-group">
                                <label for="theory_grade_sheet_rate">Per Student Per Subject Rate</label>
                                <input type="number"  name="theory_grade_sheet_rate" value="{{$theory_grade_sheet_per_subject_rate??45}}" step="any" class="form-control" placeholder="Enter per student per subject rate" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                        </div>
                        <div class="col-md-4 mb-4">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if(isset($all_course_with_teacher->courses))
                                @foreach($all_course_with_teacher->courses as $courseData)
                                    @php
                                        $single_course = $courseData->courseObject;
                                        $course_code = $single_course->courseno;
                                        $savedForTheoryGradeSheet = $savedRateAssignTheoryGradeSheet[$course_code] ?? collect(); // Collection of RateAssigns
                                    @endphp
                                        <!-- Hidden course-level metadata -->
                                    <input type="hidden" name="courseno[{{ $single_course->id }}]" value="{{ $single_course->courseno }}">
                                    <input type="hidden" name="coursetitle[{{ $single_course->id }}]" value="{{ $single_course->coursetitle }}">
                                    <input type="hidden" name="registered_students_count[{{ $single_course->id }}]" value="{{ $courseData->registered_students_count }}">


                                    <section class="card card-featured card-featured-secondary">
                                        <header class="card-header">
                                            <h2 class="card-title">
                                                Course: {{ $single_course->courseno }} - {{ $single_course->coursetitle }}
                                            </h2>
                                        </header>

                                        <div class="card-body card-list-of-prepares-theory-grade-sheet">
                                            <div class="row mb-3">
                                                <div class="col-md-9">
                                                    <label for="prepares_theory_grade_sheet_teacher_{{ $single_course->id }}_{{ $loop->index }}">Select Scrutinizers</label>
                                                    <select name="prepares_theory_grade_sheet_teacher_ids[{{ $single_course->id }}][]"
                                                            multiple data-plugin-selectTwo
                                                            id="prepares_theory_grade_sheet_teacher_{{ $single_course->id }}_{{ $loop->index }}"
                                                            class="form-control  populate"  required>
                                                        <option value="" disabled>-- Select Teacher --</option>
                                                        @foreach($groupedTeachers as $deptFullName => $deptTeachers)
                                                            <optgroup label="{{ $deptFullName }}">
                                                                @foreach($deptTeachers as $teacher)
                                                                    <option value="{{ $teacher->id }}" {{ $savedForTheoryGradeSheet->pluck('teacher_id')->contains($teacher->id) ? 'selected' : '' }}>
                                                                        {{ $teacher->user->name }}  - {{ $teacher->department->shortname }}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>


                                                <div class="col-md-3">
                                                    @php
                                                        // Check if there is saved data, and if yes, get total_students from the first teacher's entry
                                                        $noOfItems = $savedForTheoryGradeSheet->isNotEmpty()
                                                                    ? $savedForTheoryGradeSheet->first()->total_students
                                                                    : $courseData->registered_students_count;
                                                    @endphp
                                                    <label for="prepares_theory_grade_sheet_no_of_students">Per Script Rate</label>
                                                    <input name="prepares_theory_grade_sheet_no_of_students[{{ $single_course->id }}]"
                                                           type="number" min="1" step="any"
                                                           class="form-control"
                                                           {{--value="{{ $courseData->registered_students_count }}"--}}
                                                           value="{{ old('prepares_theory_grade_sheet_no_of_students.' . $single_course->id, $noOfItems) }}"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                @endforeach
                            @endif

                            <div class="text-end mt-3">
                                <button id="submit-list-of-prepares-theory-grade-sheet" type="submit" class="btn btn-primary">
                                    Submit Theory Grade Sheet Committee
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</form>


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('form-list-of-prepares-theory-grade-sheet');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

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

                                const submitBtn = document.getElementById('submit-list-of-prepares-theory-grade-sheet');
                                submitBtn.textContent = 'Update Theory Grade Sheet Committee';  // ✅ New label
                                submitBtn.classList.remove('btn-primary');
                                submitBtn.classList.add('btn-warning');

                                const cards = document.querySelectorAll('.card-list-of-prepares-theory-grade-sheet');

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

