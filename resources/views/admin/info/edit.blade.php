<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Information') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @php
                        // safe primitive id for route generation
                        $infoId = optional($information)->getKey() ?? request()->route('info');

                        // title: prefer old input then model
                        $titleValue = old('title', $information->title ?? '');

                        // content: prefer old raw HTML then model content converted to Trix HTML if available,
                        // otherwise fallback to raw model string.
                        $oldContent = old('content');
                        if (!is_null($oldContent)) {
                            $contentValue = $oldContent;
                        } else {
                            $contentValue = '';
                            if (isset($information)) {
                                // handle Tonysm or plain string content
                                if (is_object($information->content) && method_exists($information->content, 'toTrixHtml')) {
                                    $contentValue = $information->content->toTrixHtml() ?? '';
                                } else {
                                    $contentValue = $information->content ?? '';
                                }
                            }
                        }
                    @endphp

                    <form method="POST" action="{{ $infoId ? route('admin.info.update', ['info' => $infoId]) : url()->current() }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                    value="{{ $titleValue }}" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="content" :value="__('Content')" />
                                {{-- Trix input component: pass computed HTML value --}}
                                <x-trix-input id="content" name="content" :value="$contentValue" autocomplete="off" />
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-3">
                            <x-primary-button>{{ __('Update') }}</x-primary-button>

                            <a href="{{ route('admin.info.index') }}"
                               class="inline-flex items-center px-3 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-sm rounded">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
