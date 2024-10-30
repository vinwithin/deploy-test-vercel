@extends('layout.app')
@section('content')
    {{-- <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="../../css/ckeditor5.css"> --}}


    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Pendaftaran</h3>
            </div>
            <div class="card-body">
                <!-- Step Indicator -->


                <form id="editorForm" method="POST" action="/post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <div id="editor">

                        </div>
                    </div>

                    <textarea class="form-control" id="hiddenContent" placeholder="Enter the Description" rows="5" name="content"
                        style="display: none"></textarea>

                    <button type="submit" class="btn btn-success">Submit</button>

                </form>
            </div>
        </div>
    </div>
    <script src="//cdn.quilljs.com/1.2.2/quill.min.js"></script>
    <script src="/js/image-resize.min.js"></script>
    <script>
        // Inisialisasi Quill
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                imageResize: {
                    displaySize: true
                },
                toolbar: {
                    container: [
                        [{
                            header: [1, 2, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        [{
                            'align': []
                        }],
                        ['image', 'code-block']
                    ],
                    handlers: {
                        image: imageHandler
                    }
                },

            }
        });

        // Handler untuk upload gambar
        function imageHandler() {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.onchange = () => {
                const file = input.files[0];

                // Validasi ukuran file (opsional)
                if (file.size > 5000000) { // 5MB
                    alert('Ukuran file terlalu besar! Maksimal 5MB');
                    return;
                }

                const reader = new FileReader();

                reader.onload = () => {
                    const range = quill.getSelection(true);
                    quill.insertEmbed(range.index, 'image', reader.result);
                    quill.setSelection(range.index + 1);

                    // Update textarea setiap kali ada perubahan
                    updateTextarea();
                };

                reader.readAsDataURL(file);
            };
        }

        // Fungsi untuk update textarea
        function updateTextarea() {
            const content = quill.root.innerHTML;
            document.getElementById('hiddenContent').value = content;
        }

        // Update textarea setiap kali konten berubah
        quill.on('text-change', function() {
            updateTextarea();
        });

        // Handler untuk form submission
        document.getElementById('editorForm').onsubmit = function(e) {
            // Pastikan textarea terupdate dengan konten terbaru
            updateTextarea();

            // Log konten untuk debugging (opsional)
            console.log('Submitting content:', document.getElementById('hiddenContent').value);

            // Form akan submit secara normal ke backend
            return true;
        };
    </script>
@endsection
