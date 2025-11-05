 @forelse ($blogs ?? [] as $item)
     <div class="col-lg-4 col-md-6">
         <div class="blog__card">
             <div class="blog__img">
                 <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}"><img
                         src="{{ getImage(getFilePath('blog') . 'thumb_' . $item->data_values->blog_image) }}"
                         alt="@lang('blog image')"></a>
                 <span>{{ showDateTime($item->created_at, 'd F, Y') }}</span>
             </div>
             <div class="blog__content">
                 <h5>
                     <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}">
                        @if (strlen(__($item->data_values->title)) > 55)
                             {{ strLimit(__($item->data_values->title), 55) }}
                         @else
                             {{ __($item->data_values->title) }}
                         @endif
                    </a>
                 </h5>
                 <p>
                    @if (strlen(__($item->data_values->description)) > 80)
                         @php echo strLimit(__($item->data_values->description), 80); @endphp
                     @else
                         @php echo $item->data_values->description; @endphp
                     @endif
                 </p>
                 <a href="{{ route('blog.details', ['slug' => slug($item->data_values->title), 'id' => $item->id]) }}" class="blog__btn">@lang('Read More')</a>
             </div>
         </div>
     </div>
 @empty
     <div class="col-12 text-center">
         <h6>@lang('No Data Found')</h6>
     </div>
 @endforelse
