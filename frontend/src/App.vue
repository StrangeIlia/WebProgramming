<template>
  <div id="app">
    <div id="nav">
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link>
    </div>
    <router-view/>
  </div>
</template>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}

html{
  height: 100%;
}

body{
  display: flex;
  flex-direction: column;
  min-height: 100%;
  margin: 0;
}

.content {
  flex-grow: 1;
}

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
