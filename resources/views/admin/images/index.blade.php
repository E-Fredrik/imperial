<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Images</h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          @if(session('success'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">{{ session('success') }}</div>
          @endif

          <div class="mb-4 flex items-center justify-between">
            <a href="{{ route('admin.images.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md text-sm font-medium">
              Upload Image
            </a>
          </div>

          <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
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

              <div class="border rounded overflow-hidden bg-white dark:bg-gray-700 shadow-sm">
                <div class="h-36 flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                  @if($url)
                    <img src="{{ $url }}" alt="" class="object-cover h-full w-full" />
                  @else
                    <div class="text-xs text-gray-500">No preview</div>
                  @endif
                </div>

                <div class="p-2 text-sm">
                  <div class="font-medium truncate">{{ $img->description ?? '—' }}</div>
                  <div class="text-xs text-gray-500">path: <span class="break-all">{{ $img->image_path }}</span></div>
                  <div class="flex items-center justify-between mt-2">
                    <form method="POST" action="{{ route('admin.images.toggleFeatured', $img) }}">
                      @csrf
                      <button type="submit" class="inline-flex items-center px-2 py-1 text-xs rounded {{ $img->is_featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $img->is_featured ? 'Featured' : 'Feature' }}
                      </button>
                    </form>

                    <form method="POST" action="{{ route('admin.images.destroy', $img) }}" onsubmit="return confirm('Delete image?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="inline-flex items-center px-2 py-1 text-xs rounded bg-rose-600 text-white">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <div class="mt-4">
            {{ $images->links() }}
          </div>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>