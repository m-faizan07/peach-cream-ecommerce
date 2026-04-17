@extends('frontend.main.app')

@section('title', 'Contact Us | Peach Cream')

@section('content')

    <!-- Main Contact Section -->
    <section class="contact-main-section">
        <h1 class="contact-main-title">Contact Us</h1>

        <div class="contact-container">
            <!-- Left Info Area -->
            <div class="contact-left">
                <h2>Get in Touch</h2>
                <p class="contact-subtitle">Get in touch with our team for a free consultation</p>

                <div class="contact-info-list">
                    <div class="contact-item-card">
                        <div class="contact-icon-wrapper">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="contact-text-wrapper">
                            <h3>Office</h3>
                            <p>123 AMD Solutions, 23 ST<br>New York, NY 2201</p>
                        </div>
                    </div>

                    <div class="contact-item-card">
                        <div class="contact-icon-wrapper">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <div class="contact-text-wrapper">
                            <h3>Email Us</h3>
                            <p>Support@Amdsol.com<br>Head@Amdsol.com</p>
                        </div>
                    </div>

                    <div class="contact-item-card">
                        <div class="contact-icon-wrapper">
                            <i class="fa-solid fa-phone-volume"></i>
                        </div>
                        <div class="contact-text-wrapper">
                            <h3>Call Us</h3>
                            <p>1-847-737-3401<br>1-847-737-3501</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Image Area -->
            <div class="contact-right">
                <div class="contact-image-split">
                    <img src="images/contact-office.png" alt="Office Building" class="office-img">
                    <img src="images/contact-map.png" alt="Location Map" class="map-img">
                </div>
            </div>
        </div>
    </section>


    <!-- Contact CTA Section - Tell us about yourself -->
    <section class="contact-cta-section">
        <div class="contact-cta-content">
            <h1 class="contact-cta-title">Send us a message</h1>
            <p class="contact-cta-subtitle">Do you have any question? A complaint? Feel free to contact us</p>
        </div>
    </section>

    <section class="contact-form-section">
        <div class="contact-form-container">
            <div class="contact-form-box">
                <form>
                    <div class="contact-form-row">
                        <div class="contact-form-group">
                            <label class="contact-form-label">First Name</label>
                            <input type="text" class="contact-form-input">
                        </div>
                        <div class="contact-form-group">
                            <label class="contact-form-label">Last Name</label>
                            <input type="text" class="contact-form-input">
                        </div>
                    </div>
                    <div class="contact-form-group" style="margin-bottom: 24px;">
                        <label class="contact-form-label">Email</label>
                        <input type="email" class="contact-form-input">
                    </div>
                    <div class="contact-form-group" style="margin-bottom: 24px;">
                        <label class="contact-form-label">Phone</label>
                        <input type="tel" class="contact-form-input">
                    </div>
                    <div class="contact-form-group" style="margin-bottom: 24px;">
                        <label class="contact-form-label">Message</label>
                        <textarea class="contact-form-textarea"></textarea>
                    </div>
                    <div class="contact-form-checkbox-wrapper">
                        <input type="checkbox" class="contact-form-checkbox" id="consent">
                        <label for="consent" class="contact-form-checkbox-label">By Clicking On This Box, You
                            Consent To Receive SMS Messages From Peach Cream And Agree To The <a href="#">Privacy
                                Policy</a>.</label>
                    </div>
                    <div class="contact-form-submit-wrapper">
                        <button type="submit" class="contact-form-submit">Get Started</button>
                    </div>
                </form>
            </div>
        </div>
    </section>


@endsection