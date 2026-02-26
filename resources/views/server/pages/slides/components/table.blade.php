@foreach ($slides as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->tieude }}</td>
        <td>{{ $item->hinhthunho }}</td>
        <td>{{ $item->stt }} </td>
        <td>{{ $item->linklienket }} </td>
        <td>{{ $item->mota }} </td>
        @if ($item->trangthai === 1)
            <td class="badge bg-success">Hiển thị</td>
        @elseif($item->trangthai === 2)
            <td class="badge bg-warning">Ẩn</td>
        @endif
        <td>
            <div class="action-buttons-inline" style="display: flex; gap: 8px; align-items: center;">
                <a href="{{ route('slides.show', $item->id) }}" class="btn btn-action btn-info">Xem chi tiết</a>
                <a href="{{ route('slides.edit', $item->id) }}" class="btn btn-action btn-edit">Sửa</a>
                <form action="{{ route('slides.delete', $item->id) }}" method="POST" style="margin: 0;"
                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa slide này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-md">Xóa</button>
                </form>
                <form action="{{ route('slides.restore', $item->id) }}" method="POST" style="margin: 0;"
                    onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục slide này?')">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary btn-md">Khôi phục</button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
