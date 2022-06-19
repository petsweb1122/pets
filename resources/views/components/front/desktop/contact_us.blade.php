<style>
    section input,
    section textarea,
    select {
        display: block;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #8bc540;
        outline: 0;
        background-color: #ffffff;
        padding: 10px;
        margin-bottom: 10px;
        letter-spacing: 1.4px;
    }

</style>


<div class="content-area contact-us">

    <h1>GET IN TOUCH</h1>
    <hr>
    <div class="blocks">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d43360.7153214343!2d-115.18789780703135!3d36.12262162817479!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c8c4443ea55555%3A0x501fcfabd149fea5!2sPetssified!5e0!3m2!1sen!2s!4v1570822515178!5m2!1sen!2s"
            width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
        <table>
            <tbody>
                <tr>
                    <td><i class="fa fa-map-marker" aria-hidden="true"></i></td>
                    <td><a title="See on map"
                            href="https://www.google.com/maps?ll=36.119679,-115.158054&amp;z=12&amp;t=m&amp;hl=en&amp;gl=US&amp;mapclient=embed&amp;cid=5773561584169909925">
                            3773 Howard Hughes Pkwy, Las Vegas, NV 89169, United States</a>
                    </td>
                </tr>
                <tr>
                    <td><i class="fa fa-phone" aria-hidden="true"></i></td>
                    <td><a title="tel:+1-213-442-5200" href="tel:+1-213-442-5200">+1-213-442-5200</a></td>
                </tr>
                <tr>
                    <td><i class="fa fa-envelope" aria-hidden="true"></i></td>
                    <td><a href="mailto:contact@petssified.com"
                            title="contact@petssified.com">contact@petssified.com</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="blocks">
        @php
            $errors = session()->get('errors');
            $message = !empty(session()->get('message')) ? session()->get('message') : '';
            $message_class = !empty(session()->get('errors')) ? 'label-danger' : 'label-success';
        @endphp
        @if (!empty(session()->get('message')))
            <div class="error-block">
                <h4>{{ session()->get('message') }}</h4>
            </div>
        @endif
        @if (!empty(session()->get('errors')))
            @foreach (session()->get('errors') as $error)
                <div class="alert alert-warning" role="alert">
                    <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="exclamation-triangle"
                        role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                        class="svg-inline--fa fa-exclamation-triangle fa-w-18 fa-2x">
                        <path fill="currentColor"
                            d="M270.2 160h35.5c3.4 0 6.1 2.8 6 6.2l-7.5 196c-.1 3.2-2.8 5.8-6 5.8h-20.5c-3.2 0-5.9-2.5-6-5.8l-7.5-196c-.1-3.4 2.6-6.2 6-6.2zM288 388c-15.5 0-28 12.5-28 28s12.5 28 28 28 28-12.5 28-28-12.5-28-28-28zm281.5 52L329.6 24c-18.4-32-64.7-32-83.2 0L6.5 440c-18.4 31.9 4.6 72 41.6 72H528c36.8 0 60-40 41.5-72zM528 480H48c-12.3 0-20-13.3-13.9-24l240-416c6.1-10.6 21.6-10.7 27.7 0l240 416c6.2 10.6-1.5 24-13.8 24z"
                            class=""></path>
                    </svg> {{ $error }}
                </div>
            @endforeach
        @endif

        <form method="POST" action="{{ url('/contact-us.html') }}">
            @csrf
            <div class="form-group">
                <label for="form_name">First Name *</label><br>
                <input id="form_name" type="text" name="first_name" class="form-control"
                    placeholder="Please enter your firstname *" value="{{ old('first_name') }}" required="required" data-error="Firstname is required.">
                <div class="help-block error-block"></div>
            </div>

            <div class="form-group">
                <label for="form_lastname">Last Name *</label><br>
                <input id="form_lastname" type="text" name="last_name" class="form-control"
                    placeholder="Please enter your lastname *" value="{{ old('last_name') }}" required="required" data-error="Lastname is required.">
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                <label for="form_email">Email *</label><br>
                <input id="form_email" type="email" name="email" class="form-control"
                    placeholder="Please enter your email *" required="required" value="{{ old('email') }}" data-error="Valid email is required.">
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                <label for="form_need">Please specify your need *</label>
                <select id="form_need" name="purpose" class="form-control" required="required"
                    data-error="Please specify your need.">
                    <option value=""></option>
                    <option value="Request quotation">Request quotation</option>
                    <option value="Request order status">Request order status</option>
                    <option value="Request copy of an invoice">Request copy of an invoice</option>
                    <option value="Other">Other</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group">
                <label for="form_message">Message *</label>
                <textarea id="form_message" name="message" class="form-control" placeholder="Message for me *"
                    rows="4" required="required" data-error="Please, leave us a message."></textarea>
                <div class="help-block with-errors"></div>
            </div>

            <input type="submit" class="btn btn-success btn-send" value="Send message">
        </form>
    </div>
</div>
