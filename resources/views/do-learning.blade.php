<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Learnings
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <p class="mb-3"><b>Write on a piece of paper according to that is shown below and then upload the
                            image.</b></p>
                    <input type="text" class="form-control" style="font-size:30px;" value="{{ $randomizedWord }}"
                        readonly>
                    <form action="{{ route('learnings.store') }}" id="submitForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="randomized_string" value="{{ $randomizedWord }}">

                        <div class="form-group my-4">
                            <label for="formFile" class="form-label"><b>Upload your handwriting image below
                                    <small><i>(only accept png, jpg, and jpeg and up to 10mb)</i></small>:
                                </b></label><br>
                            <input class="form- py-3" type="file" name="image"
                                accept="image/png, image/jpg, image/jpeg" required>
                        </div>
                        <p class="mb-3"><b>Click the button below to complete your progress and calculate the accuracy
                                of your handwriting!</b></p>

                        <button type="button" class="btn btn-primary" style="background-color:#0d6efd;"
                            onclick="validateForm()">Complete
                            Learning</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            var fileInput = document.querySelector('input[name="image"]');

            if (fileInput.files.length === 0) {
                alert('Please select an image file.');
                return;
            }

            var fileSize = fileInput.files[0].size / 1024 / 1024;

            var allowedTypes = ['image/png', 'image/jpg', 'image/jpeg'];
            if (!allowedTypes.includes(fileInput.files[0].type)) {
                alert('Please select a valid image file (PNG, JPG, JPEG).');
                return;
            }

            if (fileSize > 10) {
                alert('File size must be less than 10 MB.');
                return;
            }

            document.getElementById('submitForm').submit();
        }
    </script>
</x-app-layout>
