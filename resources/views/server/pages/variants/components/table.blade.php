@foreach ($products as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->tensp }}</td>
        <td>{{ $item->giaban }}</td>
        <td>{{ $item->discount }} </td>
        <td>{{ $item->soluong }} </td>
        @if ($item->trangthai === 1)
            <td class="badge bg-success">Còn hàng</td>
        @elseif($item->trangthai === 2)
            <td class="badge bg-warning">Hết hàng</td>
        @endif
        <td>
            <div class="action-buttons-inline" style="display: flex; gap: 8px; align-items: center;">
                <a href="{{ route('products.show', $item->id) }}" class="btn btn-action btn-info">Xem chi tiết</a>
                <a href="{{ route('products.edit', $item->id) }}" class="btn btn-action btn-edit">Sửa</a>
                <form action="{{ route('products.delete', $item->id) }}" method="POST" style="margin: 0;"
                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-md">Xóa</button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
