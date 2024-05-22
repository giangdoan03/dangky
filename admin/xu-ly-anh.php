<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel - Settings</title>
    <?php require('inc/links.php'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <style>
        .preview, .cropped {
            margin: 10px;
        }
        .preview img, .cropped img{
            width: 50px;
        }
        div#output {
            display: none;
        }
        #croppedOutput img {
            width: 50px;
        }
    </style>
</head>
<body class="bg-light">
<?php require('inc/header.php'); ?>

<div class="container-fluid" id="main-content">
    <div class="row">
        <div class="col-lg-10 ms-auto p-4 overflow-hidden">
            <h3 class="mb-4">Xử lý ảnh</h3>
            <!-- General settings section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="list-student card-body">

                    <input type="file" class="form-control" id="uploadZip" accept=".zip">
                    <div id="output"></div>
                    <button class="btn btn-outline-primary mt-3" onclick="processImages()">Process Images</button>
                    <div id="croppedOutput"></div>
                    <a id="downloadLink" style="display: none;">Download Cropped Images</a>
                </div>
            </div>
        </div>
    </div>
</div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip-utils/0.1.0/jszip-utils.min.js"></script>
<script src="./js/crop.js"></script>
</body>
</html>


