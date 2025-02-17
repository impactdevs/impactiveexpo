@extends('website.app')
@section('content')
    <main class="main">
        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
            <div class="container position-relative">
                <h1>News</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="current">News</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Blog Posts 2 Section -->
        <section id="blog-posts-2" class="blog-posts-2 section">

            <div class="container">
                <div class="row gy-4">
                    @foreach ($news as $item)
                        <div class="col-lg-4">
                            <article class="position-relative h-100">

                                <div class="post-img position-relative overflow-hidden">
                                    <img src="assets/img/blog/blog-1.jpg" class="img-fluid" alt="">
                                </div>

                                <div class="meta d-flex align-items-end">
                                    <span class="post-date"><span>{{ $item->created_at->format('d') }}
                                        </span>{{ $item->created_at->format('F') }}
                                    </span>
                                    <div class="d-flex align-items-center">
                                        {{-- <i class="bi bi-person"></i> <span class="ps-2">John Doe</span> --}}
                                    </div>
                                    <span class="px-3 text-black-50">/</span>
                                    <div class="d-flex align-items-center">
                                        {{-- <i class="bi bi-folder2"></i> <span class="ps-2">Politics</span> --}}
                                    </div>
                                </div>

                                <div class="post-content d-flex flex-column">

                                    <h3 class="post-title">{{ $item->title }}</h3>
                                    <a href="/news-detail/{{ $item->id }}" class="readmore stretched-link"><span>Read
                                            More</span><i class="bi bi-arrow-right"></i></a>

                                </div>

                            </article>
                        </div><!-- End post list item -->
                    @endforeach

                </div>
            </div>

        </section><!-- /Blog Posts 2 Section -->

        <!-- Blog Pagination Section -->
        <section id="blog-pagination" class="blog-pagination section">
            <div class="container">
                <div class="d-flex justify-content-center">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        <li class="page-item @if ($news->onFirstPage()) disabled @endif">
                            <a class="page-link" href="{{ $news->previousPageUrl() }}">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>

                        {{-- Page Number Links --}}
                        @foreach ($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                            <li class="page-item @if ($page == $news->currentPage()) active @endif">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        <li class="page-item @if (!$news->hasMorePages()) disabled @endif">
                            <a class="page-link" href="{{ $news->nextPageUrl() }}">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </section><!-- /Blog Pagination Section -->


    </main>
@endsection
