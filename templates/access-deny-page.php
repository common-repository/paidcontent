<style>

    html, body, .container {
        height: 100%;
        background-color: #FFFFFF;
        line-height: 2em;
    }

    .container {
        position: relative;
        text-align: center;

    }

    .container > div {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        margin-top: -9px;
    }
</style>
<div class="container">
    <div class="title">
        <h1><?php echo __('Oops! ... this is the paid content', 'paidcontent') ?></h1>
        <p class="sub-title">
        <p><a href="<?php echo wp_get_referer(); ?>"><?php echo __('Back', 'paidcontent') ?></a></p>
        </p>
    </div>

</div>

