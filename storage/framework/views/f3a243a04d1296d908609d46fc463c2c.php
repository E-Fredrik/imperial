<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['id', 'name', 'value' => '']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['id', 'name', 'value' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<input
    type="hidden"
    name="<?php echo e($name); ?>"
    id="<?php echo e($id); ?>_input"
    value="<?php echo e($value); ?>"
/>

<trix-toolbar
    class="[&_.trix-button]:bg-white [&_.trix-button.trix-active]:bg-gray-300"
    id="<?php echo e($id); ?>_toolbar"
></trix-toolbar>

<trix-editor
    id="<?php echo e($id); ?>"
    toolbar="<?php echo e($id); ?>_toolbar"
    input="<?php echo e($id); ?>_input"
    <?php echo e($attributes->merge(['class' => 'trix-content border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-1 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm dark:[&_pre]:!bg-gray-700 dark:[&_pre]:rounded dark:[&_pre]:!text-white'])); ?>

></trix-editor>
<?php /**PATH C:\Uni\WebDev\Laravel\imperial\resources\views/components/trix-input.blade.php ENDPATH**/ ?>