<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>Fabelio Scraper</title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
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
                                <h4>Rp. {{number_format($result['final_price'])}}</h3>
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