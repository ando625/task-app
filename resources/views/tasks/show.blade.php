<x-app-layout>
    <x-slot name="title">{{ $task->title }}</x-slot>

    <div class="bg-white rounded-lg shadow-md p-6">
        {{-- ヘッダー --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ $task->title }}</h1>
            <a href="{{ route('tasks.index') }}" class="text-blue-500 hover:text-blue-600">
                ← 一覧に戻る
            </a>
        </div>

        {{-- タスク情報 --}}
        <div class="space-y-4">
            <div>
                <span class="text-gray-500 text-sm">カテゴリー</span>
                <p class="text-gray-800">{{ $task->category->name ?? '未分類' }}</p>
            </div>

            <div>
                <span class="text-gray-500 text-sm">優先度</span>
                <div class="flex items-center">
                    <span class="px-2 py-1 text-sm rounded 
                        @if($task->priority === 3) bg-red-100 text-red-800
                        @elseif($task->priority === 2) bg-yellow-100 text-yellow-800
                        @else bg-green-100 text-green-800
                        @endif">
                        @if($task->priority === 3) 高
                        @elseif($task->priority === 2) 中
                        @else 低
                        @endif
                    </span>
                </div>

                {{-- ★追加：進捗度（ステータス）表示 --}}
                <span class="px-2 py-1 text-xs rounded font-medium
                        @if($task->status === 'completed') bg-gray-100 text-gray-700
                        @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                        @else bg-purple-100 text-purple-800
                        @endif">
                        @if($task->status === 'completed') 完了
                        @elseif($task->status === 'in_progress') 進行中
                        @else 未着手
                        @endif
                </span>
                
                {{-- ★追加：期限表示 --}}
                @if($task->due_at)
                <span class="text-xs text-gray-500 flex items-center">
                    📅 期限：{{ \Carbon\Carbon::parse($task->due_at)->format('Y/m/d H:i') }}
                </span>
                @else
                <span class="text-xs text-gray-400">
                    📅 期限なし
                </span>
                @endif
            </div>

            <div>
                <span class="text-gray-500 text-sm">説明</span>
                <p class="text-gray-800 whitespace-pre-wrap">{{ $task->description ?? '説明はありません' }}</p>
            </div>

            <div>
                <span class="text-gray-500 text-sm">登録日</span>
                <p class="text-gray-800">{{ $task->created_at->format('Y年m月d日') }}</p>
            </div>
        </div>

        {{-- アクションボタン --}}
        <div class="flex space-x-4 mt-8 pt-6 border-t border-gray-200">
            @can('update',$task)
            <a href="{{ route('tasks.edit', $task) }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                編集
            </a>
            @endcan
            @can('delete',$task)
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                    削除
                </button>
            </form>
            @endcan
        </div>
    </div>
</x-app-layout>