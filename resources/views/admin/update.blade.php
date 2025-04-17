<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin panel</title>
    <!-- base:css -->
    <link rel="stylesheet" href="admin/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="admin/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="admin/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.svg">
</head>
<body>

<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include("admin.topnav")
    <!-- partial -->
    @include('admin.sidebar')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Product upload</h4>
                            <p class="card-description">
                                Upload new product here
                            </p>
                            <form class="forms-sample" id="productForm" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputName1">Name</label>
                                    <input type="text" class="form-control" id="exampleInputName1" name="name" value="{{ old('name') }}" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelectCategory">Category</label>
                                    <select class="form-control" id="exampleSelectCategory" name="category" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="imageUpload">Upload Image</label>
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" id="fileName" value="{{ old('image') }}" disabled placeholder="Upload Image">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary" type="button" id="uploadButton">Upload</button>
                                        </span>
                                        <input type="file" id="imageUpload" name="image" class="file-upload-default" style="display: none;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleTextarea1">Description</label>
                                    <textarea class="form-control" id="exampleTextarea1" name="description" rows="4" required>{{ old('description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="price1">Price</label>
                                    <input type="number" class="form-control" id="price1" name="price" value="{{ old('price') }}" placeholder="Amount" required>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
      @include('admin.footer')
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- base:js -->
<script src="admin/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="admin/js/off-canvas.js"></script>
<script src="admin/js/hoverable-collapse.js"></script>
<script src="admin/js/template.js"></script>
<script src="admin/js/settings.js"></script>
<script src="admin/js/todolist.js"></script>
<!-- endinject -->
<!-- plugin js for this page -->
<script src="admin/vendors/progressbar.js/progressbar.min.js"></script>
<script src="admin/vendors/chart.js/Chart.min.js"></script>
<!-- End plugin js for this page -->
<!-- Custom js for this page-->
<script src="admin/js/dashboard.js"></script>
<!-- End custom js for this page-->
<script>
    // Get elements
    const uploadButton = document.getElementById('uploadButton');
    const fileInput = document.getElementById('imageUpload');
    const fileNameInput = document.getElementById('fileName');

    // Trigger file input click when the button is clicked
    uploadButton.addEventListener('click', function() {
        fileInput.click();
    });

    // Update the text input with the selected file name
    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            fileNameInput.value = fileInput.files[0].name;  // Set the file name in the text input
        }
    });
</script>
</body>

</html>
