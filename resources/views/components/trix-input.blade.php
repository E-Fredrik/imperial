@props(['id', 'name', 'value' => ''])

<input
    type="hidden"
    name="{{ $name }}"
    id="{{ $id }}_input"
    value="{{ $value }}"
/>

<trix-toolbar
    id="{{ $id }}_toolbar"
    style="background: rgba(250, 235, 215, 0.05); border: 1px solid rgba(250, 235, 215, 0.2); border-radius: 8px 8px 0 0; padding: 0.5rem; margin-bottom: 0;"
></trix-toolbar>

<trix-editor
    id="{{ $id }}"
    toolbar="{{ $id }}_toolbar"
    input="{{ $id }}_input"
    style="background: rgba(250, 235, 215, 0.05); border: 1px solid rgba(250, 235, 215, 0.2); border-top: none; border-radius: 0 0 8px 8px; color: #FAEBD7; min-height: 250px; padding: 1rem;"
    {{ $attributes }}
></trix-editor>

<style>
/* Trix Editor Dark Theme Styling */
trix-toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
}

trix-toolbar .trix-button-row {
    display: flex;
    flex-wrap: wrap;
    gap: 0.25rem;
}

trix-toolbar .trix-button-group {
    display: flex;
    gap: 0.25rem;
    margin-right: 0.5rem;
}

trix-toolbar .trix-button {
    background: rgba(250, 235, 215, 0.1) !important;
    border: 1px solid rgba(250, 235, 215, 0.2) !important;
    color: #FAEBD7 !important;
    border-radius: 6px !important;
    padding: 0.5rem !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    font-size: 0.875rem !important;
    min-width: 32px !important;
    height: 32px !important;
}

trix-toolbar .trix-button:hover {
    background: rgba(250, 235, 215, 0.2) !important;
    border-color: rgba(250, 235, 215, 0.3) !important;
}

trix-toolbar .trix-button.trix-active {
    background: rgba(250, 235, 215, 0.25) !important;
    border-color: rgba(250, 235, 215, 0.4) !important;
    color: #fff !important;
}

trix-toolbar .trix-button--icon::before {
    opacity: 0.9;
}

trix-toolbar .trix-button--icon.trix-active::before {
    opacity: 1;
}

trix-toolbar .trix-dialogs {
    background: #1a1a1a !important;
    border: 1px solid rgba(250, 235, 215, 0.2) !important;
    border-radius: 8px !important;
    padding: 1rem !important;
}

trix-toolbar .trix-dialog {
    background: transparent !important;
}

trix-toolbar .trix-dialog__link-fields {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

trix-toolbar .trix-dialog__link-fields input[type="url"],
trix-toolbar .trix-dialog__link-fields input[type="text"] {
    background: rgba(250, 235, 215, 0.05) !important;
    border: 1px solid rgba(250, 235, 215, 0.2) !important;
    color: #FAEBD7 !important;
    padding: 0.5rem !important;
    border-radius: 6px !important;
    font-size: 0.875rem !important;
}

trix-toolbar .trix-dialog__link-fields input:focus {
    outline: none;
    border-color: rgba(250, 235, 215, 0.4) !important;
}

trix-toolbar .trix-button-group--file-tools {
    display: none !important; /* Hide file upload button if not needed */
}

/* Trix Editor Content Styling */
trix-editor {
    outline: none !important;
}

trix-editor:focus {
    border-color: rgba(250, 235, 215, 0.3) !important;
    box-shadow: 0 0 0 3px rgba(250, 235, 215, 0.1) !important;
}

trix-editor h1 {
    font-size: 2rem !important;
    font-weight: 700 !important;
    margin: 1rem 0 !important;
    color: #FAEBD7 !important;
}

trix-editor h2 {
    font-size: 1.5rem !important;
    font-weight: 600 !important;
    margin: 0.875rem 0 !important;
    color: #FAEBD7 !important;
}

trix-editor h3 {
    font-size: 1.25rem !important;
    font-weight: 600 !important;
    margin: 0.75rem 0 !important;
    color: #FAEBD7 !important;
}

trix-editor strong {
    font-weight: 700 !important;
    color: #FAEBD7 !important;
}

trix-editor em {
    font-style: italic !important;
    color: #FAEBD7 !important;
}

trix-editor a {
    color: #60a5fa !important;
    text-decoration: underline !important;
}

trix-editor a:hover {
    color: #93c5fd !important;
}

trix-editor ul,
trix-editor ol {
    margin: 0.5rem 0 !important;
    padding-left: 1.5rem !important;
    color: #FAEBD7 !important;
}

trix-editor li {
    margin: 0.25rem 0 !important;
    color: #FAEBD7 !important;
}

trix-editor blockquote {
    border-left: 4px solid rgba(250, 235, 215, 0.3) !important;
    margin: 1rem 0 !important;
    padding: 0.5rem 1rem !important;
    background: rgba(250, 235, 215, 0.05) !important;
    color: #ccc !important;
}

trix-editor pre {
    background: #0a0a0a !important;
    border: 1px solid rgba(250, 235, 215, 0.2) !important;
    border-radius: 6px !important;
    padding: 1rem !important;
    margin: 1rem 0 !important;
    overflow-x: auto !important;
    color: #FAEBD7 !important;
    font-family: ui-monospace, monospace !important;
}

trix-editor code {
    background: rgba(250, 235, 215, 0.1) !important;
    padding: 0.125rem 0.25rem !important;
    border-radius: 3px !important;
    color: #60a5fa !important;
    font-family: ui-monospace, monospace !important;
    font-size: 0.875em !important;
}

/* Placeholder styling */
trix-editor:empty:not(:focus)::before {
    color: #666 !important;
}

/* Selection styling */
trix-editor ::selection {
    background: rgba(250, 235, 215, 0.2) !important;
}
</style>
