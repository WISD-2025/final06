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
                            <td class="p-2">{{ $loan->copy->title?->title ?? '（未知書名）' }}</td>
                            <td class="p-2">{{ $loan->loan_date }}</td>
                            <td class="p-2">{{ $loan->due_date }}</td>
                            <td class="p-2">{{ $loan->return_date ?? '-' }}</td>
                            <td class="p-2">{{ $loan->return_date ? '已歸還' : '借閱中' }}</td>
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
