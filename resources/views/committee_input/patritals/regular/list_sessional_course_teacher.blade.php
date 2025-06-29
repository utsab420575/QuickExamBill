<form id="form-list-of-sessional-course-teacher"
      action="{{ route('committee.input.regular.sessional.course.teacher.store') }}" method="POST">
    @csrf
    <input type="hidden" id="sid" name="sid" value="{{$sid}}">
    <div class="row mb-5">
        <div class="col-md-12">
            <section class="card card-featured card-featured-primary">
                <header class="card-header">
                    <h2 class="card-title">Sessional (@ ***/- per contact hour per week; min ****/- per examiner)
                    </h2>
                </header>

                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4 mb-4">
                            <div class="form-group">
                                <label for="sessional_per_hour_rate">Per Contact Hour Rate</label>
                                <input type="number" name="sessional_per_hour_rate" step="any" value="{{$sessional_per_contact_hour_rate??115}}"
                                       class="form-control" placeholder="Enter per contact hour rate" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="form-group">
                                <label for="class_test_rate">Minimum Examineer Rate</label>
                                <input type="number" name="sessional_examiner_min_rate" value="{{$sessional_min_exam_rate??1500}}" step="any"
                                       class="form-control" placeholder="Enter minimum examiner rate" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="total_week">Total Weeks in semester</label>
                                <input type="number"
                                       id="total_week"
                                       name="total_week"
                                       step="any"
                                       class="form-control"
                                       placeholder="Enter Total Weeks"
                                       value="{{$sessional_total_week_semester_rate??14}}"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if(isset($all_sessional_course_with_teacher->courses))
                                @foreach($all_sessional_course_with_teacher->courses as $courseData)
                                    @php
                                        $single_course = $courseData->courseObject;
                                        $course_code = $single_course->courseno;
					                    $savedForSessionalCourseTeacher = $savedRateAssignSessionalCourseTeacher[$course_code] ?? collect(); // Collection of RateAssigns
                                        //dump($savedForSessionalCourseTeacher);
                                    @endphp

                                        <!-- Hidden course-level metadata -->
                                    <input type="hidden" name="courseno[{{ $single_course->id }}]"
                                           value="{{ $single_course->courseno }}">
                                    <input type="hidden" name="coursetitle[{{ $single_course->id }}]"
                                           value="{{ $single_course->coursetitle }}">
                                    {{--<input type="hidden" name="registered_students_count[{{ $single_course->id }}]" value="{{ $courseData->registered_students_count }}">--}}
                                    <input type="hidden" name="teacher_count[{{ $single_course->id }}]"
                                           value="{{ count($single_course->teachers) }}">

                                    <section class="card card-featured card-featured-secondary">
                                        <header class="card-header">
                                            <h2 class="card-title">
                                                Course: {{ $single_course->courseno }}
                                                - {{ $single_course->coursetitle }}
                                            </h2>
                                        </header>

                                        <div class="card-body">
                                            <table
                                                class="table-list-of-sessional-course-teacher table table-responsive-md table-striped mb-0">
                                                <thead>
                                                <tr>
                                                    <th style="width: 80%;">Name</th>
                                                    <th style="width: 20%;">Contact Hour/Week</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if($courseData->teacher_count == 0)

                                                    <tr>
                                                        <td>
                                                            <label>Select Teachers:</label>
                                                            <select
                                                                name="sessional_course_teacher_ids[{{ $single_course->id }}][]"
                                                                multiple data-plugin-selectTwo
                                                                id="sessional_course_teacher_{{ $single_course->id }}_{{ $loop->index }}"
                                                                class="form-control populate" required>
                                                                <option value="" disabled>-- Select Teacher --</option>
                                                                @foreach($groupedTeachers as $deptFullName => $deptTeachers)
                                                                    <optgroup label="{{ $deptFullName }}">
                                                                        @foreach($deptTeachers as $teacher)
                                                                            <option
                                                                                value="{{ $teacher->id }}" {{ $savedForSessionalCourseTeacher->pluck('teacher_id')->contains($teacher->id) ? 'selected' : '' }}>
                                                                                {{ $teacher->user->name }}
                                                                                - {{ $teacher->department->shortname }}
                                                                            </option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <label></label>
                                                            @php
                                                                // Check if there is saved data, and if yes, get total_students from the first teacher's entry
                                                                $noOfItems = $savedForSessionalCourseTeacher->isNotEmpty()
                                                                            ? $savedForSessionalCourseTeacher->first()->no_of_items
                                                                            : ($single_course->credithour ? $single_course->credithour * 2 : '');
                                                            @endphp
                                                            <input name="no_of_contact_hour[{{ $single_course->id }}]"
                                                                   type="number" min="1" step="any" class="form-control"
                                                                  {{-- value="{{ $single_course->credithour ? $single_course->credithour * 2 : '' }}"--}}
                                                                      value="{{old('no_of_contact_hour.'.$single_course->id, $noOfItems)}}"
                                                                   required>
                                                        </td>
                                                    </tr>
                                                @else
                                                    @foreach($single_course->teachers as  $index=>$assignedTeacher)
                                                        <tr>
                                                            <td>
                                                                <select
                                                                    name="sessional_course_teacher_ids[{{ $single_course->id }}][]"
                                                                    data-plugin-selectTwo
                                                                    class="form-control populate" required>
                                                                    <option value="">-- Select Teacher --</option>
                                                                    @foreach($teachers as $teacherOption)
                                                                        @php
                                                                           if ($savedForSessionalCourseTeacher->isNotEmpty()) {
                                                                                       // Match saved teacher at current index
                                                                                        // Use teacher from DB at this index
                                                                                       $savedTeacher = $savedForSessionalCourseTeacher->values()[$index]->teacher_id ?? null;
                                                                                       $isSelected = (int) $teacherOption->id === (int) $savedTeacher;
                                                                           } else {
                                                                               // Fallback: match by email if no DB saved data
                                                                               // Match by email between API teacher and  local DB teacher
                                                                               $isSelected = isset($assignedTeacher->user->email, $teacherOption->user->email) &&
                                                                                             $assignedTeacher->user->email === $teacherOption->user->email;
                                                                           }
                                                                        @endphp

                                                                        <option value="{{ $teacherOption->id }}"
                                                                            {{ $isSelected ? 'selected' : '' }}>
                                                                            {{ $teacherOption->user->name }}
                                                                            - {{ $teacherOption->designation->designation }}
                                                                            - {{ $teacherOption->department->shortname }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                @php
                                                                    // Get saved data for the teacher using the index
                                                                     $savedTeacher = $savedForSessionalCourseTeacher->values()[$index] ?? null;

                                                                     // If saved data is found, use no_of_items, otherwise fallback to course's credit hours * 2
                                                                     $noOfItems = $savedTeacher ? $savedTeacher->no_of_items : ($single_course->credithour ? $single_course->credithour * 2 : '');
                                                                @endphp
                                                                <input
                                                                    name="no_of_contact_hour[{{ $single_course->id }}][]"
                                                                    type="number" min="1" step="any"
                                                                    class="form-control"
                                                                   {{-- value="{{ $savedNoOfItems??$single_course->credithour ? $single_course->credithour * 2:''}}"--}}
                                                                    value="{{ old('no_of_contact_hour.'.$single_course->id, $noOfItems) }}"
                                                                    required>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </section>
                                @endforeach
                            @endif

                            <div class="text-end mt-3">
                                <button id="submit-list-of-sessional-course-teacher" type="submit"
                                        class="btn btn-primary">
                                    Submit Sessional Examiner
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
            const form = document.getElementById('form-list-of-sessional-course-teacher');

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

                                const submitBtn = document.getElementById('submit-list-of-sessional-course-teacher');
                                submitBtn.textContent = 'Update Sessional Examiner';  // ✅ New label
                                submitBtn.classList.remove('btn-primary');
                                submitBtn.classList.add('btn-warning');

                                const cells = document.querySelectorAll('.table-list-of-sessional-course-teacher td');

                                cells.forEach(td => {
                                    td.classList.add('fade-green');

                                    // Start fade out after short delay
                                    setTimeout(() => {
                                        td.classList.add('fade-out');
                                    }, 1000);

                                    // Remove classes to reset
                                    setTimeout(() => {
                                        td.classList.remove('fade-green', 'fade-out');
                                    }, 1900);
                                });


                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: error.message || 'Something went wrong. Please try again.',
                                    icon: 'error'
                                });
                            });
                    }
                });
            });
        });
    </script>
@endpush

