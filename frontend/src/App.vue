<template>
  <div>

    <div class = "content">
      <header class="bg-dark" >
        <div class = "navbar navbar-expand">
          <div class = "navbar-site-name header-site-name">Кто - то там интертеймент</div>
          <div><form id="search-form" class="style-score ytd"></form></div>
          <div class="navbar-nav ml-auto">
            <div class="content">
              <a class="m-auto" href="LoginPage.html">
                <button type="submit" class="btn btn-primary m-auto">Вход</button>
              </a>
              <a class="m-auto" href="RegistrationPage.html">
                <button type="submit" class="btn btn-primary m-auto">Регистрация</button>
              </a>
            </div>
          </div>
        </div>
      </header>

      <router-view/>

    </div>

    <footer class="text-mutex">
      <div class="container">
        <p class="float-right">Кто - то там интертеймент. Прав вообще нет</p>
      </div>
    </footer>

  </div>
</template>

<style>
.header-site-name {
  font-size: 30px;
  font-family: "Times New Roman", Times, serif;
  letter-spacing: 6px;
  word-spacing: -5px;
  color: #FFFFFF;
  font-weight: normal;
  text-decoration: none;
  font-style: italic;
  font-variant: normal;
  text-transform: none;
}
</style>

