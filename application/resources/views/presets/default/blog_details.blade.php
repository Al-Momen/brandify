@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <!--==========================  Blog Details Section Start  ==========================-->
    <div class="blog__details my-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog__details__content">
                        <img src="{{ getImage(getFilePath('blog') . '/' . $blog->data_values->blog_image) }}"
                            alt="@lang('image')">
                        <div class="blog__date">
                            <span>
                                <i class="fa-regular fa-calendar"></i>
                                {{ showDateTime($blog->created_at, 'd M Y') }}
                            </span>
                        </div>
                        <h1>{{ __($blog->data_values->title) }}</h1>
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
                                    $output .= '<div class="blog__quote">' . __($blog->data_values->quote) . '</div>';
                                    $inserted = true;
                                }
                            }
                        @endphp
                        <div class="wyg">
                            @php echo $output; @endphp
                        </div>
                        <div class="blog__share">
                            <h6><i class="fa-solid fa-share-nodes"></i>@lang('Share This post')</h6>
                            <ul class="social__icon">
                                <li>
                                    <a href="https://www.facebook.com/share.php?u={{ Request::url() }}&title={{ slug($blog->data_values->title) }}"
                                        target="_blank">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title={{ slug($blog->data_values->title) }}&source=behands"
                                        target="_blank">
                                        <i class="fa-brands fa-x-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/intent/tweet?status={{ slug($blog->data_values->title) }}+{{ Request::url() }}"
                                        target="_blank">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://pinterest.com/pin/create/button/?url={{ Request::url() }}&description={{ slug($blog->data_values->title) }}" target="_blank">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="blog__sidebar">
                        <div class="card">
                            <div class="recent__blog__title">
                                <h4>@lang('Search')</h4>
                            </div>
                            <form action="{{ route('blog') }}" method="GET">
                                <div class="search__box">
                                    <input type="text" class="form-control" placeholder="@lang('Search')"
                                        value="{{ request()->search }}" placeholder="@lang('Search by blog title')" name="search">
                                    <button type="submit" class="btn"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="card mt-4">
                            <div class="recent__blog">
                                <div class="recent__blog__title">
                                    <h4>@lang('Recent Post')</h4>
                                </div>
                                <div class="recent__blog__wrap">
                                    @foreach ($latests as $item)
                                        <div class="recent__blog__single">
                                            <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                                                <img src="{{ getImage(getFilePath('blog') . 'thumb_' . $item->data_values->blog_image) }}"
                                                    alt="@lang('image')">
                                            </a>
                                            <div>
                                                <h6>
                                                    <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                                                        @if (strlen(__($item->data_values->title)) > 22)
                                                            {{ substr(__($item->data_values->title), 0, 22) . '...' }}
                                                        @else
                                                            {{ __($item->data_values->title) }}
                                                        @endif
                                                    </a>
                                                </h6>
                                                <p>
                                                    <i class="fa-regular fa-calendar"></i>{{ showDateTime($item->created_at) }}
                                                </p>
                                            </div>
                                        </div>
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
