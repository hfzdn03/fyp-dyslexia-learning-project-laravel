<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Learnings
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Welcome to your learnings page {{ auth()->user()->name }}!
                </div>
                <a href="{{ route('learnings.doLearning') }}">
                    <button type="button" class="ml-4 mb-4 btn btn-primary" style="background-color:#0d6efd;">Click
                        here to start learning!</button>
                </a>
            </div>

            <p class="text-xl" style="margin-bottom:10px; margin-top: 40px;"><b>Your Learning Histories</b></p>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Word</th>
                                <th scope="col">Your answer</th>
                                <th scope="col">Accuracy Percentage(%)</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($learnings as $learning)
                                <tr>
                                    <th scope="row">{{ $learning->id }}</th>
                                    <td>{{ $learning->randomized_string }}</td>
                                    <td>
                                        <button type="button" class="showImage btn btn-primary"
                                            style="background-color:#0d6efd"
                                            data-image-url="{{ $learning->image_url }}">Click to
                                            view</button>
                                    </td>
                                    <td>{{ $learning->accuracy_percentage }}</td>
                                    <td>
                                        <div class="d-flex flex-row">
                                            <a href="{{ route('learnings.doLearning.show', ['id' => $learning->id]) }}" class="mr-2">
                                                <button type="button" class="btn btn-warning"
                                                    style="background-color:#ffc107"><i class="fas fa-redo"></i>
                                                    Re-do</button>
                                            </a>
                                            <form action="{{ route('learnings.delete', ['id' => $learning->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger"
                                                    style="background-color:#dc3545"><i class="fas fa-trash"></i>
                                                    Delete</button>
                                            </form>
                                        </div>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Your Answer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body text-center">
                    <img id="answerImage" class="img-fluid text-center">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        // Show modal on button click
        $(".showImage").click(function() {
            var imageUrl = $(this).data("image-url");

            $("#answerImage").attr("src", imageUrl);

            $("#myModal").modal('show');
        });
    });
</script>
