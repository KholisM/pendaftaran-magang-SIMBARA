@extends('layouts.pelamar')

@section('title', 'Edit Profil')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Profil</h1>
        <p class="text-sm text-gray-600 mt-1">Perbarui informasi profil Anda</p>
    </div>

    <!-- Form Edit Profile -->
    <form action="{{ route('pelamar.update-biodata') }}" method="POST" enctype="multipart/form-data" id="editProfileForm">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Foto Profil -->
            <div class="p-6 border-b border-gray-200">
                <div class="text-center">
                    <div class="relative inline-block">
                        <img id="preview" 
                            src="{{ optional($user->biodata)->profile_photo ? asset('storage/' . $user->biodata->profile_photo) : asset('images/default-profile.png') }}" 
                            class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md"
                            alt="Profile Photo">
                        <label for="photo" class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full p-2 cursor-pointer hover:bg-blue-600">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" 
                               id="photo"
                               name="photo" 
                               class="hidden" 
                               accept="image/*" 
                               onchange="previewImage(event)">
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Klik ikon kamera untuk mengubah foto</p>
                </div>
            </div>           

            <!-- Informasi Pribadi Section -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pribadi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="name" value="{{ $user->name ?? '' }}" required
                                class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="email" name="email" value="{{ $user->email ?? '' }}" required
                                class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                    </div>

                    <!-- Tempat Lahir -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="tempat_lahir" value="{{ $user->biodata->tempat_lahir ?? '' }}" 
                                class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <div class="relative">
                            <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="date" name="tanggal_lahir" value="{{ optional($user->biodata)->tanggal_lahir ? optional($user->biodata->tanggal_lahir)->format('Y-m-d') : '' }}" 
                                class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <div class="relative">
                            <i class="fas fa-venus-mars absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="jenis_kelamin" 
                                    class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ ($user->biodata->jenis_kelamin ?? '') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ ($user->biodata->jenis_kelamin ?? '') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <!-- Agama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                        <div class="relative">
                            <i class="fas fa-pray absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <select name="agama" 
                                    class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ ($user->biodata->agama ?? '') === 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ ($user->biodata->agama ?? '') === 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ ($user->biodata->agama ?? '') === 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ ($user->biodata->agama ?? '') === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ ($user->biodata->agama ?? '') === 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ ($user->biodata->agama ?? '') === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <div class="relative">
                            <i class="fas fa-home absolute left-3 top-3 text-gray-400"></i>
                            <textarea name="alamat" rows="3" 
                                    class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring focus:ring-blue-200">{{ $user->biodata->alamat ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Akademik -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Akademik</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Asal Universitas/Sekolah</label>
                        <div class="relative">
                            <i class="fas fa-university absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="asal_sekolah" value="{{ $user->biodata->asal_sekolah ?? '' }}" 
                                   class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                        <div class="relative">
                            <i class="fas fa-book absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="jurusan" value="{{ $user->biodata->jurusan ?? '' }}" 
                                   class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                        <div class="relative">
                            <i class="fas fa-clock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="number" name="semester" value="{{ $user->biodata->semester ?? '' }}" 
                                   class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                   min="1" max="14">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">IPK</label>
                        <div class="relative">
                            <i class="fas fa-chart-line absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="number" name="ipk" value="{{ $user->biodata->ipk ?? '' }}" 
                                   class="w-full rounded-lg border-gray-300 pl-10 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                   step="0.01" min="0" max="4">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-6 bg-gray-50">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('pelamar.biodata') }}" 
                       class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Form field IDs to be saved
const FORM_FIELDS = [
    'name', 'email', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 
    'agama', 'alamat', 'asal_sekolah', 'jurusan', 'semester', 'ipk'
];

const STORAGE_KEY = 'editProfileFormData';

// Function to save form data to localStorage
function saveFormData() {
    const formData = {};
    FORM_FIELDS.forEach(field => {
        const element = document.querySelector(`[name="${field}"]`);
        if (element) {
            formData[field] = element.value;
        }
    });
    localStorage.setItem(STORAGE_KEY, JSON.stringify(formData));
}

// Function to load form data from localStorage
function loadFormData() {
    const savedData = localStorage.getItem(STORAGE_KEY);
    if (savedData) {
        const formData = JSON.parse(savedData);
        FORM_FIELDS.forEach(field => {
            const element = document.querySelector(`[name="${field}"]`);
            if (element && formData[field]) {
                element.value = formData[field];
            }
        });
    }
}

// Save form data when input changes
document.querySelectorAll('input, select, textarea').forEach(element => {
    element.addEventListener('input', saveFormData);
});

// Load saved form data when page loads
document.addEventListener('DOMContentLoaded', loadFormData);

function previewImage(event) {
    const reader = new FileReader();
    const file = event.target.files[0];
    const preview = document.getElementById('preview');

    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar. Maksimal 2MB');
        event.target.value = '';
        return;
    }

    if (!file.type.match('image.*')) {
        alert('File harus berupa gambar (JPG, PNG)');
        event.target.value = '';
        return;
    }

    reader.onload = function() {
        preview.src = reader.result;
        preview.classList.add('animate-pulse');
        setTimeout(() => {
            preview.classList.remove('animate-pulse');
        }, 1000);
    }
    reader.readAsDataURL(file);
}

document.getElementById('editProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate all required fields
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    let firstInvalidField = null;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('border-red-500');
            if (!firstInvalidField) firstInvalidField = field;
            
            // Add error message below the field
            const errorMessage = document.createElement('p');
            errorMessage.className = 'text-red-500 text-sm mt-1';
            errorMessage.textContent = 'Field ini wajib diisi';
            
            // Remove existing error message if any
            const existingError = field.parentElement.querySelector('.text-red-500');
            if (existingError) existingError.remove();
            
            field.parentElement.appendChild(errorMessage);
        } else {
            field.classList.remove('border-red-500');
            const errorMessage = field.parentElement.querySelector('.text-red-500');
            if (errorMessage) errorMessage.remove();
        }
    });

    if (!isValid) {
        firstInvalidField.focus();
        return;
    }
    
    const form = this;
    const formData = new FormData(form);
    
    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
    submitButton.disabled = true;

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Clear saved form data on successful submission
            localStorage.removeItem(STORAGE_KEY);
            alert(data.message);
            window.location.href = "{{ route('pelamar.biodata') }}";
        } else {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4';
            errorDiv.textContent = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
            form.insertBefore(errorDiv, form.firstChild);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    })
    .finally(() => {
        submitButton.innerHTML = originalButtonText;
        submitButton.disabled = false;
    });
});
</script>
@endpush

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out;
}
</style>
@endsection