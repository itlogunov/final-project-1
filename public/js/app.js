$(document).ready(function () {

    $('#order-form').on('submit', function (e) {
        e.preventDefault();

        let $this = $(this);
        let data = $(this).serialize();

        $this.css('opacity', 0.5);
        $.ajax({
            'type': 'post',
            'url': 'src/create_new_order.php',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.order) {
                    $this.remove();
                    $('#order-form-title').text('Спасибо, заказ успешно создан! Данные отправлены Вам на почту!');
                } else {
                    alert(data.errors);
                    $this.css('opacity', 1);
                }
            }
        });

        return false;
    });

    $('.phone-mask').mask('+7 (999) 999-99-99');
    onlyNumbers($('.number-mask'));

});

function onlyNumbers (el) {
    el.on('change keyup input click', function () {
        if (this.value.match(/[^0-9]/g)) {
            this.value = this.value.replace(/[^0-9]/g, "");
        }
    });

    return false;
}