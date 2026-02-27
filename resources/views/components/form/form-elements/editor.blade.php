@props([
  'name' => null,
  'id' => null,
  'value' => null,
  'minHeight' => '160px',
])

<div x-data="{ content: @js(old($name, $value ?? '')) }" class="rounded-lg border border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-900">
  <div class="flex items-center gap-1 border-b border-gray-200 p-2 dark:border-gray-700">
    <button type="button" class="rounded px-2 py-1 text-xs text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800" @click="document.execCommand('bold')"><strong>B</strong></button>
    <button type="button" class="rounded px-2 py-1 text-xs text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800" @click="document.execCommand('italic')"><em>I</em></button>
    <button type="button" class="rounded px-2 py-1 text-xs text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800" @click="document.execCommand('underline')"><u>U</u></button>
    <button type="button" class="rounded px-2 py-1 text-xs text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800" @click="document.execCommand('insertUnorderedList')">List</button>
  </div>

  <div
    contenteditable="true"
    class="w-full px-4 py-3 text-sm text-gray-900 focus:outline-none dark:text-white/90"
    style="min-height: {{ $minHeight }};"
    x-init="$el.innerHTML = content"
    @input="content = $el.innerHTML"
  ></div>

  <input type="hidden" name="{{ $name }}" id="{{ $id ?? $name }}" x-model="content" {{ $attributes }} />
</div>

