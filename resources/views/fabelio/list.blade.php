<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>Fabelio Scraper</title>
        <style>
            @font-face 
            {
                /*I obtained from https://fabelio.com/static/version1584632702/frontend/Fabelio/aurela/id_ID/fonts/Fabelio/Regular/Fabelio-45Regular.woff*/
                font-family: Fabelio;
                src: url('{{ asset('fonts/fabelio.woff') }}');
            }

            *
            {
                outline: none;
            }

            html, body
            {
                height: 100%;
                min-height: 100%;
                font-family: Fabelio;
            }

            body
            {
                margin: 0;
                background-color: #fed541;
            }

            .tb
            {
                display: table;
                width: 100%;
            }

            .td
            {
                display: table-cell;
                vertical-align: middle;
            }

            input, button, span
            {
                color: #000;
                padding: 0;
                margin: 0;
                border: 0;
                background-color: transparent;
            }

            .center{
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
            }

            #cover
            {
                width: 850px;
                padding: 35px;
                margin: -83px auto 0 auto;
                background-color: #ffffff;
                border-radius: 20px;
                box-shadow: 0 10px 40px #a0a0a0, 0 0 0 20px #ffffffeb;
                transform: scale(0.6);
            }

            form
            {
                height: 96px;
            }

            input[type="text"]
            {
                width: 100%;
                height: 96px;
                font-size: 60px;
                line-height: 1;
            }

            input[type="text"]::placeholder
            {
                color: #000;
            }

            #s-cover
            {
                width: 1px;
                padding-left: 35px;
            }

            button
            {
                position: relative;
                display: block;
                width: 84px;
                height: 96px;
                cursor: pointer;
            }

            #s-circle
            {
                position: relative;
                top: -8px;
                left: 0;
                width: 43px;
                height: 43px;
                margin-top: 0;
                border-width: 15px;
                border: 15px solid #000;
                background-color: transparent;
                border-radius: 50%;
                transition: 0.5s ease all;
            }

            button span
            {
                position: absolute;
                top: 68px;
                left: 43px;
                display: block;
                width: 45px;
                height: 15px;
                background-color: transparent;
                border-radius: 10px;
                transform: rotateZ(52deg);
                transition: 0.5s ease all;
            }

            button span:before, button span:after
            {
                content: '';
                position: absolute;
                bottom: 0;
                right: 0;
                width: 45px;
                height: 15px;
                background-color: #000;
                border-radius: 10px;
                transform: rotateZ(0);
                transition: 0.5s ease all;
            }

            #s-cover:hover #s-circle
            {
                top: -1px;
                width: 67px;
                height: 15px;
                border-width: 0;
                background-color: #000;
                border-radius: 20px;
            }

            #s-cover:hover span
            {
                top: 50%;
                left: 56px;
                width: 25px;
                margin-top: -9px;
                transform: rotateZ(0);
            }

            #s-cover:hover button span:before
            {
                bottom: 11px;
                transform: rotateZ(52deg);
            }

            #s-cover:hover button span:after
            {
                bottom: -11px;
                transform: rotateZ(-52deg);
            }
            #s-cover:hover button span:before, #s-cover:hover button span:after
            {
                right: -6px;
                width: 40px;
                background-color: #000;
            }

            #message{
                text-align: center;
                margin-left: 40%;
                margin-right: 40%;
                margin-top: 100px;
                font-size: 30px;
            }
            
            .alert{
                color: #ff1a1a;
            }

            .container{
                width: 100%;
            }            

            #gallery{
                padding: 0;
            }

            .product{
                padding: 5px;
            }

            .item{
                width: 25%;
                float: left;
                margin-bottom: 50px;
            }

            #list .item{
                width: 25%;
                float: left;
                margin-bottom: 50px;
            }

            #list .item .image{
                width: 100%;
            }

            #list .item .desc{
                width: 100%;
            }

            img{
                width: 100%;
            }

            section{
                margin-bottom: 50px;
                text-align: center;
            }

            section h1{
                font-size: 60px;
            }

            section h2{
                font-size: 20px;
            }

            section p{
                margin-left: 25%;
                margin-right: 25%;
            }

            #detail .price{
                font-size: 25px;
            }

            #detail .price .discount{
                text-decoration: line-through;
                color: #ff1a1a;
            }

            .tooltip {
              pointer-events: none;
              position: absolute;
              background-color: white;
              min-width: 100px;
              display: none;
              height: auto;
              text-align: center;
              color: #5B6770;
              box-shadow: 0px 3px 9px 9px rgba(0, 0, 0, .15);
              padding: 15px;
              border-radius: 10px;
            }
        </style>
    <script src="https://d3js.org/d3.v3.min.js"></script>
</head>

<body>
    <section>
        <div class="container">
            <section id="detail">
                <h1>All Fabelio Products</h1>
            </section>
            <section id="list">
                @foreach($results as $result)
                <a href="{{$result['id']}}">
                    <div class="item">
                        <div class="product">
                            <div class="image">
                                <img src="{{$result['product_image_url']}}">
                            </div>
                            <div class="desc">
                                <h3>{{$result['name']}}</h3>
                                <h4>{{$result['final_price']}}</h3>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </section>
        </div>
    </section>
</body>

</html>