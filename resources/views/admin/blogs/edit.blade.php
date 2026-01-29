@extends('layouts.admin')

@section('title', 'Edit Blog Post')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2>Edit Blog Post</h2>
            
            <div class="card mt-4">
                <div class="card-body">
                    <form action="{{ route('admin.blogs.update', $blog) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label">Category *</label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror" 
                                   id="category" name="category" value="{{ old('category', $blog->category) }}" required>
                            <small class="text-muted">e.g., Travel, Hotel News, Events</small>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt *</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" name="excerpt" rows="2" required>{{ old('excerpt', $blog->excerpt) }}</textarea>
                            <small class="text-muted">Short description for preview</small>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Content *</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="10" required>{{ old('content', $blog->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Image *</label>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" value="{{ old('image', $blog->image) }}" 
                                               readonly required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('imageFile').click()">
                                            <i class="fa fa-folder-open"></i> Browse
                                        </button>
                                    </div>
                                    <input type="file" id="imageFile" accept="image/*" style="display: none;" onchange="handleImageSelect(this)">
                                    <small class="text-muted">Select an image or use path: img/blog/blog-1.jpg</small>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div id="imagePreview" style="border: 1px solid #ddd; padding: 10px; border-radius: 4px; text-align: center; min-height: 120px;">
                                        <img id="previewImg" src="" alt="Preview" style="max-width: 100%; max-height: 150px; display: none;">
                                        <p id="previewText" style="color: #999; margin: 40px 0;">No image selected</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                        function handleImageSelect(input) {
                            if (input.files && input.files[0]) {
                                const file = input.files[0];
                                const reader = new FileReader();
                                
                                reader.onload = function(e) {
                                    // Show preview
                                    document.getElementById('previewImg').src = e.target.result;
                                    document.getElementById('previewImg').style.display = 'block';
                                    document.getElementById('previewText').style.display = 'none';
                                    
                                    // Set path to img/blog/filename
                                    const filename = file.name;
                                    document.getElementById('image').value = 'img/blog/' + filename;
                                };
                                
                                reader.readAsDataURL(file);
                            }
                        }
                        
                        // Show existing image preview if path is set
                        window.addEventListener('DOMContentLoaded', function() {
                            const imagePath = document.getElementById('image').value;
                            if (imagePath && imagePath.trim() !== '') {
                                const img = document.getElementById('previewImg');
                                img.src = '{{ asset("") }}' + imagePath;
                                img.style.display = 'block';
                                document.getElementById('previewText').style.display = 'none';
                            }
                        });
                        </script>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Update Post</button>
                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
