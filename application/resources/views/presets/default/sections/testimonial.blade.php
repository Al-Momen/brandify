 @php
     $testimonialSectionContent = getContent('testimonial.content', true);
     $testimonialSectionElements = getContent('testimonial.element', false, false, true);
 @endphp

 <!--==========================  Testimonial Section Start  ==========================-->
 <section class="testimonial__area my-120">
     <div class="container">
         <div class="row">
             <div class="col-lg-12">
                 <div class="testimonial__wrap">
                     <div class="testimonial__sp">
                         <img src="{{ getImage(getFilePath('testimonial') . 'testamonil1.png') }}"
                             alt="@lang('image')">
                     </div>
                     <div class="testimonial__sp two">
                         <img src="{{ getImage(getFilePath('testimonial') . 'testamonil2.png') }}"
                             alt="@lang('image')">
                     </div>
                     <div class="swiper testimonial__slider">
                         <div class="swiper-wrapper">
                             @foreach ($testimonialSectionElements ?? [] as $item)
                                 <div class="swiper-slide">
                                     <div class="testimonial__single">
                                         <img src="{{ getImage(getFilePath('testimonial') . $item->data_values->image) }}"
                                             alt="@lang('image')">
                                         <h4>{{ __($item->data_values->name) }}</h4>
                                         <h5>@lang('From') {{ __($item->data_values->location) }}</h5>
                                         <p>
                                             {{ __($item->data_values->title) }}
                                         </p>
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                         <div class="swiper-pagination"></div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <!--==========================  Testimonial Section End  ==========================-->
