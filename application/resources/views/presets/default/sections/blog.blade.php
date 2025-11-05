   @php
       $blogSectionContent = getContent('blog.content', true);
       $blogs = getContent('blog.element', false, 3, false);
   @endphp
   <!--==========================  Blog Section Start  ==========================-->
   <section class="blog__area my-120">
       <div class="container">
           <div class="row">
               <div class="col-lg-12">
                   <div class="section__heading mb-60 text-center">
                       <h3>{{ __($blogSectionContent->data_values->heading) }}</h3>
                       <p>
                           {{ __($blogSectionContent->data_values->subheading) }}
                       </p>
                   </div>
               </div>
           </div>
           <div class="row gy-4 justify-content-center">
               @include($activeTemplate . 'components.blog')
           </div>
       </div>
   </section>
   <!--==========================  Blog Section End  ==========================-->
