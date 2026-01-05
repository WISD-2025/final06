@extends('layouts.guest')

@section('title', $book->title)

@section('content')
    {{-- 返回列表 --}}
    <div class="mb-4">
        <a href="{{ route('books.index') }}" class="text-sm hover:underline">← 回書籍列表</a>
    </div>

    {{-- 書籍基本資訊 --}}
    <div class="bg-white border rounded p-6 mb-6">
        <h1 class="text-2xl font-semibold mb-2">{{ $book->title }}</h1>

        <div class="text-sm text-gray-700 space-y-1">
            <div><span class="font-medium">作者：</span>{{ $book->author }}</div>
            <div><span class="font-medium">ISBN：</span>{{ $book->isbn }}</div>
            <div><span class="font-medium">出版年：</span>{{ $book->published_year }}</div>
        </div>

        <div class="mt-4">
            {{-- 可借副本數 --}}
            @if($availableCount > 0)
                <span class="px-2 py-1 rounded bg-green-100 text-green-800 text-sm">
                    {{ $availableCount }} 可借
                </span>
            @else
                <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 text-sm">
                    0（不可借）
                </span>
            @endif
        </div>
    </div>

    {{-- 副本清單 --}}
    <div class="bg-white border rounded overflow-hidden">
        <div class="px-6 py-4 border-b font-semibold">館藏副本</div>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="text-left p-3">條碼</th>
                    <th class="text-left p-3">狀態</th>
                </tr>
            </thead>
            <tbody>
                @forelse($book->bookCopies as $copy)
                    <tr class="border-t">
                        <td class="p-3 font-medium">{{ $copy->barcode }}</td>
                        <td class="p-3">
                            @if($copy->status === 'available')
                                <span class="px-2 py-1 rounded bg-green-100 text-green-800">available</span>
                            @elseif($copy->status === 'loaned')
                                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">loaned</span>
                            @else
                                <span class="px-2 py-1 rounded bg-gray-100 text-gray-700">{{ $copy->status }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-3 text-gray-500" colspan="2">目前沒有副本資料</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
