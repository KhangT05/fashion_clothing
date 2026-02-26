  <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
          <ul class="nav metismenu" id="side-menu">
              <li class="nav-header">
                  <div class="dropdown profile-element"> <span>
                          <img alt="image" class="img-circle" src="{{ asset('server/img/profile_small.jpg') }}" />
                      </span>
                      <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David
                                      Williams</strong>
                              </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
                          </span> </a>
                      <ul class="dropdown-menu animated fadeInRight m-t-xs">
                          <li><a href="profile.html">Profile</a></li>
                          <li><a href="contacts.html">Contacts</a></li>
                          <li><a href="mailbox.html">Mailbox</a></li>
                          <li class="divider"></li>
                          <li><a href="{{ route('auth.logout') }}">Đăng xuất</a></li>
                      </ul>
                  </div>
                  <div class="logo-element">
                      IN+
                  </div>
              </li>
              @foreach (config('menu.module') as $key => $val)
                  <li class="{{ isset($val['class']) ? $val['class'] : '' }}"> {{-- SỬA DÒNG NÀY --}}
                      <a href="{{ isset($val['route']) && Route::has($val['route']) ? route($val['route']) : '#' }}">
                          {{-- KẾT THÚC SỬA --}}

                          <i class="{{ $val['icon'] }}"></i>
                          <span class="nav-label">{{ $val['title'] }}</span>

                          {{-- Chỉ hiện mũi tên nếu có menu con --}}
                          @if (isset($val['children']) && count($val['children']) > 0)
                              <span class="fa arrow"></span>
                          @endif
                      </a>

                      @if (isset($val['children']) && count($val['children']) > 0)
                          <ul class="nav nav-second-level">
                              @foreach ($val['children'] as $children)
                                  <li>
                                      {{-- KIỂM TRA: Nếu route tồn tại thì in link, nếu không thì in dấu # --}}
                                      <a
                                          href="{{ isset($children['route']) && Route::has($children['route']) ? route($children['route']) : '#' }}">
                                          {{ $children['title'] }}
                                      </a>
                                  </li>
                              @endforeach
                          </ul>
                      @endif
                  </li>
              @endforeach
          </ul>

      </div>
  </nav>
