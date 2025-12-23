<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free Bootstrap Admin Template by Adminmart</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="{{asset('assets/css/styles.min.css')}}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!--  App Topstrip -->
    <div class="app-topstrip bg-dark py-3 px-4 w-100 d-lg-flex align-items-center justify-content-between">
      <div class="d-none d-sm-flex align-items-center justify-content-center gap-9 mb-3 mb-lg-0">
        <a class="d-flex justify-content-center" href="https://www.wrappixel.com/" target="_blank">
          <img src="../assets/images/logos/logo-adminmart.svg" alt="" width="150">
        </a>

        <div class="d-none d-xl-flex align-items-center gap-3 border-start border-white border-opacity-25 ps-9">
          <a target="_blank" href="https://adminmart.com/templates/bootstrap/"
            class="link-hover d-flex align-items-center gap-2 border-0 text-white lh-sm fs-4">
            <iconify-icon class="fs-6" icon="solar:window-frame-linear"></iconify-icon>
            Templates
          </a>
          <a target="_blank" href="https://adminmart.com/support/"
            class="link-hover d-flex align-items-center gap-2 border-0 text-white lh-sm fs-4">
            <iconify-icon class="fs-6" icon="solar:question-circle-linear"></iconify-icon>
            Help
          </a>
          <a target="_blank" href="https://adminmart.com/hire-us/"
            class="link-hover d-flex align-items-center gap-2 border-0 text-white lh-sm fs-4">
            <iconify-icon class="fs-6" icon="solar:case-round-linear"></iconify-icon>
            Hire Us
          </a>
        </div>
      </div>

      <div class="d-lg-flex align-items-center gap-3">
        <h3 class="text-linear-gradient mb-3 mb-lg-0 fs-3 text-uppercase text-center fw-semibold">Checkout Pro Version
        </h3>
        <div class="d-sm-flex align-items-center justify-content-center gap-8">
          <div class="d-flex align-items-center justify-content-center gap-8">
            <div class="dropdown d-flex">
              <a class="btn live-preview-drop fs-4 lh-sm btn-outline-primary rounded border-white border border-opacity-40 text-white d-flex align-items-center gap-2 px-3 py-2"
                href="javascript:void(0)" id="drop3" data-bs-toggle="dropdown" aria-expanded="false">
                Live Preview
                <iconify-icon class="fs-6" icon="solar:alt-arrow-down-linear"></iconify-icon>
              </a>
              <div class="dropdown-menu p-3 dropdown-menu-end dropdown-menu-animate-up overflow-hidden rounded"
                aria-labelledby="drop3">
                <div class="message-body">
                  <a target="_blank"
                    href="https://adminmart.com/product/modernize-bootstrap-5-admin-template/?ref=56#product-demo-section"
                    class="dropdown-item rounded fw-normal d-flex align-items-center gap-6">
                    <img src="../assets/images/svgs/bt-cat-icon.svg" width="20" alt="bootstrap" />
                    Bootstrap Version
                  </a>
                  <a target="_blank"
                    href="https://adminmart.com/product/modernize-angular-material-dashboard/?ref=56#product-demo-section"
                    class="dropdown-item rounded fw-normal d-flex align-items-center gap-6">
                    <img src="../assets/images/svgs/angular-cat-icon.svg" width="18" alt="angular" />
                    Angular Version
                  </a>
                  <a target="_blank"
                    href="https://adminmart.com/product/modernize-react-mui-dashboard-theme/?ref=56#product-demo-section"
                    class="dropdown-item rounded fw-normal d-flex align-items-center gap-6">
                    <img src="../assets/images/svgs/react-cat-icon.svg" width="18" alt="react" />
                    React Version
                  </a>
                  <a target="_blank"
                    href="https://adminmart.com/product/modernize-vuetify-vue-admin-dashboard/?ref=56#product-demo-section"
                    class="dropdown-item rounded fw-normal d-flex align-items-center gap-6">
                    <img src="../assets/images/svgs/vue-cat-icon.svg" width="18" alt="vue" />
                    VueJs Version
                  </a>
                  <a target="_blank"
                    href="https://adminmart.com/product/modernize-next-js-admin-dashboard/?ref=56#product-demo-section"
                    class="dropdown-item rounded fw-normal d-flex align-items-center gap-6">
                    <img src="../assets/images/svgs/next-cat-icon.svg" width="18" alt="next" />
                    NextJs Version
                  </a>
                  <a target="_blank"
                    href="https://adminmart.com/product/modernize-nuxt-js-admin-dashboard/?ref=56#product-demo-section"
                    class="dropdown-item rounded fw-normal d-flex align-items-center gap-6">
                    <img src="../assets/images/svgs/nuxt-cat-icon.svg" width="18" alt="nuxt" />
                    NuxtJs Version
                  </a>
                  <a target="_blank"
                    href="https://adminmart.com/product/modernize-tailwind-nextjs-dashboard-template/?ref=56#product-demo-section"
                    class="dropdown-item rounded fw-normal d-flex align-items-center gap-6">
                    <img src="../assets/images/svgs/tailwindcss.svg" width="18" alt="tailwind" />
                    Tailwind Version
                  </a>
                </div>
              </div>
            </div>
            <a target="_blank"
              class="get-pro-btn rounded btn btn-primary d-flex align-items-center gap-2 fs-4 border-0 px-3 py-2"
              href="https://adminmart.com/product/modernize-bootstrap-5-admin-template/?ref=56#product-demo-section">
              <iconify-icon class="fs-5" icon="solar:crown-linear"></iconify-icon>
              Get Pro
            </a>
          </div>
        </div>
      </div>

    </div>
    <!-- Sidebar Start -->
    @include('layouts.partials.sidebar')
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      @include('layouts.partials.navbar')
      <!--  Header End -->
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <!--  Row 1 -->
          @yield('content')

          <div class="py-6 px-6 text-center">
            <p class="mb-0 fs-4">Design and Developed by <a href="https://adminmart.com/" target="_blank"
                class="pe-1 text-primary text-decoration-underline">AdminMart.com</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/js/sidebarmenu.js')}}"></script>
  <script src="{{asset('assets/js/app.min.js')}}"></script>
  <script src="{{asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/libs/simplebar/dist/simplebar.js,')}}"></script>
  <script src="{{asset('assets/js/dashboard.js;')}}"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>