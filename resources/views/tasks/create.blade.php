<x-app-layout>
    <x-slot name="title">タスク登録</x-slot>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">タスク登録</h1>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            {{-- タイトル --}}
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">タイトル</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- カテゴリー --}}
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-medium mb-2">カテゴリー</label>
                <select name="category_id" id="category_id"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                    <option value="">選択してください</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 優先度 --}}
            <div class="mb-4">
                <label for="priority" class="block text-gray-700 font-medium mb-2">優先度</label>
                <select name="priority" id="priority"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                    <option value="1" {{ old('priority')==1 ? 'selected' : '' }}>低</option>
                    <option value="2" {{ old('priority')==2 ? 'selected' : '' }}>中</option>
                    <option value="3" {{ old('priority')==3 ? 'selected' : '' }}>高</option>
                </select>
                @error('priority')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ★追加：期限 --}}
            <div class="mb-4">
                <label for="due_at" class="block text-gray-700 font-medium mb-2">期限</label>
                <input type="datetime-local" name="due_at" id="due_at" value="{{ old('due_at') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                @error('due_at')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ★追加：進捗度（ステータス） --}}
            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-medium mb-2">進捗度</label>
                <select name="status" id="status"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                    {{-- デフォルトは「未着手(todo)」を選択状態にする --}}
                    <option value="todo" {{ old('status', 'todo' )=='todo' ? 'selected' : '' }}>未着手</option>
                    <option value="in_progress" {{ old('status', 'todo' )=='in_progress' ? 'selected' : '' }}>進行中</option>
                    <option value="completed" {{ old('status', 'todo' )=='completed' ? 'selected' : '' }}>完了</option>
                </select>
                @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 説明 --}}
            <div class="mb-6">
                <label for="content" class="block text-gray-700 font-medium mb-2">説明</label>
                <textarea name="content" id="content" rows="5"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
                @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ボタン --}}
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    登録
                </button>
                <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    キャンセル
                </a>
            </div>
        </form>
    </div>
</x-app-layout>