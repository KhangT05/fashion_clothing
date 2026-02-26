@foreach ($products as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->tensp }}</td>
        <td>{{ number_format($item->giaban, 0, ',', '.') }} đ</td>
        <td>
            @if ($item->discount > 0)
                <span class="badge bg-danger">-{{ $item->discount }}%</span>
            @else
                <span class="text-muted">Không</span>
            @endif
        </td>
        <td>{{ $item->soluong }}</td>
        <td>
            @if ($item->trangthai == 2)
                <span class="badge bg-warning">Hết hàng</span>
            @elseif ($item->trangthai == 0)
                <span class="badge bg-danger">Đã xóa</span>
            @else
                <span class="badge bg-secondary">Khác</span>
            @endif
        </td>
        <td class="text-center">
            <form action="{{ route('products.restore', $item->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục sản phẩm {{ $item->tensp }}?')">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa fa-undo"></i> Khôi phục
                </button>
            </form>
        </td>
    </tr>
@endforeach
