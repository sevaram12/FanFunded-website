<!doctype html>
<html lang="en">

<head>
    <!-- required meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- #keywords -->
    <meta name="keywords" content="boot, Bootstrap, Oddsx Sports Betting Website HTML Template">
    <!-- #description -->
    <meta name="description" content="Oddsx Sports Betting Website HTML Template">
    <!-- #title -->
    <title>fanfunded.oi/admin</title>
    <!-- #favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/white-logo.png')}}" type="image/x-icon">
    <!-- ==== css dependencies start ==== -->
    <link rel="stylesheet" href="{{asset('assets/css/style.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/fanfunded-style.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />
  <link rel="stylesheet" href="/DataTables/datatables.css" />
    
  <!--<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css" />-->
  <!--<script src="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.umd.js"></script>-->
  
  <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
  
  <style>
      /* Style for the CKEditor container to set a fixed height and add scrollbar */
      .ck-editor__editable {
          height: 300px; /* Set the desired fixed height */
          overflow-y: auto; /* Enable vertical scrolling */
          border: 1px solid #ddd; /* Optional: Add a border for better visual clarity */
          padding: 10px; /* Optional: Add some padding for better text visibility */
          box-sizing: border-box; /* Ensure padding is included in the total height */
      }
  </style>
    

</head>

<body>

   @include('user.partial.header')
    

    @include('user.partial.hero')

    <section class="top_matches  pb-8 pb-md-10">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 gx-0 gx-lg-4">
                    <div class="top_matches__main">
                        @yield('user-content')
    
    
    @include('user.partial.footer')
   

    <!-- ==== js dependencies start ==== -->
    <script src="{{asset('assets/js/plugins/plugins.js')}}"></script>
    <script src="{{asset('assets/js/plugins/plugin-custom.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables JS and CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  
  <!-- Moment.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  
  <!-- DataTables Moment Sorting Plugin -->
  <script src="https://cdn.datatables.net/plug-ins/1.11.5/sorting/datetime-moment.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
        });
    </script>

<script>
    $(document).ready(function() {
      // Initialize moment.js for the correct date-time format
        $.fn.dataTable.moment('YYYY/MM/DD HH:mm:ss');  // Adjust this to match your date-time format
  
        // Initialize the DataTable
        new DataTable('#myTable', {
            columnDefs: [
                {
                    'targets': 0,  // Index of the column with date + time
                    'type': 'datetime-moment'  // Custom sorting using moment.js
                }
            ],
            order: [[0, 'desc']],  // Sort by the date-time column in descending order
            paging: true,  // Enable pagination
            pageLength: 10,  // Set the number of entries per page
        });
    });
    
    

//  const { ClassicEditor, Essentials, Bold, Italic, Font, Paragraph, Image, ImageUpload, Link, SourceEditing } = CKEDITOR;

//     ClassicEditor
//         .create(document.querySelector('#description'), {
//             plugins: [Essentials, Bold, Italic, Font, Paragraph, Image, ImageUpload, Link, SourceEditing],
//             toolbar: [
//                 'undo', 'redo', '|', 'bold', 'italic', '|',
//                 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
//                 'link', 'imageUpload', '|', 'sourceEditing'
//             ],
//             image: {
//                 toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side', '|', 'imageAlign:left', 'imageAlign:center', 'imageAlign:right']
//             },
//             simpleUpload: {
//                 uploadUrl: '/path/to/your/upload/endpoint',
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 }
//             }
//         })
//         .then(editor => {
//             console.log(editor);
//         })
//         .catch(error => {
//             console.error(error);
//         });



ClassicEditor
    .create(document.querySelector('#editor'), {
        ckfinder: {
            // Laravel route to handle image uploads
            uploadUrl: ""
        },
        toolbar: [
            'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
            'insertTable', 'blockQuote', 'mediaEmbed', 'undo', 'redo', '|', 
            'imageUpload', 'imageResize', 'imageStyle:full', 'imageStyle:side', 'removeFormat'
        ],
        image: {
            resizeUnit: 'px', // Use pixels for resizing
            resizeOptions: [
                {
                    name: 'resizeImage:original',
                    value: null,
                    label: 'Original'
                },
                {
                    name: 'resizeImage:50',
                    value: '50',
                    label: '50%'
                },
                {
                    name: 'resizeImage:custom',
                    value: 'custom',
                    label: 'Custom'
                }
            ],
            toolbar: [
                'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                '|',
                'resizeImage', '|', 'imageTextAlternative', '|', 'removeFormat'
            ]
        },
        mediaEmbed: {
            previewsInData: true // Enable previews for embedded media
        }
    })
    .then(editor => {
        console.log('Editor initialized', editor);

        // Custom Resize Functionality
        editor.ui.componentFactory.add('resizeImage:custom', locale => {
            const view = new editor.ui.button.ButtonView(locale);
            view.set({
                label: 'Custom Resize',
                withText: true,
                tooltip: true
            });

            // When the button is clicked
            view.on('execute', () => {
                const selectedElement = editor.model.document.selection.getSelectedElement();

                if (selectedElement && selectedElement.is('element', 'image')) {
                    const customWidth = prompt('Enter custom width in px:', '500');
                    const customHeight = prompt('Enter custom height in px or leave blank:', 'auto');

                    editor.model.change(writer => {
                        if (customWidth) {
                            writer.setAttribute('width', customWidth, selectedElement);
                        }
                        if (customHeight && customHeight !== 'auto') {
                            writer.setAttribute('height', customHeight, selectedElement);
                        }
                    });
                } else {
                    alert('Please select an image to resize.');
                }
            });

            return view;
        });
    })
    .catch(error => {
        console.error('Editor initialization error:', error);
    });





  </script>

    
</body>

</html>