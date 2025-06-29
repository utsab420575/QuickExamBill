@push('styles')
    <style>
        .card-list-of-comparison-question-paper {
            background-color: white;
            transition: background-color 0.6s ease-in-out;
        }

        .card-list-of-comparison-question-paper.fade-highlight {
            background-color: #28a745;
        }

        .card-list-of-comparison-question-paper.fade-out {
            background-color: white;
        }

        select.is-invalid, input.is-invalid {
            border-color: red;
        }
    </style>
@endpush

<form id="form-list-of-comparison-question-paper" action="{{ route('committee.input.review.comparison.committee.store') }}" method="POST">
    @csrf
    <input type="hidden" value="{{$sid}}" name="sid">
    <div class="row mb-5">
        <div class="col-md-12">
            <section class="card card-featured card-featured-primary">
                <header class="card-header">
                    <h2 class="card-title">List of Comparison,Correction,sketching and distribution  of Question paper (@ ****/- per stencil)</h2>
                </header>

                <div class="card-body card-list-of-comparison-question-paper">
                    <div class="row mb-2">
                        <div class="col-md-4 mb-4">
                            <div class="form-group">
                                <label for="comparison_question_paper_rate">Per Question Rate</label>
                                <input type="number"  name="comparison_question_paper_rate" id="comparison-question-paper-rate" value="{{$comparison_rate??1350}}" step="any" class="form-control" placeholder="Enter per question rate" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                        </div>
                        <div class="col-md-4 mb-4">
                        </div>
                    </div>

                    <div class="row mb-2 fw-bold mt-2">
                        <div class="col-md-8 text-start">Select Teacher</div>
                        <div class="col-md-3 text-start" style="margin-left:-15px;">No of Question</div>
                    </div>

                    {{--here will be add row--}}
                    <div id="dynamic-comparison-question-paper-container"></div>

                    <div class="mt-3 text-end">
                        <button type="button" id="add-comparison-question-paper-row" class="btn btn-sm btn-success me-2">+ Add Teacher</button>
                    </div>

                    <div class="text-end mt-3">
                        <button id="submit-list-of-comparison-question-paper" type="submit" class="btn btn-primary">
                            Submit Comparison,Correction Committee
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        let comparisonQuestionRowCount = 0;
        const comparisonQuestionStaffTeachers = @json($teachers);
        const savedComparisonCommitteeAssign = @json($savedRateAssignComparisonCommittee);

        function createComparisonCommitteeRow(teacherId = '', amount = '') {
            comparisonQuestionRowCount++;

            const container = document.getElementById('dynamic-comparison-question-paper-container');
            const row = document.createElement('div');
            row.classList.add('row', 'align-items-center', 'mb-2');
            row.setAttribute('data-row', comparisonQuestionRowCount);

            row.innerHTML = `
                <div class="row mb-3 align-items-center" data-row="${comparisonQuestionRowCount}">
                    <div class="col-md-8">
                        <select name="comparison_question_committee_teacher_ids[]" class="form-control teacher-select populate" data-row="${comparisonQuestionRowCount}" required>
                            <option value="">-- Select Teacher --</option>
                            ${comparisonQuestionStaffTeachers.map(t => `<option
                                value="${t.id}" ${t.id == teacherId ? 'selected' : ''}>
                                ${t.user.name}, ${t.designation.designation}, ${t.department.shortname}
                            </option>`).join('')}
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="comparison_question_committee_amounts[]" class="form-control amount-input" step="any" placeholder="Provide Amount" value="${amount}" required>
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-sm btn-danger remove-row">🗑️</button>
                    </div>
                </div>
            `;

            container.appendChild(row);

            // Initialize Select2 for the newly added select input
            $(row).find('select').select2({
                theme: 'bootstrap',
                width: '100%',
                allowClear: true,
                placeholder: '-- Select Teacher --'
            });

            // Delete button logic
            row.querySelector('.remove-row').addEventListener('click', function () {
                row.remove();
            });
        }

        // Load pre-filled rows from DB
        if (savedComparisonCommitteeAssign && savedComparisonCommitteeAssign.length > 0) {
            savedComparisonCommitteeAssign.forEach(assign => {
                createComparisonCommitteeRow(assign.teacher_id, assign.no_of_items);
            });
        }

        // Add blank new row
        document.getElementById('add-comparison-question-paper-row').addEventListener('click', function () {
            createComparisonCommitteeRow();
        });

        // Submit logic
        document.getElementById('form-list-of-comparison-question-paper').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = this;
            const selects = form.querySelectorAll('.teacher-select');
            const inputs = form.querySelectorAll('.amount-input');
            let valid = true;
            let teacherIds = [];

            selects.forEach((select, index) => {
                const teacherId = select.value;
                const amount = inputs[index].value;

                select.classList.remove('is-invalid');
                inputs[index].classList.remove('is-invalid');

                if (!teacherId) {
                    select.classList.add('is-invalid');
                    valid = false;
                }

                if (!amount || amount <= 0) {
                    inputs[index].classList.add('is-invalid');
                    valid = false;
                }

                if (teacherIds.includes(teacherId)) {
                    select.classList.add('is-invalid');
                    valid = false;
                }

                teacherIds.push(teacherId);
            });

            if (!valid) {
                Swal.fire('Validation Failed', 'Make sure each selected row is complete and teachers are not duplicated.', 'error');
                return;
            }

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
                                return response.json().then(err => {
                                    throw new Error(err.message || 'Unknown error occurred.');
                                });
                            }
                            return response.json(); // if response is OK
                        })
                        .then(data => {
                            Swal.fire('Success!', data.message, 'success');

                            const submitBtn = document.getElementById('submit-list-of-comparison-question-paper');
                            submitBtn.textContent = 'Update Comparison,Correction Committee';
                            submitBtn.classList.remove('btn-primary');
                            submitBtn.classList.add('btn-warning');

                            const cards = document.querySelectorAll('.card-list-of-comparison-question-paper');
                            cards.forEach(card => {
                                card.classList.add('fade-highlight');
                                setTimeout(() => card.classList.add('fade-out'), 1000);
                                setTimeout(() => card.classList.remove('fade-highlight', 'fade-out'), 1900);
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
    </script>
@endpush
