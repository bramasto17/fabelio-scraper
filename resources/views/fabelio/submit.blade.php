<!-- Credits to : https://codepen.io/himalayasingh/pen/dqjLgO -->
<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title>Fabelio Scraper</title>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <section id="bio">
            <h1>Fabelio Scraper</h1>
            <p>By Bramasto Wibisono</p>
            <p>
                <a href="https://github.com/bramasto17">
                    <img class="social" src="https://cdn.iconscout.com/icon/free/png-256/github-153-675523.png">
                </a>
                <a href="https://www.linkedin.com/in/bramasto-wibisono/">
                    <img class="social" src="https://cdn1.iconfinder.com/data/icons/black-socicons/512/linkedin-512.png">
                </a>
            </p>
        </section>
    </div>
    <div class="center" id="cover">
        {!! Form::open() !!}
        <div class="tb">
          <div class="td">
            <input type="text" name="url" id="url" class="gui-input" placeholder="Fabelio Product URL">
        </div>
        <div class="td" id="s-cover">
            <button type="submit">
              <div id="s-circle"></div>
              <span></span>
            </button>
        </div>
        {!! Form::close() !!}
        </div>
        @if(Session::has('flash_message'))
            <div class="center">
            </div>
        @endif
      </form>
    </div>
    @if(Session::has('flash_message'))
    <div class="center" id="message">
        <span class="alert">{{ Session::get('flash_message') }}</span>
    </div>
    @endif
</body>

</html>