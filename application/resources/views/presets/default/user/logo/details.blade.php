@extends($activeTemplate . 'layouts.master')
@section('content')
 <div class="dashboard__wrapper">
            <div class="row gy-4">
                <div class="col-xl-3 col-lg-4">
                    <div class="create__logo__wrapper">
                        <h3 class="create__logo__title">Create Logo</h3>
                        <div class="create__logo__item mb-3">
                            <input class="form-control" type="text" placeholder="Enter Your Brand Name">
                        </div>
                        <div class="create__logo__item">
                            <div class="dropdown">
                                <button class=" create__dropdown dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/images/dropdown1.png" alt=""> Select Style
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="create__logo__item">
                            <div class="dropdown">
                                <button class=" create__dropdown dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/images/dropdown2.svg" alt="..."> Color
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="create__logo__item">
                            <div class="dropdown">
                                <button class=" create__dropdown dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/images/dropdown3.svg" alt="...">Shape
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="create__logo__item">
                            <div class="dropdown">
                                <button class=" create__dropdown dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/images/dropdown3.svg" alt=""> Background
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="card">
                        <div class="create__logo__thumb">
                            <img class="w--100" src="assets/images/logo_view.png" alt="...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
