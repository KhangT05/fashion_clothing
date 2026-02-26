@foreach ($comment as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->tieude }}</td>
        <td>{{ $item->hinhthunho }}</td>
        <td>{{ $item->stt }} </td>
        <td>{{ $item->linklienket }} </td>
        <td>{{ $item->mota }} </td>
        @if ($item->trangthai === 1)
            <td class="badge bg-success">Còn hàng</td>
        @elseif($item->trangthai === 0)
            <td class="badge bg-warning">Hết hàng</td>
        @endif
        <td>
            <div class="action-buttons-inline" style="display: flex; gap: 8px; align-items: center;">
                <a href="{{ route('slides.show', $item->id) }}" class="btn btn-action btn-info">Xem chi tiết</a>
                <a href="{{ route('slides.edit', $item->id) }}" class="btn btn-action btn-edit">Sửa</a>
                <form action="{{ route('slides.delete', $item->id) }}" method="POST" style="margin: 0;"
                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-md">Xóa</button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
