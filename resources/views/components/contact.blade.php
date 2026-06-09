<div id="contact" class="contact-us section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.25s">
                <div class="section-heading">
                    <h2>Hubungi kami kapanpun, <em style="color: #0e8433">Siap melayani</em> kebutuhan Air Mineral Anda
                    </h2>

                    <div class="phone-info">
                        <h4>Hubungi kami: <span><i class="fa fa-phone"></i> <a href="https://wa.me/6282245429508" target="_blank" rel="noopener">+62 82245429508</a></span></h4>
                    </div>

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.6915726974703!2d112.69941120000001!3d-7.4992627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e1a6fdab533f%3A0x506429855fddb2f8!2sDistributor%20Air%20Mineral%20Santri!5e0!3m2!1sen!2sid!4v1719222277104!5m2!1sen!2sid"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.25s">
                <form id="contact" action="{{ route('feedbacks') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <fieldset>
                                <input type="name" name="firstname" id="name" placeholder="First Name"
                                    autocomplete="on" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-6">
                            <fieldset>
                                <input type="surname" name="lastname" id="surname" placeholder="Last Name"
                                    autocomplete="on" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*"
                                    placeholder="Your Email" required="">
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <input type="text" name="phone" id="phone" pattern="[0-9]*"
                                    placeholder="Your Phone" required="">
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <textarea name="message" type="text" class="form-control" id="message" placeholder="Message" required=""></textarea>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <button type="submit" id="form-submit" class="main-button ">Send Message</button>
                            </fieldset>
                        </div>
                    </div>
                    <div class="contact-dec">
                        <img src="{{ asset('assets/images/contact-decoration.png') }}" alt="">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
