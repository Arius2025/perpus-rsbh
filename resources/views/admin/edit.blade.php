@extends('layout')

@section('title', 'Edit Buku - PustakaDigital')

@section('styles')
<style>
    /* Reuse styles from create.blade.php */
    .form-container {
        background: var(--card-bg-light);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }
    
    body.dark-mode .form-container {
        background: var(--card-bg-dark);
        border: 1px solid rgba(255,255,255,0.05);
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    .form-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.5rem;
    }
    
    body.dark-mode .form-label {
        color: #a0aec0;
    }

    .form-control, .form-select {
        padding: 0.75rem 1rem;
        border-radius: 12px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }
    
    body.dark-mode .form-control, body.dark-mode .form-select {
        border-color: #4a5568;
        background-color: #2d3748;
        color: #e2e8f0;
    }

    .form-control:focus, .form-select:focus {
        background-color: #ffffff;
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.25rem rgba(21, 115, 71, 0.25);
    }
    
    body.dark-mode .form-control:focus, body.dark-mode .form-select:focus {
        background-color: #1a202c;
    }

    .file-upload-wrapper {
        position: relative;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background-color: #f8f9fa;
        cursor: pointer;
    }
    
    body.dark-mode .file-upload-wrapper {
        border-color: #4a5568;
        background-color: #2d3748;
    }

    .file-upload-wrapper:hover {
        border-color: var(--bs-primary);
        background-color: rgba(21, 115, 71, 0.05);
    }

    .form-control-file {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-icon {
        font-size: 2.5rem;
        color: #94a3b8;
        margin-bottom: 1rem;
    }
    
    #cover-preview {
        max-width: 200px;
        border-radius: 10px;
        margin-top: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .current-file-badge {
        display: inline-block;
        background: rgba(21, 115, 71, 0.1);
        color: var(--bs-primary);
        padding: 8px 15px;
        border-radius: 12px;
        margin-bottom: 15px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .source-toggle {
        background: #f1f5f9;
        padding: 5px;
        border-radius: 12px;
        display: inline-flex;
        margin-bottom: 1.5rem;
    }

    body.dark-mode .source-toggle {
        background: #2d3748;
    }

    .source-toggle .btn-check:checked + .btn {
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        color: var(--bs-primary);
        font-weight: 700;
    }

    body.dark-mode .source-toggle .btn-check:checked + .btn {
        background: #4a5568;
        color: #4ade80;
    }

    .source-toggle .btn {
        border: none;
        border-radius: 8px;
        padding: 8px 20px;
        font-size: 0.9rem;
        color: #64748b;
        transition: all 0.2s;
    }
</style>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-9 col-lg-10 fade-in-up">
        
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-light rounded-circle me-3" style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
            <div>
                <h2 class="fw-bold mb-0">Edit Buku</h2>
                <p class="text-muted mb-0">Perbarui informasi "{{ $book->title }}".</p>
            </div>
        </div>

        <div class="form-container">
            @if ($errors->any())
                <div class="alert alert-danger" style="border-radius: 12px;">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <h5 class="fw-bold mb-4 border-bottom pb-2">Informasi Umum</h5>
                
                <div class="row mb-4">
                    <div class="col-md-12 mb-3">
                        <label for="title" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="author" class="form-label">Penulis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="publisher" class="form-label">Penerbit</label>
                        <input type="text" class="form-control" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="description" class="form-label">Sinopsis / Deskripsi <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $book->description) }}</textarea>
                </div>

                <h5 class="fw-bold mb-4 border-bottom pb-2">Sumber Buku (Pilih Opsi)</h5>
                
                <div class="source-toggle mb-4">
                    <input type="radio" class="btn-check" name="source_type" id="source_pdf" value="pdf" {{ !$book->external_link ? 'checked' : '' }}>
                    <label class="btn" for="source_pdf"><i class="bi bi-file-earmark-pdf me-2"></i>Upload PDF</label>

                    <input type="radio" class="btn-check" name="source_type" id="source_link" value="link" {{ $book->external_link ? 'checked' : '' }}>
                    <label class="btn" for="source_link"><i class="bi bi-link-45deg me-2"></i>Link Eksternal</label>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-4 mb-md-0 text-center">
                        <label class="form-label text-start d-block">Cover Buku (Gambar)</label>
                        
                        @if($book->cover_image)
                            <div class="current-file-badge"><i class="bi bi-image me-2"></i>Cover saat ini tersedia</div>
                            <img id="cover-preview" src="{{ asset('uploads/books/' . $book->cover_image) }}" alt="Cover Saat Ini" class="mb-3 d-block mx-auto" />
                        @else
                            <div class="current-file-badge text-warning bg-warning bg-opacity-10"><i class="bi bi-exclamation-triangle me-2"></i>Belum ada cover</div>
                            <img id="cover-preview" src="#" alt="Cover Preview" style="display:none;" class="mb-3 d-block mx-auto" />
                        @endif
                        
                        <div class="file-upload-wrapper mt-2" style="padding: 1.5rem;">
                            <h6 class="mb-1 text-primary" id="cover-filename"><i class="bi bi-upload me-2"></i>Klik untuk mengganti gambar</h6>
                            <input type="file" class="form-control-file" id="cover_image" name="cover_image" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <!-- PDF Input Section -->
                        <div id="pdf-section" style="{{ $book->external_link ? 'display:none;' : '' }}">
                            <label class="form-label">File Buku (PDF)</label>
                            @if($book->pdf_file)
                                <div class="current-file-badge d-block text-center mb-3"><i class="bi bi-file-pdf me-2"></i>File PDF saat ini tersedia</div>
                            @endif
                            <div class="file-upload-wrapper" id="pdf-wrapper">
                                <i class="bi bi-file-earmark-pdf file-icon text-danger"></i>
                                <h6 class="mb-1 text-primary" id="pdf-filename"><i class="bi bi-upload me-2"></i>Klik untuk mengganti PDF</h6>
                                <input type="file" class="form-control-file" id="pdf_file" name="pdf_file" accept=".pdf">
                            </div>
                        </div>

                        <!-- Link Input Section -->
                        <div id="link-section" style="{{ !$book->external_link ? 'display:none;' : '' }}">
                            <label for="external_link" class="form-label">Link Buku (URL)</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-transparent"><i class="bi bi-link-45deg"></i></span>
                                <input type="url" class="form-control" id="external_link" name="external_link" placeholder="https://example.com/buku..." value="{{ old('external_link', $book->external_link) }}">
                            </div>
                            <p class="small text-muted"><i class="bi bi-info-circle me-1"></i>Masukkan link lengkap termasuk http:// atau https://</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mt-5">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5"><i class="bi bi-save me-2"></i> Simpan Perubahan</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Source Toggle
        const sourcePdf = document.getElementById('source_pdf');
        const sourceLink = document.getElementById('source_link');
        const pdfSection = document.getElementById('pdf-section');
        const linkSection = document.getElementById('link-section');
        const pdfInput = document.getElementById('pdf_file');
        const linkInput = document.getElementById('external_link');

        function toggleSource() {
            if (sourcePdf.checked) {
                pdfSection.style.display = 'block';
                linkSection.style.display = 'none';
                linkInput.required = false;
            } else {
                pdfSection.style.display = 'none';
                linkSection.style.display = 'block';
                linkInput.required = true;
            }
        }

        sourcePdf.addEventListener('change', toggleSource);
        sourceLink.addEventListener('change', toggleSource);
        
        // Handle Cover Image Preview & Filename
        const coverInput = document.getElementById('cover_image');
        const coverFilename = document.getElementById('cover-filename');
        const coverPreview = document.getElementById('cover-preview');
        
        coverInput.addEventListener('change', function(e) {
            if(this.files && this.files[0]) {
                const file = this.files[0];
                coverFilename.textContent = "File Baru: " + file.name;
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    coverPreview.src = e.target.result;
                    coverPreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // Handle PDF Filename
        const pdfFilename = document.getElementById('pdf-filename');
        pdfInput.addEventListener('change', function(e) {
            if(this.files && this.files[0]) {
                pdfFilename.textContent = "File Baru: " + this.files[0].name;
            }
        });
    });
</script>
@endsection
