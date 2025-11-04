@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!--==========================  Blog Details Section Start  ==========================-->
    <div class="blog-details section-bg-2 py-120">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-xl-9">
                    <div class="blog-details__inner">
                        <div class="blog-details__thumb">
                            <img src="{{ getImage(getFilePath('blog') . '/' . $blog->data_values->blog_image) }}"
                                class="fit--img" alt="@lang('blog-image')">
                        </div>
                        <div class="blog-details__body">
                            <span class="blog-details__date"><i class="ti ti-calendar-month"></i>
                                {{ showDateTime($blog->created_at, 'd M Y') }}</span>
                            <h3 class="blog__title">{{ __($blog->data_values->title) }}</h3>
                            @php
                                $words = str_word_count($blog->data_values->description, 1);
                                $halfway = ceil(count($words) / 2);
                                $wordCount = 0;
                                $output = '';
                                $inserted = false;
                                foreach (explode(' ', $blog->data_values->description) as $word) {
                                    $output .= $word . ' ';
                                    $wordCount++;
                                    if ($wordCount == $halfway && !$inserted) {
                                        $output .= '<blockquote>' . __($blog->data_values->quote) . '</blockquote>';
                                        $inserted = true;
                                    }
                                }
                            @endphp
                            <div class="blog-details__content wyg">
                                @php echo $output; @endphp
                            </div>
                            <div class="blog-details__social pt-60">
                                <p class="social-list__title"><i class="fa-solid fa-share-nodes text--base"></i>
                                    @lang('Share This post')
                                </p>
                                <ul class="social-list">
                                    <li class="social-list__item">
                                        <a href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{ slug($blog->data_values->title) }}"
                                            class="social-list__link flex-center" target="_blank">
                                            <i class="fa-brands fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ slug($blog->data_values->title) }}&source=behands"
                                            class="social-list__link flex-center" target="_blank">
                                            <i class="fa-brands fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="https://twitter.com/intent/tweet?status={{ slug($blog->data_values->title) }}+{{ Request::url() }}"
                                            class="social-list__link flex-center" target="_blank">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a href="https://pinterest.com/pin/create/button/?url={{ Request::url() }}&description={{ slug($blog->data_values->title) }}"
                                            class="social-list__link flex-center" target="_blank">
                                            <i class="fa-brands fa-pinterest-p"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="post-sidebar">
                        <form class="post-sidebar__search" action="{{ route('blog') }}" method="GET">
                            <div class="input--group">
                                <input type="text" class="form--control" placeholder="@lang('Search')"
                                    value="{{ request()->search }}" placeholder="@lang('Search by blog title')" name="search">
                                <button type="submit" class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>

                        <div class="post-sidebar__card">
                            <h5 class="post-sidebar__card-title">@lang('Latests Posts')</h5>
                            <div class="post-sidebar__card-body">
                                <div class="recent-post">
                                    @foreach ($latests as $item)
                                        <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}"
                                            class="recent-post__item">
                                            <div class="recent-post__thumb">
                                                <img src="{{ getImage(getFilePath('blog') . 'thumb_' . $item->data_values->blog_image) }}"
                                                    alt="@lang('blog-image')">
                                            </div>
                                            <div class="recent-post__body">
                                                @if (strlen(__($item->data_values->title)) > 22)
                                                    {{ substr(__($item->data_values->title), 0, 22) . '...' }}
                                                @else
                                                    {{ __($item->data_values->title) }}
                                                @endif
                                                <span>{{ showDateTime($item->created_at) }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==========================  Blog Details Section End  ==========================-->
@endsection
