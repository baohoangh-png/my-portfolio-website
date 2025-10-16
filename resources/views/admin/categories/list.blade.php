        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Tên loại</th>
                    <th>Mô tả</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                    <tr>

                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $item->catename }} ({{ $item->products->count() }} sản phẩm)
                            <button class="btn btn-sm btn-link p-0 ms-2" data-bs-toggle="collapse"
                                data-bs-target="#r{{ $loop->index }}" aria-expanded="false"
                                aria-controls="r{{ $loop->index }}">
                                ▼
                            </button>
                        </td>
                        <td>{{ $item->description }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('cate.edit', $item->cateid) }}" class="btn btn-warning mx-1">sửa</a>
                                <form action="{{ route('cate.delete', $item->cateid) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger mx-1">xóa</button>
                                </form>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#confirmdelete" data-info="{{ $item->catename }}"
                                    data-action="{{ route('cate.delete', $item->cateid) }}">
                                    Xóa (modal)
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr id="r{{ $loop->index }}" class="collapse">
                        <td colspan="3">
                            <ul class="mb-0">
                                @forelse ($item->products as $pro)
                                    <li>{{ $pro->proname }}</li>
                                @empty
                                    <li><em>Không có sản phẩm nào</em></li>
                                @endforelse
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $list->links('pagination::bootstrap-4') }}
