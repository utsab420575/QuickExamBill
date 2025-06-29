<form id="form-list-of-honorarium-coordinator"   action="{{ route('committee.input.honorarium.coordinator.store') }}" method="POST">
    @csrf
    <input type="hidden" value="{{$sid}}" name="sid">
    <div class="row mb-5">
        <div class="col-md-12">
            <section class="card card-featured card-featured-primary">
                <header class="card-header">
                    <h2 class="card-title">Honorarium for course co-ordinator (UG) (@****/-)</h2>
                </header>
                <div class="card-body">
                    <table id="table-list-of-honorarium-coordinator" class="table table-responsive-md table-striped  mb-0">
                        <thead>
                        <tr>
                            <th style="width: 70%;">Teacher Name</th>
                            <th style="width: 30%;">Honorarium Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- Member Row --}}
                        <tr>
                            @php
                                $selectedCoordinatorId = $teacher_coordinator->teacher->user->email?? null;
                                $savedForHonorariumCoordinator = $savedRateAssignHonorariumCoordinator ?? collect();
                            @endphp
                            <td>
                                <select name="coordinator_id"
                                        data-plugin-selectTwo
                                        id="coordinator_id"
                                        class="form-control  populate"  required>
                                    <option value="" disabled>-- Select Teacher --</option>
                                    @foreach($groupedTeachers as $deptFullName => $deptTeachers)

                                        <optgroup label="{{ $deptFullName }}">
                                            @foreach($deptTeachers as $teacher)
                                                @php
                                                    // Check if the coordinator is either from the API data or from the saved data in the database
                                                    $isSelected = false;

                                                    // If the coordinator is saved in the database, use the saved data
                                                    if ($savedForHonorariumCoordinator->isNotEmpty()) {
                                                        $isSelected = $savedForHonorariumCoordinator->pluck('teacher_id')->contains($teacher->id);
                                                    }
                                                    // If not, use the API data
                                                    elseif (isset($teacher->user->email, $selectedCoordinatorId) && $teacher->user->email === $selectedCoordinatorId) {
                                                        $isSelected = true;
                                                    }
                                                @endphp
                                                <option value="{{ $teacher->id }}"
                                                    {{ $isSelected ? 'selected' : '' }}>
                                                    {{ $teacher->user->name }}- {{ $teacher->designation->designation }}  - {{ $teacher->department->shortname }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="coordinator_amount" class="form-control" step="any" min="1" value="{{$honorium_coordinator??3600}}" required>
                            </td>
                        </tr>



                        </tbody>
                    </table>

                    <div class="text-end mt-3">
                        <button type="submit" id="submit-list-of-honorarium-coordinator" class="btn btn-primary">Submit Honorarium Co-oridnator</button>
                    </div>
                </div>
            </section>
        </div>
    </div>
</form>

{{--<script>
    let coordinatorData = @json($teacher_coordinator);
    console.log("Full Coordinator Data:", coordinatorData);
</script>--}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('form-list-of-honorarium-coordinator');

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
                                console.log("Server response:", data);

                                Swal.fire({
                                    title: 'Success!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });

                                const submitBtn = document.getElementById('submit-list-of-honorarium-coordinator');
                                submitBtn.textContent = 'Update Honorarium Coordinator';  // ✅ New label
                                submitBtn.classList.remove('btn-primary');
                                submitBtn.classList.add('btn-warning');

                                const cells = document.querySelectorAll('#table-list-of-honorarium-coordinator td');
                                cells.forEach(td => {
                                    td.classList.add('fade-green');
                                    setTimeout(() => td.classList.add('fade-out'), 1000);
                                    setTimeout(() => td.classList.remove('fade-green', 'fade-out'), 1900);
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

