@extends('layouts.admin')

@section('title', 'Edit Room')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2>Edit Room: {{ $room->name }}</h2>
            
            <div class="card mt-4">
                <div class="card-body">
                    <form action="{{ route('admin.rooms.update', $room) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Room Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $room->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price_per_night" class="form-label">Price per Night (Rs) *</label>
                                    <input type="number" step="0.01" class="form-control @error('price_per_night') is-invalid @enderror" 
                                           id="price_per_night" name="price_per_night" value="{{ old('price_per_night', $room->price_per_night) }}" required>
                                    @error('price_per_night')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" required>{{ old('description', $room->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="size" class="form-label">Size *</label>
                                    <input type="text" class="form-control @error('size') is-invalid @enderror" 
                                           id="size" name="size" value="{{ old('size', $room->size) }}" required>
                                    @error('size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Capacity (persons) *</label>
                                    <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                           id="capacity" name="capacity" value="{{ old('capacity', $room->capacity) }}" required>
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="bed_type" class="form-label">Bed Type *</label>
                                    <input type="text" class="form-control @error('bed_type') is-invalid @enderror" 
                                           id="bed_type" name="bed_type" value="{{ old('bed_type', $room->bed_type) }}" required>
                                    @error('bed_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="services" class="form-label">Services *</label>
                            <input type="text" class="form-control @error('services') is-invalid @enderror" 
                                   id="services" name="services" 
                                   value="{{ old('services', $room->services) }}" required>
                            <small class="text-muted">Separate with commas</small>
                            @error('services')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Room Image *</label>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" value="{{ old('image', $room->image) }}" readonly required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('imageFile').click()">
                                            <i class="fa fa-folder-open"></i> Browse
                                        </button>
                                    </div>
                                    <input type="file" id="imageFile" accept="image/*" style="display: none;" onchange="handleImageSelect(this)">
                                    <small class="text-muted">Select an image or use path: img/room/room-b1.jpg</small>
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
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="available" {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="booked" {{ old('status', $room->status) === 'booked' ? 'selected' : '' }}>Booked</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <script>
                        function handleImageSelect(input) {
                            if (input.files && input.files[0]) {
                                const file = input.files[0];
                                const reader = new FileReader();
                                
                                reader.onload = function(e) {
                                    document.getElementById('previewImg').src = e.target.result;
                                    document.getElementById('previewImg').style.display = 'block';
                                    document.getElementById('previewText').style.display = 'none';
                                    
                                    const filename = file.name;
                                    document.getElementById('image').value = 'img/room/' + filename;
                                };
                                
                                reader.readAsDataURL(file);
                            }
                        }
                        
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
                            <button type="submit" class="btn btn-primary">Update Room</button>
                            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
