<x-app-layout>
    <h1>{{ isset($student) ? 'Edit Student' : 'Add Student' }}</h1>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ isset($student) ? route('student.update', $student->id) : route('student.store') }}" method="POST">
        @csrf
        @if(isset($student))
            @method('PUT') <!-- For update request -->
        @endif

        <div>
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" value="{{ old('firstname', $student->firstname ?? '') }}" required>
            @error('firstname')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" value="{{ old('lastname', $student->lastname ?? '') }}" required>
            @error('lastname')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="private_number">Private Number:</label>
            <input type="text" id="private_number" name="private_number" value="{{ old('private_number', $student->private_number ?? '') }}" required>
            @error('private_number')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="grade">Grade:</label>
            <input type="number" id="grade" name="grade" value="{{ old('grade', $student->grade ?? '') }}" required>
            @error('grade')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="sector">Sector:</label>
            <input type="number" id="sector" name="sector" value="{{ old('sector', $student->sector ?? '') }}" required>
            @error('sector')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="parent_mail">Parent Mail:</label>
            <input type="email" id="parent_mail" name="parent_mail" value="{{ old('parent_mail', $student->parent_mail ?? '') }}" required>
            @error('parent_mail')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="parent_number">Parent Number:</label>
            <input type="text" id="parent_number" name="parent_number" value="{{ old('parent_number', $student->parent_number ?? '') }}" required>
            @error('parent_number')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="pupil_status">Pupil Status:</label>
            <input type="text" id="pupil_status" name="pupil_status" value="{{ old('pupil_status', $student->pupil_status ?? '') }}" required>
            @error('pupil_status')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="additional_information">Additional Information:</label>
            <textarea id="additional_information" name="additional_information">{{ old('additional_information', $student->additional_information ?? '') }}</textarea>
            @error('additional_information')
            <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">{{ isset($student) ? 'Update' : 'Submit' }}</button>
    </form>
</x-app-layout>
