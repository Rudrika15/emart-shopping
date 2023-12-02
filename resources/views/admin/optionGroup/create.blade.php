@extends('layouts.master') @section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="fs-4 fw-1">Option Group Add</div>
            <div class="">
                <a href="{{route('optionGroup.index')}}" class="btn btn-success">Back</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="optionCreate" action="{{route('optionGroup.store')}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Title</label>
                <input type="text" class="form-control" id="optionGroupName" name="optionGroupName" />
            </div>
            <div class="alert alert-danger print-error-msg" style="display: none">
                <ul></ul>
            </div>

            <div class="row">
                <div class="mb-3 col">
                    <label for="category" class="form-label">Category</label>

                    <select name="categoryId" id="categoryId" class="form-control">
                        <option selected> --Select Category--</option>
                        @foreach ($category as $category)
                        <option value="{{$category->id}}">{{$category->title}}</option>
                        @endforeach

                    </select>
                </div>


                <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>



<script>
    console.log("Script is running");
    $(function() {
        $(".optionCreate").on("submit", function(e) {
            e.preventDefault();
            var formData = new FormData();
            formData.append("_token", "{{csrf_token()}}");
            formData.append("optionGroupName", $("#optionGroupName").val());
            $.ajax({
                url: "{{route('optionGroup.store')}}",
                data: formData,
                contentType: false,
                processData: true,
                type: "POST",
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire(
                            'Added!',
                            'Option Group Added Successfully!',
                            'success'
                        )
                    }
                    window.location.href = "{{route('optionGroup.index') }}";

                },
            });
        });
    });
</script>
@stop