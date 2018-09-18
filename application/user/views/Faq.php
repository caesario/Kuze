<?php
include "layout/Header.php";
include "layout/Menu.php";
?>

    <div class="wrapper-cart">
        <h5 class="text-center c-title-cart">FAQ</h5>
        <div class="c-breadcrumb text-center c-bread-padding">
            <nav class="c-nav-breadcrumb c-bread-cart">
                <a class="breadcrumb-item" href="<?= site_url('Home'); ?>">Home</a>
                <i class="fa fa-arrow-right"></i>
                <a class="breadcrumb-item" href="<?= site_url('Faq'); ?>">FAQ</a>
            </nav>
        </div>
    </div>

    <div class="container mb-5">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="far fa-question-circle mr-2"></i>
                            <i class="float-right fa fa-plus"></i>
                            How Do I make Purchase?
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body container pt-4 pb-4 text-small">
                        Shopping at Kuze is easy: <br><br>

                        - Use the New Arrival, Sale Item, etc… links or choose item.
                        <br> - Once you have found an item, choose your size and click on the 'ADD TO CART' button on the product page.
                        <br> - Review the items in your shopping bag by clicking the 'SHOPPING CART' link at the top of the page.
                        <br> Click on 'PROCEED TO CHECKOUT' to complete your order.
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapseOne">
                            <i class="far fa-question-circle mr-2"></i>
                            <i class="float-right fa fa-plus"></i>
                            Do I need to create an account to place an order?
                        </a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body container pt-4 pb-4 text-small">
                        You can't shop at Kuze without creating an account.
                        However, sign up with us and you'll be able to enjoy the following benefits:<br><br>

                        - Track your orders and review past purchases<br>
                        - Preview our new collections and register your interest for your favorite pieces<br>
                        - Save your address so you can shop even quicker next time
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapseOne">
                            <i class="far fa-question-circle mr-2"></i>
                            <i class="float-right fa fa-plus"></i>
                            Is my personal information keep private?
                        </a>
                    </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body container pt-4 pb-4 text-small">
                        Please be assured that we take data protection seriously, and your information will only be shared with third parties where they abide by applicable data protection legislation. For more information, please read our privacy policy.
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapseOne">
                            <i class="far fa-question-circle mr-2"></i>
                            <i class="float-right fa fa-plus"></i>
                            Can I choose my currency I pay in?
                        </a>
                    </h4>
                </div>
                <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body container pt-4 pb-4 text-small">
                        No. the currency we use is rupiah / IDR
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="true" aria-controls="collapseOne">
                            <i class="far fa-question-circle mr-2"></i>
                            <i class="float-right fa fa-plus"></i>
                            How long does delivery take, and what are the charges?
                        </a>
                    </h4>
                </div>
                <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body container pt-4 pb-4 text-small">
                        Delivery time frame is between 10-12 working days and depending on the shipping company you choose
                    </div>
                </div>
            </div>



        </div><!-- panel-group -->
    </div>

    <script>

        function toggleIcon(e) {
            $(e.target)
                .prev('.panel-heading')
                .find(".float-right")
                .toggleClass('fa-plus fa-minus');
        }
        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);
    </script>



<?php
include "layout/Footer.php";
?>