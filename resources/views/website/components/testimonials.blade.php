@extends('website.app')
@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
      <div class="container position-relative">
        <h1>Expo Guests</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="current">Guests</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Testimonials Section -->
    <section class="testimonials-12 testimonials section" id="testimonials">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>GUEST LIST FOR IMPACTIVE BUBU EXPO 2025</h2>
            <p>Don't miss out on the following guests.</p>
        </div><!-- End Section Title -->

        <div class="testimonial-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-4">
                        <div class="testimonial">
                            <img src="{{ asset('assets/img/testimonials/museveni.jpg') }}"
                                alt="Testimonial author">
                            <blockquote>
                                <p>
                                    “On Day-1, H.E Yoweri Kaguta Museveni will visit exhibition stalls and give the opening
                                    ceremony speech.”
                                </p>
                            </blockquote>
                            <p class="client-name">H.E Yoweri Kaguta Museveni</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 mb-md-4">
                        <div class="testimonial">
                            <img src="{{ asset('assets/img/testimonials/mebesa.jpg') }}"
                                alt="Testimonial author">
                            <blockquote>
                                <p>
                                    “On day 1, Hon Min. Mwebesa Francis will give speeches from the stakeholders.”
                                </p>
                            </blockquote>
                            <p class="client-name">Hon. Mwebesa Francis</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 mb-md-4">
                        <div class="testimonial">
                            <img src="{{ asset('assets/img/testimonials/jeje.jpg') }}"
                                alt="Testimonial author">
                            <blockquote>
                                <p>
                                    “On Day 2, the minister of foreign affairs will give a dialog on how to improve quality,
                                    and adding value to Ugandan made products.”
                                </p>
                            </blockquote>
                            <p class="client-name">Hon Gen Odongo Jeje Abubakher</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 mb-md-4">
                        <div class="testimonial">
                            <img src="{{ asset('assets/img/testimonials/anita.jpg') }}"
                                alt="Testimonial author">
                            <blockquote>
                                <p>
                                    “On Day 3, the speaker of parliament will give a dialog on how to leverage on the
                                    growing power of women in Business”
                                </p>
                            </blockquote>
                            <p class="client-name">Hon. Anita Among</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 mb-md-4">
                        <div class="testimonial">
                            <img src="{{ asset('assets/img/testimonials/robinah.jpg') }}"
                                alt="Testimonial author">
                            <blockquote>
                                <p>
                                    “On Day 3, the prime minister of uganda will preside over awards in: Excellence in
                                    quality, Value addition, Export and Bast exhibitors in different sectors”
                                </p>
                            </blockquote>
                            <p class="client-name">Hon. Robinah Nabanja</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Testimonials Section -->


  </main>
  @endsection
