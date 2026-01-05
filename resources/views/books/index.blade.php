@extends('layouts.guest')

@section('title', 'Books')

@section('content')
    {{-- ===== 頁首 + 搜尋 ===== --}}
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Books</h1>

        {{-- GET 搜尋：?q=關鍵字 --}}
        <form method="GET" action="{{ route('books.index') }}" class="flex gap-2">
            <input
                name="q"
                value="{{ $q }}"
                placeholder="搜尋書名 / 作者 / ISBN"
                class="w-72 rounded border-gray-300"
            >
            <button class="px-4 py-2 rounded bg-black text-white" type="submit">搜尋</button>
        </form>
    </div>

    {{-- ===== 無資料提示 ===== --}}
    @if($books->count() === 0)
        <div class="bg-white p-6 rounded border">
            目前沒有書籍資料
        </div>
    @else
        {{-- ===== 書籍表格 ===== --}}
        <div class="bg-white rounded border overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left p-3">書名</th>
                        <th class="text-left p-3">作者</th>
                        <th class="text-left p-3">ISBN</th>
                        <th class="text-left p-3">可借副本</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                        <tr class="border-t">
                            <td class="p-3 font-medium">{{ $book->title }}</td>
                            <td class="p-3">{{ $book->author }}</td>
                            <td class="p-3">{{ $book->isbn }}</td>
                            <td class="p-3">
                                @if($book->available_copies_count > 0)
                                    <span class="px-2 py-1 rounded bg-green-100 text-green-800">
                                        {{ $book->available_copies_count }} 可借
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded bg-gray-100 text-gray-700">
                                        0（不可借）
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ===== 分頁 ===== --}}
        <div class="mt-4">
            {{ $books->links() }}
        </div>
    @endif
@endsection
