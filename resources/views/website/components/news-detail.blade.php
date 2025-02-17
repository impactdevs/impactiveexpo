@extends('website.app')
@section('content')
    <main class="main">

        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
            <div class="container position-relative">
                <h1>New Details</h1>
                <p>{{ $details->title }}</p>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index.html">Home</a></li>
                        <li class="current">New Details</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <div class="container">
            <div class="row">

                <div class="col-lg-8">

                    <!-- Blog Details Section -->
                    <section id="blog-details" class="blog-details section">
                        <div class="container">

                            <article class="article">

                                <div class="post-img">
                                    <img src="assets/img/blog/blog-1.jpg" alt="" class="img-fluid">
                                </div>

                                <h2 class="title">{{ $details->title }}</h2>

                                <div class="content">
                                    {!! $details->content !!}

                                </div><!-- End post content -->

                            </article>

                        </div>
                    </section><!-- /Blog Details Section -->

                </div>

                <div class="col-lg-4 sidebar">

                    <div class="widgets-container">

                        <!-- Recent Posts Widget 2 -->
                        <div class="recent-posts-widget-2 widget-item">

                            <h3 class="widget-title">Recent Posts</h3>
                            @foreach ($recent as $item)
                                <div class="post-item">
                                    <h4><a href="/news-detail/{{ $item->id }}">{{ $item->title }}</a></h4>
                                    <time datetime="2020-01-01">{{ $item->created_at }}</time>
                                </div><!-- End recent post item-->
                            @endforeach
                        </div><!--/Recent Posts Widget 2 -->

                    </div>

                </div>

            </div>
        </div>

    </main>
@endsection
