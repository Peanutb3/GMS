@extends('layouts.app')

@section('title', 'Edit Profile')

@section('sidebar')
@include('partials.sidebar-admin')
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 flex items-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
            <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
        </svg>
        <a href="{{ route('admin.dashboard') }}" class="hover:text-red-800">Dashboard</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('admin.profile') }}" class="hover:text-red-800">Profile</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">Edit Profile</span>
    </nav>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
        <p class="text-gray-600 mt-2">Update your personal information and account settings</p>
    </div>

    @if(session('success'))
    <x-toast type="success" :message="session('success')" />
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Profile Photo Section -->
        <div class="bg-white rounded-2xl shadow-md p-8 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profile Photo
            </h2>
            <div class="flex items-center space-x-6">
                <div class="relative">
                    <img id="preview-image" src="{{ !empty($user->profile_photo_path) ? asset('storage/' . $user->profile_photo_path) : '' }}" alt="Profile Photo"
                        class="h-24 w-24 rounded-full object-cover border-4 border-gray-200 shadow-sm {{ empty($user->profile_photo_path) ? 'hidden' : '' }}">
                    <div id="preview-placeholder" class="h-24 w-24 rounded-full bg-gradient-to-br from-red-800 to-red-600 flex items-center justify-center border-4 border-gray-200 shadow-sm {{ !empty($user->profile_photo_path) ? 'hidden' : '' }}">
                        <span class="text-3xl font-bold text-white">{{ substr($user->name ?? 'A', 0, 1) }}</span>
                    </div>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Photo</label>
                    <input type="file" id="profile-photo-input" name="profile_photo_original" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-800 hover:file:bg-red-100 cursor-pointer">
                    <input type="hidden" id="profile-photo-base64" name="profile_photo" value="">
                    <p class="text-xs text-gray-500 mt-2">JPG, PNG or GIF (max. 2MB)</p>
                    @error('profile_photo') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <!-- Image Crop Modal -->
            <div id="crop-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Crop Image</h3>
                        <button type="button" id="close-crop" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="max-h-96 overflow-hidden">
                        <img id="crop-image" src="" alt="Crop" class="max-w-full">
                    </div>
                    <div class="mt-4 flex justify-end space-x-3">
                        <button type="button" id="cancel-crop" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="button" id="apply-crop" class="px-4 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900">
                            Apply Crop
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="bg-white rounded-2xl shadow-md p-8 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Personal Information
            </h2>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-600">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none transition" required>
                    @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="bg-white rounded-2xl shadow-md p-8 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Contact Information
            </h2>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-600">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none transition" required>
                    @error('email') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.profile') }}"
                class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition duration-200">
                Cancel
            </a>
            <button type="submit"
                class="px-6 py-3 bg-red-800 text-white font-semibold rounded-lg hover:bg-red-900 shadow-md hover:shadow-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Save Changes
            </button>
        </div>
    </form>
</div>

<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">

<style>
    /* Make crop box circular for preview */
    .cropper-view-box,
    .cropper-face {
        border-radius: 50%;
        outline: 0;
    }

    /* Ensure modal is visible and centered */
    #crop-modal {
        backdrop-filter: blur(2px);
    }

    /* Improve cropper container */
    .cropper-container {
        max-height: 500px;
    }
</style>

<!-- Cropper.js Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

<script>
    let cropper = null;
    let croppedFile = null;

    const input = document.getElementById('profile-photo-input');
    const modal = document.getElementById('crop-modal');
    const cropImage = document.getElementById('crop-image');
    const previewImage = document.getElementById('preview-image');
    const previewPlaceholder = document.getElementById('preview-placeholder');
    const closeBtn = document.getElementById('close-crop');
    const cancelBtn = document.getElementById('cancel-crop');
    const applyBtn = document.getElementById('apply-crop');

    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(event) {
                modal.classList.remove('hidden');
                cropImage.src = event.target.result;

                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }

                // Wait for modal to render and image to load
                setTimeout(function() {
                    cropper = new Cropper(cropImage, {
                        aspectRatio: 1,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 1,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: true,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                        responsive: true,
                        modal: true,
                        background: true,
                        movable: true,
                        zoomable: true,
                        zoomOnWheel: true,
                        wheelZoomRatio: 0.1,
                        scalable: true,
                        rotatable: false,
                        ready: function() {
                            console.log('Cropper initialized successfully!');
                        }
                    });
                }, 100);
            };
            reader.readAsDataURL(file);
        }
    });

    function closeCropModal() {
        modal.classList.add('hidden');
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        input.value = '';
    }

    closeBtn.addEventListener('click', closeCropModal);
    cancelBtn.addEventListener('click', closeCropModal);

    const base64Input = document.getElementById('profile-photo-base64');

    applyBtn.addEventListener('click', function() {
        if (cropper) {
            cropper.getCroppedCanvas({
                width: 400,
                height: 400,
                imageSmoothingQuality: 'high'
            }).toBlob(function(blob) {
                if (!blob) {
                    alert('Error cropping image. Please try again.');
                    return;
                }

                // Convert blob to base64
                const reader = new FileReader();
                reader.onloadend = function() {
                    base64Input.value = reader.result;
                    console.log('Cropped image saved as base64');

                    // Update preview
                    const url = URL.createObjectURL(blob);
                    previewImage.src = url;
                    previewImage.classList.remove('hidden');
                    previewPlaceholder.classList.add('hidden');

                    closeCropModal();
                };
                reader.readAsDataURL(blob);
            }, 'image/jpeg', 0.9);
        }
    });
</script>
@endsection