<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VariantController extends Controller
{

    // public function index(): View
    // {
    //     return view('server.pages.variants.index');
    // }
    // public function create(): View
    // {
    //     return view('server.pages.brands.index');
    // }
    // public function store(): View
    // {
    //     return view('server.pages.brands.index');
    // }
    public function index(): View
    {
        return view('server.pages.variants.index');
    }
    public function create() {}
    public function store() {}
    public function show($id) {}
    public function edit($id) {}
    public function update($id) {}
    public function delete($id) {}
}
