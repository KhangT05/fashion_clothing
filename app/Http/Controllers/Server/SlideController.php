<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use App\Http\Requests\Server\Slide\StoreSlideRequest;
use App\Http\Requests\Server\Slide\UpdateSlideRequest;
use App\Services\SlideService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SlideController extends Controller
{
    protected $slideService;
    public function __construct(SlideService $slideService)
    {
        $this->slideService = $slideService;
    }
    public function index(Request $request): View
    {
        $slides = $this->slideService->pagination($request);
        return view('server.pages.slides.index', compact(
            'slides'
        ));
    }
    public function create()
    {
        $slides = $this->slideService->index();
        return view('server.pages.slides.save', compact(
            'slides'
        ));
    }
    public function store(StoreSlideRequest $request)
    {
        $slide = $this->slideService->save($request);
        return redirect()->route('slides.index')->with('success', 'Thêm slide thành công');
    }
    public function show($id)
    {
        $slide = $this->slideService->findById($id);
        return view('server.pages.slides.show', compact(
            'slide'
        ));
    }
    public function edit($id): View
    {
        $slides = $this->slideService->findById($id);
        return view('server.pages.slides.update', compact(
            'slides'
        ));
    }
    public function update(UpdateSlideRequest $request, $id)
    {
        $slide = $this->slideService->save($request, $id);
        return redirect()->route('slides.index')->with('success', 'Cập nhật slide thành công');
    }
    public function delete($id)
    {
        $slide = $this->slideService->delete($id);
        return redirect()->route('slides.index')->with('success', 'Xóa slide thành công');
    }
    public function restore($id)
    {
        $slide = $this->slideService->restore($id);
        return redirect()->route('slides.index')->with('success', 'Cập nhật trạng thái slide thành công');
    }
}
