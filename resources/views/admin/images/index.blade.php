<x-admin-layout>
  <x-slot name="title">Images Management</x-slot>
  <x-slot name="header">Images Management</x-slot>
  <x-slot name="icon">bi-image</x-slot>

  @if(session('success'))
    <div class="alert-success">
      <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
  @endif

  <div class="admin-card">
    <div class="card-header">
      <h3>All Images</h3>
      <a href="{{ route('admin.images.create') }}" class="btn-admin-primary">
        <i class="bi bi-upload"></i> Upload Image
      </a>
    </div>

    <div class="row g-4">
      @foreach($images as $img)
        @php
          $p = $img->image_path ?? '';
          $publicCandidate = public_path($p);
          if ($p !== '' && file_exists($publicCandidate)) {
              $url = asset($p);
          } elseif ($p) {
              $url = asset('storage/' . ltrim($p, '/'));
          } else {
              $url = null;
          }
        @endphp

        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div style="background: #2a2a2a; border: 2px solid #333; border-radius: 12px; overflow: hidden; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#FAEBD7'" onmouseout="this.style.borderColor='#333'">
            <div style="height: 200px; display: flex; align-items: center; justify-content: center; background: #1a1a1a;">
              @if($url)
                <img src="{{ $url }}" alt="" style="object-fit: cover; height: 100%; width: 100%;" />
              @else
                <span style="color: #666; font-size: 0.875rem;">No preview</span>
              @endif
            </div>

            <div style="padding: 1rem;">
              <div style="font-weight: 600; color: #FAEBD7; margin-bottom: 0.5rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $img->description ?? '—' }}</div>
              <div style="font-size: 0.75rem; color: #999; word-break: break-all; margin-bottom: 1rem;">{{ $img->image_path }}</div>
              
              <div class="d-flex gap-2 justify-content-between">
                <form method="POST" action="{{ route('admin.images.toggleFeatured', $img) }}" class="flex-grow-1">
                  @csrf
                  <button type="submit" class="w-100 {{ $img->is_featured ? 'btn-admin-primary' : 'btn-admin-secondary' }}" style="padding: 0.5rem; font-size: 0.875rem;">
                    @if($img->is_featured)
                      <i class="bi bi-star-fill"></i> Featured
                    @else
                      <i class="bi bi-star"></i> Feature
                    @endif
                  </button>
                </form>

                <form method="POST" action="{{ route('admin.images.destroy', $img) }}" onsubmit="return confirm('Delete image?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-admin-danger" style="padding: 0.5rem 0.8rem; font-size: 0.875rem;">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div style="margin-top: 2rem;">
      {{ $images->links() }}
    </div>
  </div>
</x-admin-layout>