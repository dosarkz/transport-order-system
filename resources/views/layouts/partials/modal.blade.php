<!-- MODALS -->
<div class="modal-wrapper">

    <div class="modal-cabinet">
        <div class="modal-close"><img src="./img/close.svg" alt=""></div>

        <form method="post" action="/cabinet/login">
            {{csrf_field()}}

            <div class="call-row">
                <div class="call-input">
                    <div class="call-svg">
                        <img src="./img/phone.svg" alt="">
                    </div>
                    <input type="tel" name="phone" id="client-tel-for-consult" placeholder="Номер телефона" >
                </div>
            </div>

            <div class="call-row">
                <div class="call-input">
                    <input type="password" name="password" placeholder="Пароль" >
                </div>
            </div>

            <div class="call-row"><button type="submit" class="btn-call">ОТПРАВИТЬ</button></div>

            <div class="call-row"><a href="/cabinet/password"><p>забыли пароль?</p></a></div>

        </form>
    </div>
</div>

<div class="modal-offer">
    <object data="/public_offer.pdf" type="application/pdf">
        alt : <a href="/public_offer.pdf">test.pdf</a>
    </object>
</div>


<div class="modal-back"></div>
