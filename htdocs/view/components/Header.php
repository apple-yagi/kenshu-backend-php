<header class="header">
  <div class="header__container">
    <ul class="header__list">
      <li class="header__item">
        <a href="/">トップ</a>
      </li>
      <li class="header__item">
        <a href="/users/">ユーザ一覧</a>
      </li>
      <li class="header__item">
        <a href="/articles">記事一覧</a>
      </li>
      <li class="header__item">
        <a href="/tags">タグ一覧</a>
      </li>
    </ul>
    <?php if (isset($_SESSION['username'])) : ?>
      <ul class="header__list">
        <li class="header__item">
          <a href="/mypage">マイページ</a>
        </li>
        <li class="header__item">
          <a href="/articles/new">新規投稿</a>
        </li>
        <li class="header__item">
          <a href="/tags/new">新規タグ作成</a>
        </li>
        <li class="header__item">
          <a href="/auth/logout">ログアウト</a>
        </li>
      </ul>
    <?php else : ?>
      <ul class="header__list">
        <li class="header__item">
          <a href="/auth/login">ログイン</a>
        </li>
        <li class="header__item">
          <a href="/auth/register">サインアップ</a>
        </li>
      </ul>
    <?php endif; ?>
  </div>
</header>