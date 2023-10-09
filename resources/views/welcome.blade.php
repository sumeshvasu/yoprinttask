<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Styles -->
    <style>
        .dropzone {
            background: #e3e6ff;
            border-radius: 13px;
            width: 550px;
            margin-left: auto;
            margin-right: auto;
            border: 2px dotted #dee2e6;
            margin-top: 40px;
        }
    </style>
</head>

<body class="antialiased">
    <div class="container-fluid">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background: gray; color:#f1f7fa; font-weight:bold;">
                        File Uploads(.csv)
                    </div>
                    <div class="card-body">
                        <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="document">Documents</label>
                                <div class="needsclick dropzone" id="document-dropzone">
                                </div>
                                <button type="submit" class="btn btn-primary mt-5">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background: gray; color:#f1f7fa; font-weight:bold;">
                        Uploads History
                        <span><img id="loaderImg" class="mt-1" src="/loader.gif"
                                style="width:15px; float:right;"></span>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover overflow-auto text-nowrap">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>File Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody id="bodyData">
                                @foreach ($result as $key => $fileData)
                                    <tr>
                                        <td>{{ $fileData->created_at }}<br />
                                            {{ displayReadableTimeDifference($fileData->created_at, $fileData->updated_at) }}
                                            minutes ago
                                        </td>
                                        <td>{{ $fileData->file_name }}</td>
                                        <td>{{ $fileData->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.documentDropzone = {
            url: "{{ route('uploads') }}",
            maxFilesize: 500, // MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function(file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="document[]"][value="' + name + '"]').remove()
            },
            init: function() {
                @if (isset($project) && $project->document)
                    var files =
                        {!! json_encode($project->document) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                    }
                @endif
            }
        }

        $(document).ready(function() {
            $('#loaderImg').hide();

            setInterval(() => {
                getUploadHistoryList();
            }, 5000);
        });

        function getUploadHistoryList() {
            $('#loaderImg').show();

            $.ajax({
                url: "{{ route('upload.history.list') }}",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(dataResult) {
                    var resultData = dataResult;
                    var bodyData = '';
                    var i = 1;
                    $.each(resultData, function(index, row) {
                        bodyData += "<tr>"
                        bodyData += "<td>" + row.time_details + "</td><td>" + row.file_name +
                            "</td><td>" + row.status + "</td>";
                        bodyData += "</tr>";
                    });

                    $("#bodyData").html('');
                    $("#bodyData").append(bodyData);
                    $('#loaderImg').hide();
                }
            });
        }
    </script>
</body>

</html>
