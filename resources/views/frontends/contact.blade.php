@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
    <div class="page-content">
        <div class="breadcrumb-page" data-aos="fade-in">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('web_index') }}">
                                <span class="fa fa-home"></span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Hubungi Kami</li>
                    </ol>
                </nav>
            </div>
        </div>
        <section class="contact">
            <div class="container">
                <div class="title-page" data-aos="fade-in">
                    <h3 class="font-text-bold">Hubungi Kami</h3>
                </div>
                <div class="contact-inside">
                    <div class="row custom-form-row justify-content-center">
                        <div class="col-md-6 form-col">
                            <div class="contact-area">
                                <div class="title-detail" data-aos="fade-in">
                                    <h5 class="font-text-bold">Silahkan konsultasikan kebutuhan Anda</h5>
                                </div>
                                <div class="custom-form">
                                    <form class="form" method="POST" action="{{ route('web_add_question') }}" novalidate>
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-12" data-aos="fade-in">
                                                <label class="label-form font-text-bold" for="name-title">Title</label>
                                                <select class="form-control" id="name-title-nav" name="title" required>
                                                    <option value="" hidden selected>Title</option>
                                                    <option value="Mr"  @selected(old('name_title') === 'Mr')>Mr.</option>
                                                    <option value="Mrs" @selected(old('name_title') === 'Mrs')>Mrs.</option>
                                                    <option value="Ms"  @selected(old('name_title') === 'Ms')>Ms.</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6" data-aos="fade-in">
                                                <label class="label-form font-text-bold" for="name-input-example">Name</label>
                                                <input type="text" class="form-control" id="name-input-example" name="name" placeholder="Name" required>
                                            </div>
                                            <div class="form-group col-6" data-aos="fade-in">
                                                <label class="label-form font-text-bold" for="email-input-example">Email</label>
                                                <input type="email" class="form-control" id="email-input-example" name="email" placeholder="Email Address" required>
                                            </div>
                                            <div class="form-group col-6" data-aos="fade-in">
                                                <label class="label-form font-text-bold" for="phone-input-example">Phone</label>
                                                <input type="number" class="form-control" id="phone-input-example" name="phone" placeholder="Phone Number" required>
                                            </div>
                                            <div class="col-md-6" data-aos="fade-in">
                                                <label class="label-form font-text-bold" for="product-select">Product</label>
                                                <select class="form-control" id="product-select" name="product_name" required>
                                                    @foreach ($products as $value => $label)
                                                        <option value="{{ $value }}" @selected(old('product_name') === $value)>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12" data-aos="fade-in">
                                                <label class="label-form font-text-bold" for="message-input-example">Message</label>
                                                <textarea class="form-control" id="message-input-example" name="message" placeholder="Massage" required></textarea>
                                            </div>
                                        </div>
                                        <div class="button-area" data-aos="zoom-in">
                                            <button class="button full-width font-text-bold" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row custom-faq-row">
                        @foreach($faqs as $faq)
                        <div class="col-md-6 faq-col">
                            <div class="faq-area">
                                <div class="title-detail" data-aos="fade-in">
                                    <h5 class="font-text-bold">{{ $faq->name }}</h5>
                                </div>
                                <div class="faq-content" data-aos="fade-in">
                                    <div class="accordion custom-accordion" id="accordionExample">
                                        @foreach($faq->faqs as $item)
                                            <div class="accordion-list">
                                                <div class="accordion-head" id="headingOne{{ $item->id }}">
                                                    <h5 class="toggle-collapse" data-toggle="collapse" data-target="#collapseOne{{ $item->id }}" aria-expanded="true" aria-controls="collapseOne{{ $item->id }}">
                                                        {!! $item->question !!}
                                                    </h5>
                                                </div>
                                                <div id="collapseOne{{ $item->id }}" class="collapse show" aria-labelledby="headingOne{{ $item->id }}" data-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        {!! $item->answer !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection