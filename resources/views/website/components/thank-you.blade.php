@extends('website.app')

@section('content')
<main class="main">

  <!-- Page Title -->
  <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
    <div class="container position-relative">
      <h1>Thank You</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="current">Thank You</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Thank You Section -->
  <section class="contact section">
    <div class="container" data-aos="fade">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h2 class="mb-4">Thank You for Contacting Us!</h2>
          <p class="mb-4">We have received your message and will get back to you shortly. In the meantime, feel free to explore more about our services or return to the home page.</p>
          <a href="/" class="btn btn-primary">Back to Home</a>
        </div>
      </div>
    </div>
  </section><!-- /Thank You Section -->

</main>
@endsection
