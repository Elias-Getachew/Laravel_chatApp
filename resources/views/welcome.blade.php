<!DOCTYPE html>
<html lang="en">
<head>
  <title>Chat GPT Laravel | Code with Ross</title>
  <link rel="icon" href="https://assets.edlin.app/favicon/favicon.ico"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

  <link rel="stylesheet" href="/style.css">

</head>

<body>
<div class="chat">

  <div class="top">
    {{-- <img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar"> --}}
    <div>
      <p>Elias Getachew</p>
      <small>Online</small>
    </div>
    <div class="auth-links">
      @if (Auth::check())
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
      @endif
    </div>
  </div>

  <div class="messages">
    <div class="left message">
      {{-- <img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar"> --}}
      {{-- <p>Start chatting with Chat GPT AI below!!</p> --}}
    </div>
  </div>

  <div class="bottom">
    <form>
      <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
      <button type="submit"></button>
    </form>
  </div>

</div>
</body>

<script>
  $("form").submit(function (event) {
    event.preventDefault();

    if ($("form #message").val().trim() === '') {
      return;
    }

    $("form #message").prop('disabled', true);
    $("form button").prop('disabled', true);

    $.ajax({
      url: "/chat",
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': "{{csrf_token()}}"
      },
      data: {
        "model": "gpt-3.5-turbo",
        "content": $("form #message").val()
      }
    }).done(function (res) {
      $(".messages > .message").last().after('<div class="right message">' +
        '<p>' + $("form #message").val() + '</p>' +
        '<img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">' +
        '</div>');

      $(".messages > .message").last().after('<div class="left message">' +
        '<img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">' +
        '<p>' + res + '</p>' +
        '</div>');

      $("form #message").val('');
      $(document).scrollTop($(document).height());

      $("form #message").prop('disabled', false);
      $("form button").prop('disabled', false);
    });
  });
</script>
</html>
