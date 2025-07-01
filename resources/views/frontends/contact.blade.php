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
                                    <form class="form">
                                        <div class="form-row">
                                            <div class="form-group col-12" data-aos="fade-in">
                                                <label class="label-form font-text-bold" for="name-title">Title</label>
                                                <select class="form-control" id="name-title-nav" name="input-name-title">
                                                    <option value="" class="placeholder" hidden>Title</option>
                                                    <option value="">Mr.</option>
                                                    <option value="">Mrs.</option>
                                                    <option value="">Ms.</option>
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
                                            <div class="form-group col-6" data-aos="fade-in">
                                                <label class="label-form font-text-bold" for="subject-input-example">Subject</label>
                                                <input type="text" class="form-control" id="subject-input-example" name="subject" placeholder="Subject" required>
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
                        <div class="col-md-6 faq-col">
                            <div class="faq-area">
                                <div class="title-detail" data-aos="fade-in">
                                    <h5 class="font-text-bold">FAQ Digital Door Lock</h5>
                                </div>
                                <div class="faq-content" data-aos="fade-in">
                                    <div class="accordion custom-accordion" id="accordionExample">
                                        <div class="accordion-list">
                                            <div class="accordion-head" id="headingOne">
                                                <h5 class="toggle-collapse" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Berapa ketebalan pintu dan lebar frame minimum pintu agar bisa di pasang digital door lock?
                                                </h5>
                                            </div>
                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p>
                                                        Untuk produk pushpull digital door lock Samsung, digital door lock keywe dan epic ketebalan pintu min. adalah 3.8 cm dan lebar min. 12 cm, namun untuk produk Tipe DeadBolt min. 3.3 cm dan lebar 12 cm. Khusus digital door lock tanpa handle / tipe RIM tidak ada ketebalan pintu minimum karena dalam proses instalasi tidak perlu membobok kunci pintu lama untuk diganti dengan mortise (tipe ini tidak ada mortise).
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-list">
                                            <div class="accordion-head" id="headingTwo">
                                                <h5 class="toggle-collapse collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Berapa default master password dan apakah mungkin diganti?
                                                </h5>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p>
                                                        Pin / Password awal adalah "1234". Tentu dapat diganti, tata caranya ada dalam buku manual.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-list">
                                            <div class="accordion-head" id="headingThree">
                                                <h5 class="toggle-collapse collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    Jika Baterai sudah terlanjur habis, Bagaimana cara membuka Kunci Digital / Smart Digital Lock?
                                                </h5>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p>
                                                        <strong>Ada 2 cara yang dapat dilakukan.</strong>
                                                    </p>
                                                    <ol>
                                                        <li>
                                                            Pertama dapat memberikan daya sementara menggunakan baterai 9 Volt, dengan cara menempelkan pada contact point di Smart Digital Lock. Lalu lanjutkan membuka dengan kartu, password atau sidik jari untuk masuk.
                                                        </li>
                                                        <li>
                                                            Alternatif ke dua, jika kamu menggunakan tipe mortise kamu dapat menggunakan kunci manual untuk membuka pintu.
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 faq-col">
                            <div class="faq-area">
                                <div class="title-detail" data-aos="fade-in">
                                    <h5 class="font-text-bold">FAQ Suprema Biometrics Access Control</h5>
                                </div>
                                <div class="faq-content" data-aos="fade-in">
                                    <div class="accordion custom-accordion" id="accordionExample2">
                                        <div class="accordion-list">
                                            <div class="accordion-head" id="headingFour">
                                                <h5 class="toggle-collapse" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                    Apa peran Lumbatech dalam menyediakan solusi Suprema Biometrics?
                                                </h5>
                                            </div>
                                            <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordionExample2">
                                                <div class="accordion-body">
                                                    <p>
                                                        Sebagai mitra resmi dari Suprema, Lumbatech tidak hanya menyediakan produk biometrik seperti BioStation, Biolite dan BioEntry, tetapi juga menawarkan layanan yang menyeluruh, mulai dari konsultasi hingga instalasi dan integrasi dengan sistem keamanan lainnya. Kami memastikan bahwa setiap solusi biometrik yang Anda pilih sesuai dengan kebutuhan spesifik dan dapat dioperasikan dengan optimal di lingkungan Anda.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-list">
                                            <div class="accordion-head" id="headingFive">
                                                <h5 class="toggle-collapse collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                    Apakah Lumbatech dapat mengintegrasikan Suprema Biometrics dengan Visitor Management System?
                                                </h5>
                                            </div>
                                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample2">
                                                <div class="accordion-body">
                                                    <p>
                                                        Tentu saja. Lumbatech memiliki pengalaman dalam mengintegrasikan perangkat Suprema dengan berbagai sistem, termasuk Visitor Management System bersama Simplo. Baik untuk Golf Center, Shared atau virtual Office, Bandara, atau fasilitas lainnya, kami dapat membantu Anda menciptakan alur akses yang efisien dan aman, di mana pengelolaan pengunjung dapat dilakukan secara otomatis dan real-time.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-list">
                                            <div class="accordion-head" id="headingSix">
                                                <h5 class="toggle-collapse collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                    Bagaimana proses instalasi perangkat Suprema yang dilakukan oleh Lumbatech?
                                                </h5>
                                            </div>
                                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample2">
                                                <div class="accordion-body">
                                                    <p>
                                                        Proses instalasi dilakukan oleh tim teknisi berpengalaman yang memastikan setiap perangkat Suprema terpasang sesuai standar dan berfungsi optimal. Kami juga menyediakan panduan penggunaan dan dokumentasi instalasi untuk memudahkan tim Anda dalam memahami sistem yang diterapkan.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection