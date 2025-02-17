@extends('website.app')
@section('content')
    <main class="main">

        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
            <div class="container position-relative">
                <h1>Publications</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="current">Publications</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Pricing Section -->
        <section id="pricing" class="pricing section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Publications</h2>
                <p>Choose what download you want</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row g-4 justify-content-center">

                    <!-- Standard Plan -->
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="pricing-card popular">
                            <div class="popular-badge">2025</div>
                            <h3>Proposal</h3>
                            <p class="description">Have a glimpse of what we have for you in this year's expo e.g the sponsorship packages and their entire suits of benefits, which guests we shall and specific activities and look at the map of the expo ground</p>


                            <a href="/download" class="btn btn-light">
                                Download
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>


                </div>

            </div>

        </section><!-- /Pricing Section -->

        <!-- Call To Action Section -->


    </main>
@endsection
