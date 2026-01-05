<x-layouts.app :title="__('我的借閱紀錄')">
    <div class="p-6 space-y-4">
        <h1 class="text-2xl font-bold">我的借閱紀錄</h1>

        <div class="overflow-x-auto">
            <table class="w-full border">
                <thead>
                    <tr class="border-b">
                        <th class="p-2 text-left">條碼</th>
                        <th class="p-2 text-left">書名</th>
                        <th class="p-2 text-left">借出日</th>
                        <th class="p-2 text-left">到期日</th>
                        <th class="p-2 text-left">歸還日</th>
                        <th class="p-2 text-left">狀態</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr class="border-b">
                            <td class="p-2">{{ $loan->copy->barcode }}</td>
                            {{-- 書名：可點進書籍詳情 /books/{id} --}}
                            <td class="px-4 py-2">
                                <a class="hover:underline"
                                href="{{ route('books.show', $loan->copy->title->id) }}">
                                    {{ $loan->copy->title->title }}
                                </a>
                            </td>
                            <td class="p-2">{{ $loan->loan_date }}</td>
                            <td class="p-2">{{ $loan->due_date }}</td>
                            <td class="px-4 py-2">
                                {{ $loan->return_date ?? '-' }}
                            </td>
                            <td class="p-2">
                                @php
                                    // 逾期：借閱中 且 due_date 已經過了今天
                                    $isOverdue = !$loan->return_date
                                        && $loan->due_date
                                        && \Illuminate\Support\Carbon::parse($loan->due_date)->isPast();
                                @endphp

                                @if($loan->return_date)
                                    <span class="px-2 py-1 rounded bg-green-100 text-green-800 text-sm">已歸還</span>
                                @else
                                    <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-sm">借閱中</span>

                                    @if($isOverdue)
                                        <span class="ml-2 px-2 py-1 rounded bg-red-100 text-red-800 text-sm">逾期</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-2" colspan="6">目前沒有借閱紀錄。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
