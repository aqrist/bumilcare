@extends('layouts.app')

@section('title', 'Create Prescription')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Create Prescription for {{ $examination->patient->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('prescriptions.store', $examination) }}" method="POST" id="prescriptionForm">
                @csrf
                <div id="medicineFields">
                    <div class="medicine-entry border p-3 mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Medicine</label>
                                    <select name="medicine_id[]" class="form-select" required>
                                        <option value="">Select Medicine</option>
                                        @foreach ($medicines as $medicine)
                                            <option value="{{ $medicine->id }}">
                                                {{ $medicine->name }} (Stock: {{ $medicine->stock }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="quantity[]" class="form-control" min="1" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Dosage</label>
                                    <input type="text" name="dosage[]" class="form-control"
                                        placeholder="e.g., 3x1 tablet" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Instructions</label>
                                    <input type="text" name="instructions[]" class="form-control"
                                        placeholder="e.g., After meals" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-secondary" id="addMedicine">
                        Add Another Medicine
                    </button>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('examinations.show', $examination) }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Create Prescription</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('addMedicine').addEventListener('click', function() {
                const template = document.querySelector('.medicine-entry').cloneNode(true);
                template.querySelectorAll('input').forEach(input => input.value = '');
                template.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
                document.getElementById('medicineFields').appendChild(template);
            });
        </script>
    @endpush
@endsection
