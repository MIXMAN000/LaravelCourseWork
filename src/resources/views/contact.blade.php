@extends('blades/template')
@section('title', 'Контакты')
@section('content')
  <h1 class="m-4 mb-0">Контакты</h1>
  <h3 class="m-4 mb-0">Мы всегда рады вашим вопросам, отзывам и предложениям! Свяжитесь с нами удобным для вас способом, и
    мы постараемся ответить как можно скорее.</h3>

  <div class="bg-light m-4 p-4">
    <h4>Свяжитесь с нами:</h4>
    <p><strong>Телефон:</strong> 8-900-083-92-46</p>
    <p><strong>Почта:</strong> mishabogatov2007@gmail.com</p>
    <p class="d-inline-flex justify-content-start gap-2 align-items-center">
      <strong>Соц. сети:</strong>
      <a href="https://telegram.org"><img src="/images/sociality/telegram.png" alt="telegram"></a>
      <a href="https://vk.com"><img src="/images/sociality/vk.png" alt="vk.com"></a>
      <a href="https://youtube.com"><img src="/images/sociality/youtube.png" alt="youtube"></a>
    </p>

  </div>
    <div class="content m-4 p-4 bg-light">
    <h2>Адрес</h2>
    <div style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/56/chelyabinsk/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Челябинск</a><a href="https://yandex.ru/maps/56/chelyabinsk/house/ulitsa_stalevarov_21/YkgYcgdjQUcOQFtvfX50d39gYA==/?ll=61.403541%2C55.256388&mode=search&sctx=ZAAAAAgAEAAaKAoSCZjArbt5TE5AERlYx%2FFDa0xAEhIJ%2B1xtxf6y0D8RgIC1ateEvD8iBgABAgMEBSgKOABA2JwGSAFqAnJ1nQHNzMw9oAEAqAEAvQEKMKPOwgEZAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIICF9GB0YLQsNC70LXQstCw0YDQvtCyIDIxigIAkgIAmgIMZGVza3RvcC1tYXBz&sll=61.403829%2C55.256334&sspn=0.010538%2C0.004688&text=%D1%81%D1%82%D0%B0%D0%BB%D0%B5%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%2021&utm_medium=mapframe&utm_source=maps&z=16.73" style="color:#eee;font-size:12px;position:absolute;top:14px;">Улица Сталеваров, 21 — Яндекс Карты</a><iframe src="https://yandex.ru/map-widget/v1/?ll=61.403541%2C55.256388&mode=search&ol=geo&ouri=ymapsbm1%3A%2F%2Fgeo%3Fdata%3DCgg1NjAzMjE0MhJF0KDQvtGB0YHQuNGPLCDQp9C10LvRj9Cx0LjQvdGB0LosINGD0LvQuNGG0LAg0KHRgtCw0LvQtdCy0LDRgNC-0LIsIDIxIgoNhZ11QhV8Bl1C&sctx=ZAAAAAgAEAAaKAoSCZjArbt5TE5AERlYx%2FFDa0xAEhIJ%2B1xtxf6y0D8RgIC1ateEvD8iBgABAgMEBSgKOABA2JwGSAFqAnJ1nQHNzMw9oAEAqAEAvQEKMKPOwgEZAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIICF9GB0YLQsNC70LXQstCw0YDQvtCyIDIxigIAkgIAmgIMZGVza3RvcC1tYXBz&sll=61.403829%2C55.256334&sspn=0.010538%2C0.004688&text=%D1%81%D1%82%D0%B0%D0%BB%D0%B5%D0%B2%D0%B0%D1%80%D0%BE%D0%B2%2021&z=16.73" width="100%" height="500" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>
  </div>

  <div class="content m-4 p-4 bg-light">
    <h2>Нпишите нам прямо сейчас</h2>
    <form action="#" method="post" class="w-50 m-auto">
      @csrf
      <div class="mt-3">
        <label for="name" class="form-label">Имя:</label>
        <input type="text" class="form-control" name="name" id="name">
      </div>
      <div class="mt-3">
        <label for="email" class="form-label">Почта:</label>
        <input type="email" class="form-control" name="email" id="email">
      </div>
      <div class="mt-3">
        <label for="theme" class="form-label">Тема обращения:</label>
        <select name="theme" id="theme" class="form-control">
          <option value="" disabled>Выберите тему:</option>
          <option value="Вопрос по заказу">Вопрос по заказу</option>
          <option value="Сотрудничество">Сотрудничество</option>
          <option value="Жалоба">Жалоба</option>
          <option value="Другое">Другое</option>
        </select>
      </div>
      <div class="mt-3">
        <label for="text" class="form-label">Текст обращения:</label>
        <textarea name="text" id="text" class="form-control">Здравствуйте, </textarea>
      </div>

      <input type="submit" value="Отправить" class="btn btn-primary w-100 mt-3">
    </form>
  </div>
  <div class="content m-4 p-4 bg-light">
    <p>Спасибо, что выбрали наш магазин настольных игр! Мы не просто продаем коробки с правилами, мы помогаем вам создавать незабываемые вечера в кругу друзей и семьи. Ваше удовольствие от игры – наша главная цель.</p>
  </div>
@endsection