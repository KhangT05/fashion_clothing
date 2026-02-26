      <nav class="bg-white/80 top-0 z-50 shadow-md relative">
          <div class="container mx-auto px-4">
              <div class="flex justify-between items-center py-3">
                  <a href="{{ route('layouts') }}" class=" text-2xl font-bold">
                      e<span class="font-extrabold">Thời trang</span>
                  </a>
                  <form method="GET" action="{{ route('client.products.index') }}" class="position-relative">
                      <div class="input-group">
                          <input type="text" id="search-input" autocomplete="off" class="form-control"
                              value="{{ request('keyword') }}" placeholder="Nhập từ khóa tìm kiếm..." name="keyword" />
                          <button class="btn btn-primary" type="submit">
                              <i class="fa fa-search"></i>
                          </button>
                      </div>
                      <div id="search-results" class="list-group position-absolute w-100 shadow-lg d-none"
                          style="z-index: 1000; max-height: 400px; overflow-y: auto; top: 100%;">
                      </div>
                  </form>
                  <ul class="flex gap-2 items-center">
                      <li>
                          <a href="{{ route('layouts') }}"
                              class="font-medium uppercase hover:text-[#667eea] transition">
                              Trang chủ
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('gioi-thieu') }}"
                              class="font-medium uppercase hover:text-[#667eea] transition">
                              Giới thiệu
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('client.products.index') }}"
                              class="font-medium uppercase hover:text-[#667eea] transition">
                              Sản Phẩm
                          </a>
                      </li>
                      <li><a href="{{ route('client.profile.index') }}"
                              class="font-medium uppercase hover:text-[#667eea] transition">Tài
                              khoản</a></li>
                      <li><a href="{{ route('blog') }}"
                              class="font-medium uppercase hover:text-[#667eea] transition">Tin tức</a>
                      </li>
                      <li>
                          <a href="{{ route('contact') }}"
                              class="font-medium uppercase hover:text-[#667eea] transition">
                              Liên hệ
                          </a>
                      </li>
                      <li>
                          @if (Auth::check())
                              <div class="relative">
                                  <button id="accountBtn"
                                      class="font-medium uppercase hover:text-[#667eea] 
                                        transition flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100">
                                      <i class="fa fa-user"></i>
                                      <span>Tài khoản</span>
                                  </button>
                                  <div id="accountDropdown" style="display: none;"
                                      class="absolute right-0 mt-2 w-56 
                                        bg-white rounded-lg shadow-2xl border border-gray-100 overflow-hidden">
                                      <div class="px-4 py-3 ">
                                          <p class="text-xs opacity-90 mb-1">Chào mừng</p>
                                          <p class="font-semibold truncate">{{ Auth::user()->name }}</p>
                                      </div>
                                      <a href="{{ route('client.profile.index') }}"
                                          class="block px-4 py-2 text-sm hover:bg-gray-100 transition">
                                          <i class="fa fa-user mr-2"></i>Thông tin
                                      </a>
                                      <a href="{{ route('auth.logout') }}"
                                          class="block px-4 py-2 text-sm hover:bg-gray-100 transition">
                                          <i class="fa-solid fa-right-from-bracket mr-2"></i>Đăng xuất
                                      </a>
                                  </div>
                              </div>
                          @else
                              <button type="button"
                                  class="font-medium uppercase hover:text-[#667eea] transition flex items-center gap-1"
                                  data-bs-toggle="modal" data-bs-target="#exampleModal">
                                  <i class="fa fa-user"></i>
                                  <span>Tài khoản</span>
                              </button>
                          @endif
                      </li>
                      <li class="cart-wrapper">
                          @include('client.components.badge-carts')
                      </li>
                  </ul>
              </div>
          </div>
      </nav>
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-sm">
              <div class="modal-content account-modal">
                  <div class="modal-body text-center">
                      <button type="button" class="btn btn-login w-100 mb-3" id="btn-login">
                          Đăng nhập
                      </button>
                      <button type="button" class="btn btn-register w-100" id="btn-register">
                          Đăng ký
                      </button>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-header border-0">
                      <h5 class="modal-title w-100 text-center">Đăng nhập</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body px-4">
                      <form class="m-t" method="POST" action="{{ route('login') }}" id="loginForm">
                          @csrf
                          <div class="form-group">
                              <label class="text-center">Email</label>
                              <input type="email" name="email"
                                  class="form-control @error('email') is-invalid @enderror"
                                  placeholder="Nhập email của bạn" required="" value="{{ old('email') }}">
                          </div>
                          @error('email')
                              <div class="alert alert-danger">*{{ $message }}</div>
                          @enderror
                          <div class="form-group">
                              <label>Mật khẩu</label>
                              <input type="password" name="password"
                                  class="form-control @error('password') is-invalid @enderror"
                                  placeholder="Nhập mật khẩu" required="">
                          </div>
                          @error('password')
                              <div class="alert alert-danger">*{{ $message }}</div>
                          @enderror
                          <button type="submit" class="btn btn-primary block full-width m-b">Đăng
                              nhập</button>
                          <p class="text-muted text-center">
                              <small>Bạn chưa có tài khoản thành viên?</small>
                          </p>
                          <a href="#" id="switchToRegister" class="btn btn-sm btn-white btn-block">
                              Tạo tài khoản mới
                          </a>
                      </form>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                  <div class="modal-header border-0">
                      <h5 class="modal-title w-100 text-center">Đăng ký thành viên</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body px-4">
                      <form class="m-t" role="form" action="{{ route('auth.register') }}" method="POST">
                          @csrf
                          <div class="form-group">
                              <label>Họ và tên</label>
                              <input type="text" class="form-control @error('email') is-invalid @enderror"
                                  value="{{ old('name') }}" placeholder="Nhập họ tên của bạn" name="name"
                                  required="">
                          </div>
                          @error('name')
                              <div class="alert alert-danger">*{{ $message }}</div>
                          @enderror
                          <div class="form-group">
                              <label>Email</label>
                              <input type="email" name="email"
                                  class="form-control @error('email') is-invalid @enderror" placeholder="Nhập email"
                                  required="" value="{{ old('email') }}">
                          </div>
                          @error('email')
                              <div class="alert alert-danger">*{{ $message }}</div>
                          @enderror
                          <div class="form-group">
                              <label>Mật khẩu</label>
                              <input type="password" name="password"
                                  class="form-control @error('password') is-invalid @enderror"
                                  placeholder="Nhập mật khẩu" required="">
                          </div>
                          @error('password')
                              <div class="alert alert-danger">*{{ $message }}</div>
                          @enderror
                          <button type="submit" class="btn btn-primary block full-width m-b">Đăng
                              ký</button>
                          <p class="text-muted text-center"><small>Bạn đã có tài
                                  khoản?</small></p>
                          <a href="#" id="switchToLogin" class="btn btn-sm btn-white btn-block">Đăng nhập
                              ngay</a>
                      </form>
                  </div>
              </div>
          </div>
      </div>
